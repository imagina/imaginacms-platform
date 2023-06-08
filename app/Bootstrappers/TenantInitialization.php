<?php


namespace App\Bootstrappers;


use Illuminate\Support\Str;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Support\Facades\Cache;

class TenantInitialization implements TenancyBootstrapper
{
  
  public $originalPrefix;
  public $storeName;
  
  public function bootstrap(Tenant $tenant)
  {
   //Fix Signed Url, formatting the app url with the Tenant domain url
    config(["app.centralUrl" => config("app.url")]);
    config(["app.url" => $tenant->url]);
    $url = $tenant->url;
    \URL::formatHostUsing(function () use ($url) {
 
      return $url;
    });
    
    //prefixing cache
    $this->originalPrefix = config('cache.prefix');
    $this->storeName = config('cache.default');
    $this->setCachePrefix(config("cache.prefix")."_organization$tenant->id");
    
    //reset supported locales for tenant
    if(\Schema::hasTable("setting__settings"))
      $this->resetSupportedLocales();
  }
  
  protected function setCachePrefix(string $prefix): void
  {
    config()->set('cache.prefix', $prefix);
    
    //app('cache')->forgetDriver($this->storeName);
    
    // This is important because the `CacheManager` will have the `$app['config']` array cached
    // with old prefixes on the `cache` instance. Simply calling `forgetDriver` only removes
    // the `$store` but doesn't update the `$app['config']`.
    app()->forgetInstance('cache');
//
//    //This is important because the Cache Repository is using an old version of the CacheManager
//    app()->forgetInstance('cache.store');
//
//    // Forget the cache repository in the container
//    app()->forgetInstance(Repository::class);

    Cache::clearResolvedInstances();
  }
  
  public function revert()
  {
    config(["app.url" => config("app.centralUrl")]);
    \URL::formatHostUsing(function () {
      return config('app.centralUrl');
    });
    
    //unprefixing cache
    if ($this->originalPrefix) {
      $this->setCachePrefix($this->originalPrefix);
      $this->originalPrefix = null;
    }
    
  }
  
  public function resetSupportedLocales(){
  
    $localeConfig = Cache::store(config("cache.default"))
      ->remember(
        'asgard.locales'."_organization".tenant()->id,
        120,
        function () {
          return \DB::table('setting__settings')->whereName('core::locales')->first();
        }
      );
    
    if ($localeConfig) {
      $locales = json_decode($localeConfig->plainValue);
      $availableLocales = [];
      foreach ($locales as $locale) {
        $availableLocales = array_merge($availableLocales, [$locale => config("available-locales.$locale")]);
      }
    
      $laravelDefaultLocale = config('app.locale');
      
        config()->set('app.locale', array_keys($availableLocales)[0]);
      
    
      //domains locales configuration. Based in the config domainsLocales{app_env}
      $configName = "domainsLocales";
    
      (env('APP_ENV', 'local') == 'local') ? $configName .= "Local" : $configName .= "Prod";
    
      $domainsLocales = config("asgard.core.config.$configName");
      $domainLocaleFounded = false;
      $host = request()->getHost();
    
      foreach ($domainsLocales ?? [] as $locale => $domains) {
      
        foreach ($domains as $domain) {
        
          if ($host == $domain && !$domainLocaleFounded) {
            $domainLocaleFounded = true;
  
            config()->set('laravellocalization.supportedLocales', [$locale => config("available-locales.$locale")]);
            config()->set('translatable.locales', [$locale]);
          
            config(["app.url" => "https://" . $host]);
            config(["app.locale" => $locale]);
            \LaravelLocalization::setLocale($locale);
            app('laravellocalization')->defaultLocale = $locale;
          
          }
        
        }
      
      }
    
      if (!$domainLocaleFounded) {
        config()->set('laravellocalization.supportedLocales', $availableLocales);
        config()->set('translatable.locales', $locales);
      }
    
    }
  
  
    // Hot fix livewire endpoints prioritizing locale
    if (Str::contains(request()->path(), ['livewire/message'])) {
      $locale = request()->input()["fingerprint"]["locale"] ?? locale();
      if(config("app.locale") != $locale){
      
        app("laravellocalization")->currentLocale = $locale;
        $this->app->setLocale($locale);
      
      }
    }
  }
}