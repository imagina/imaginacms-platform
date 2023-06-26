<?php

namespace Modules\Core\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Core\Blade\AsgardEditorDirective;
use Modules\Core\Console\DeleteModuleCommand;
use Modules\Core\Console\DownloadModuleCommand;
use Modules\Core\Console\InstallCommand;
use Modules\Core\Console\PublishModuleAssetsCommand;
use Modules\Core\Console\PublishThemeAssetsCommand;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\EditorIsRendering;
use Modules\Core\Events\Handlers\RegisterCoreSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Foundation\Theme\ThemeManager;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Nwidart\Modules\Module;

class CoreServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The filters base class name.
     *
     * @var array
     */
    protected $middleware = [
        'Core' => [
            'permissions' => 'PermissionMiddleware',
            'auth.admin' => 'AdminMiddleware',
            'public.checkLocale' => 'PublicMiddleware',
            'localizationRedirect' => 'LocalizationMiddleware',
            'localeSessionRedirect' => 'LocaleSessionRedirectMiddleware',
            'can' => 'Authorization',
        ],
    ];

    public function boot(): void
    {
        // Hot fix livewire endpoints prioritizing locale
        if (Str::contains(request()->path(), ['livewire/message'])) {
            $locale = request()->input()['fingerprint']['locale'] ?? locale();
            if (config('app.locale') != $locale) {
                app('laravellocalization')->currentLocale = $locale;
                $this->app->setLocale($locale);
            }
        }

        $this->publishConfig('core', 'available-locales');
        $this->publishConfig('core', 'config');
        $this->publishConfig('core', 'core');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('core', 'permissions'), 'asgard.core.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('core', 'settings'), 'asgard.core.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('core', 'settings-fields'), 'asgard.core.settings-fields');

        $this->registerMiddleware($this->app['router']);
        $this->registerModuleResourceNamespaces();

        $this->bladeDirectives();
        $this->app['events']->listen(EditorIsRendering::class, config('asgard.core.core.wysiwyg-handler'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('asgard.isInstalled', function () {
            return true === config('asgard.core.core.is_installed');
        });
        $this->app->singleton('asgard.onBackend', function () {
            return $this->onBackend();
        });

        $this->registerCommands();
        $this->registerServices();
        $this->setLocalesConfigurations();

        $this->app->bind('core.asgard.editor', function () {
            return new AsgardEditorDirective();
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('core', RegisterCoreSidebar::class)
        );
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('core', Arr::dot(trans('core::core')));
            $event->load('sidebar', Arr::dot(trans('core::sidebar')));
        });

        //Register Imagina Core CRUD
        $this->instanceICrud();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * Register the filters.
     *
     * @return void
     */
    public function registerMiddleware(Router $router): void
    {
        foreach ($this->middleware as $module => $middlewares) {
            foreach ($middlewares as $name => $middleware) {
                $class = "Modules\\{$module}\\Http\\Middleware\\{$middleware}";

                $router->aliasMiddleware($name, $class);
            }
        }
    }

    /**
     * Register the console commands
     */
    private function registerCommands()
    {
        $this->commands([
            InstallCommand::class,
            PublishThemeAssetsCommand::class,
            PublishModuleAssetsCommand::class,
            DownloadModuleCommand::class,
            DeleteModuleCommand::class,
        ]);
    }

    private function registerServices()
    {
        $this->app->singleton(ThemeManager::class, function ($app) {
            $path = $app['config']->get('asgard.core.core.themes_path');

            return new ThemeManager($app, $path);
        });

        $this->app->singleton('asgard.ModulesList', function () {
            return [
                'core',
                'dashboard',
                'media',
                'menu',
                'page',
                'setting',
                'tag',
                'translation',
                'user',
                'workshop',
            ];
        });
    }

    /**
     * Register the modules aliases
     */
    private function registerModuleResourceNamespaces()
    {
        $themes = [];

        // Saves about 20ms-30ms at loading
        if ($this->app['config']->get('asgard.core.core.enable-theme-overrides') === true) {
            $themeManager = app(ThemeManager::class);

            $themes = [
                'backend' => $themeManager->find(config('asgard.core.core.admin-theme'))->getPath(),
                'frontend' => $themeManager->find(setting('core::template', null, 'Flatly'))->getPath(),
            ];
        }

        foreach ($this->app['modules']->getOrdered() as $module) {
            $this->registerViewNamespace($module, $themes);
            $this->registerLanguageNamespace($module);
        }
    }

    /**
     * Register the view namespaces for the modules
     */
    protected function registerViewNamespace(Module $module, array $themes)
    {
        $hints = [];
        $moduleName = $module->getLowerName();

        if (is_core_module($moduleName)) {
            $configFile = 'config';
            $configKey = 'asgard.'.$moduleName.'.'.$configFile;

            $this->mergeConfigFrom($module->getExtraPath('Config'.DIRECTORY_SEPARATOR.$configFile.'.php'), $configKey);
            $moduleConfig = $this->app['config']->get($configKey.'.useViewNamespaces');

            if (count($themes) > 0) {
                if ($themes['backend'] !== null && Arr::get($moduleConfig, 'backend-theme') === true) {
                    $hints[] = $themes['backend'].'/views/modules/'.$moduleName;
                }
                if ($themes['frontend'] !== null && Arr::get($moduleConfig, 'frontend-theme') === true) {
                    $hints[] = $themes['frontend'].'/views/modules/'.$moduleName;
                }
            }
            if (Arr::get($moduleConfig, 'resources') === true) {
                $hints[] = base_path('resources/views/asgard/'.$moduleName);
            }
        }

        $hints[] = $module->getPath().'/Resources/views';

        $this->app['view']->addNamespace($moduleName, $hints);
    }

    /**
     * Register the language namespaces for the modules
     */
    protected function registerLanguageNamespace(Module $module)
    {
        $moduleName = $module->getLowerName();

        $langPath = base_path("lang/$moduleName");
        $secondPath = base_path("lang/translation/$moduleName");

        if ($moduleName !== 'translation' && $this->hasPublishedTranslations($langPath)) {
            return $this->loadTranslationsFrom($langPath, $moduleName);
        }
        if ($this->hasPublishedTranslations($secondPath)) {
            return $this->loadTranslationsFrom($secondPath, $moduleName);
        }
        if ($this->moduleHasCentralisedTranslations($module)) {
            return $this->loadTranslationsFrom($this->getCentralisedTranslationPath($module), $moduleName);
        }

        return $this->loadTranslationsFrom($module->getPath().'/Resources/lang', $moduleName);
    }

    /**
     * @param $package
     * @return string
     */
    private function getConfigFilename($file): string
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));
    }

    /**
     * Set the locale configuration for
     * - laravel localization
     * - laravel translatable
     */
    private function setLocalesConfigurations()
    {
        if ($this->app['asgard.isInstalled'] === false) {
            return;
        }

        //I have to put this validation because our default supportedLocales are (en and es)
        //and we have a lot seeders setting in DB that two locales in the DB, so it was more easy set here the exception
        // to avoid set locales conf only when the console command is module:seed but we need to improve the seeders for a
        // dynamic locales seeders by example: Modules/Iblog/Database/Seeders/LayoutsBlogTableSeeder.php
        if (app()->runningInConsole()) {
            $command = request()->server('argv');

            if (is_array($command) && isset($command[1]) && $command[1] == 'module:seed') {
                return;
            }
        }

        $localeConfig = $this->app['cache']
          ->tags('setting.settings'.(tenant()->id ?? ''), 'global')
          ->remember(
              'asgard.locales',
              120,
              function () {
                  return DB::table('setting__settings')->whereName('core::locales')->first();
              }
          );

        if ($localeConfig) {
            $locales = json_decode($localeConfig->plainValue);
            $availableLocales = [];
            foreach ($locales as $locale) {
                $availableLocales = array_merge($availableLocales, [$locale => config("available-locales.$locale")]);
            }

            $laravelDefaultLocale = $this->app->config->get('app.locale');

            if (! in_array($laravelDefaultLocale, array_keys($availableLocales))) {
                $this->app->config->set('app.locale', array_keys($availableLocales)[0]);
            }

            //domains locales configuration. Based in the config domainsLocales{app_env}
            $configName = 'domainsLocales';

            (env('APP_ENV', 'local') == 'local') ? $configName .= 'Local' : $configName .= 'Prod';

            $domainsLocales = config("asgard.core.config.$configName");
            $domainLocaleFounded = false;
            $host = $this->app->request->getHost();

            foreach ($domainsLocales ?? [] as $locale => $domains) {
                foreach ($domains as $domain) {
                    if ($host == $domain && ! $domainLocaleFounded) {
                        $domainLocaleFounded = true;

                        $this->app->config->set('laravellocalization.supportedLocales', [$locale => config("available-locales.$locale")]);
                        $this->app->config->set('translatable.locales', [$locale]);

                        config(['app.url' => 'https://'.$host]);
                        config(['app.locale' => $locale]);
                        \LaravelLocalization::setLocale($locale);
                        app('laravellocalization')->defaultLocale = $locale;
                    }
                }
            }

            if (! $domainLocaleFounded) {
                $this->app->config->set('laravellocalization.supportedLocales', $availableLocales);
                $this->app->config->set('translatable.locales', $locales);
            }
        }
    }

    /**
     * @param  string  $path
     * @return bool
     */
    private function hasPublishedTranslations(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * Does a Module have it's Translations centralised in the Translation module?
     *
     * @return bool
     */
    private function moduleHasCentralisedTranslations(Module $module): bool
    {
        return is_dir($this->getCentralisedTranslationPath($module));
    }

    /**
     * Get the absolute path to the Centralised Translations for a Module (via the Translations module)
     *
     * @return string
     */
    private function getCentralisedTranslationPath(Module $module): string
    {
        $path = config('modules.paths.modules').'/Translation';

        return $path."/Resources/lang/{$module->getLowerName()}";
    }

    /**
     * List of Custom Blade Directives
     */
    public function bladeDirectives()
    {
        if (app()->environment() === 'testing') {
            return;
        }

        /**
         * Set variable.
         * Usage: @set($variable, value)
         */
        Blade::directive('set', function ($expression) {
            [$variable, $value] = $this->getArguments($expression);

            return "<?php {$variable} = {$value}; ?>";
        });

        $this->app['blade.compiler']->directive('editor', function ($value) {
            return "<?php echo AsgardEditorDirective::show([$value]); ?>";
        });
    }

    /**
     * Checks if the current url matches the configured backend uri
     *
     * @return bool
     */
    private function onBackend(): bool
    {
        $url = app(Request::class)->path();
        if (Str::contains($url, config('asgard.core.core.admin-prefix'))) {
            return true;
        }

        return false;
    }

    /**
     * Get argument array from argument string.
     *
     * @return array
     */
    private function getArguments($argumentString): array
    {
        return str_getcsv($argumentString, ',', "'");
    }

    /**
     * Instance Imagina Api CRUD Helpers
     */
    private function instanceICrud()
    {
        //Instance Router Generator as macro of Router Class
        Router::macro('apiCrud', function ($params) {
            $routerGenerator = app('Modules\Core\Icrud\Routing\RouterGenerator');
            $routerGenerator->apiCrud($params);
        });

        //Instance macro to Blueprint class to auditStamps
        Blueprint::macro('auditStamps', function () {
            //Deleted_at
            if (! \Schema::hasColumn($this->getTable(), 'deleted_at')) {
                $this->timestamp('deleted_at', 0)->nullable();
            }
            //Created by
            if (! \Schema::hasColumn($this->getTable(), 'created_by')) {
                $this->integer('created_by')->unsigned()->nullable();
                $this->foreign('created_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            }
            //Updated by
            if (! \Schema::hasColumn($this->getTable(), 'updated_by')) {
                $this->integer('updated_by')->unsigned()->nullable();
                $this->foreign('updated_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            }
            //Deleted by
            if (! \Schema::hasColumn($this->getTable(), 'deleted_by')) {
                $this->integer('deleted_by')->unsigned()->nullable();
                $this->foreign('deleted_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            }
            //Organization id
            $organizationTable = 'isite__organizations';
            if ($this->getTable() != $organizationTable) {
                if (! \Schema::hasColumn($this->getTable(), 'organization_id')) {
                    $this->integer('organization_id')->unsigned()->nullable();
                }
            }
        });
    }
}
