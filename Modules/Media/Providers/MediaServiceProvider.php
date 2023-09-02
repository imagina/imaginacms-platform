<?php

namespace Modules\Media\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Media\Blade\MediaMultipleDirective;
use Modules\Media\Blade\MediaSingleDirective;
use Modules\Media\Blade\MediaThumbnailDirective;
use Modules\Media\Console\RefreshThumbnailCommand;
use Modules\Media\Contracts\DeletingMedia;
use Modules\Media\Contracts\StoringMedia;
use Modules\Media\Entities\File;
use Modules\Media\Entities\Zone;
use Modules\Media\Events\FolderIsDeleting;
use Modules\Media\Events\FolderWasCreated;
use Modules\Media\Events\FolderWasUpdated;
use Modules\Media\Events\Handlers\CreateFolderOnDisk;
use Modules\Media\Events\Handlers\DeleteAllChildrenOfFolder;
use Modules\Media\Events\Handlers\DeleteFolderOnDisk;
use Modules\Media\Events\Handlers\HandleMediaStorage;
use Modules\Media\Events\Handlers\RegisterMediaSidebar;
use Modules\Media\Events\Handlers\RemovePolymorphicLink;
use Modules\Media\Events\Handlers\RenameFolderOnDisk;
use Modules\Media\Image\ThumbnailManager;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Repositories\Eloquent\EloquentFolderRepository;
use Modules\Media\Repositories\Eloquent\EloquentZoneRepository;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Repositories\FolderRepository;
use Modules\Media\Repositories\ZoneRepository;
use Modules\Tag\Repositories\TagManager;

class MediaServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerBindings();

        $this->registerCommands();

        $this->app->bind('media.single.directive', function () {
            return new MediaSingleDirective();
        });
        $this->app->bind('media.multiple.directive', function () {
            return new MediaMultipleDirective();
        });
        $this->app->bind('media.thumbnail.directive', function () {
            return new MediaThumbnailDirective();
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('media', RegisterMediaSidebar::class)
        );

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('media', Arr::dot(trans('media::media')));
            $event->load('folders', Arr::dot(trans('media::folders')));
        });

        app('router')->bind('media', function ($id) {
            return app(FileRepository::class)->find($id);
        });
    }

    public function boot(DispatcherContract $events)
    {
        $this->publishConfig('media', 'config');
        $this->publishConfig('media', 'assets');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('media', 'permissions'), 'asgard.media.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('media', 'settings'), 'asgard.media.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('media', 'settings-fields'), 'asgard.media.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('media', 'cmsPages'), 'asgard.media.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('media', 'cmsSidebar'), 'asgard.media.cmsSidebar');

        $events->listen(StoringMedia::class, HandleMediaStorage::class);
        $events->listen(DeletingMedia::class, RemovePolymorphicLink::class);
        $events->listen(FolderWasCreated::class, CreateFolderOnDisk::class);
        $events->listen(FolderWasUpdated::class, RenameFolderOnDisk::class);
        $events->listen(FolderIsDeleting::class, DeleteFolderOnDisk::class);
        $events->listen(FolderIsDeleting::class, DeleteAllChildrenOfFolder::class);

        $this->app[TagManager::class]->registerNamespace(new File());
        $this->registerThumbnails();
        $this->registerBladeTags();

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
        $this->registerAwsCredentials();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(FileRepository::class, function () {
            return new EloquentFileRepository(new File());
        });
        $this->app->bind(FolderRepository::class, function () {
            return new EloquentFolderRepository(new File());
        });
        $this->app->bind(ZoneRepository::class, function () {
            return new EloquentZoneRepository(new Zone());
        });
    }

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerRefreshCommand();
    }

    /**
     * Register the refresh thumbnails command
     */
    private function registerRefreshCommand()
    {
        $this->app->singleton('command.media.refresh', function ($app) {
            return new RefreshThumbnailCommand($app['Modules\Media\Repositories\FileRepository']);
        });

        $this->commands('command.media.refresh');
    }

    /**
     * Register registerAwsCredentials
     */
    private function registerAwsCredentials()
    {
        try {
            config(['filesystems.disks.s3' => [
                'driver' => 's3',
                'key' => setting('media::awsAccessKeyId'),
                'secret' => setting('media::awsSecretAccessKey'),
                'region' => setting('media::awsDefaultRegion'),
                'bucket' => setting('media::awsBucket'),
                'url' => setting('media::awsUrl'),
                'endpoint' => setting('media::awsEndpoint'),
            ]]);
        } catch(\Exception $error) {
            \Log::info('Media:: RegisterThumbnails error: '.$error->getMessage());
        }
  //  dd(trans('media::media'));
    }

    private function registerThumbnails()
    {
        try {
            $thumbnails = json_decode(setting('media::thumbnails', null, config('asgard.media.config.defaultThumbnails')));

            foreach ($thumbnails as $key => $thumbnail) {
                $this->app[ThumbnailManager::class]->registerThumbnail($key, [

                    'quality' => $thumbnail->quality ?? 80,
                    'resize' => [
                        'width' => $thumbnail->width ?? 300,
                        'height' => $thumbnail->height ?? null,
                        'callback' => function ($constraint) use ($thumbnail) {
                            if (isset($thumbnail->aspectRatio) && $thumbnail->aspectRatio) {
                                $constraint->aspectRatio();
                            }
                            if (isset($thumbnail->upsize) && $thumbnail->upsize) {
                                $constraint->upsize();
                            }
                        },
                    ],
                ],
                    $thumbnail->format ?? 'webp'
                );
            }
        } catch(\Exception $error) {
            \Log::info('Media:: RegisterThumbnails error: '.$error->getMessage());
        }
    }

    private function registerBladeTags()
    {
        if (app()->environment() === 'testing') {
            return;
        }
        $this->app['blade.compiler']->directive('mediaSingle', function ($value) {
            return "<?php echo MediaSingleDirective::show([$value]); ?>";
        });
        $this->app['blade.compiler']->directive('mediaMultiple', function ($value) {
            return "<?php echo MediaMultipleDirective::show([$value]); ?>";
        });
        $this->app['blade.compiler']->directive('thumbnail', function ($value) {
            return "<?php echo MediaThumbnailDirective::show([$value]); ?>";
        });
    }

    /**
     * Register components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Media\View\Components", 'media');
    }
}
