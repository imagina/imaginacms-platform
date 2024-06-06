<?php

use Illuminate\Routing\Router;

/*=== AUTH ===*/
$router->group(['prefix' => '/auth'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('register', [
    'as' => $locale . 'api.auth.register',
    'uses' => 'UserApiController@register',
  ]);

  /** @var Router $router */
  $router->post('login', [
    'as' => $locale . 'api.iprofile.login',
    'uses' => 'AuthApiController@login',
  ]);

    /** @var Router $router */
    $router->post('reset', [
        'as' => $locale . 'api.iprofile.reset',
        'uses' => 'AuthApiController@reset',
    ]);
    /** @var Router $router */
    $router->post('reset-complete', [
        'as' => $locale . 'api.iprofile.reset-complete',
        'uses' => 'AuthApiController@resetComplete',
    ]);
  /** @var Router $router */
  $router->get('me', [
    'as' => $locale . 'api.iprofile.me',
    'uses' => 'AuthApiController@me',
    'middleware' => ['auth:api']
  ]);

  /** @var Router $router */
  $router->get('logout', [
    'as' => $locale . 'api.iprofile.logout',
    'uses' => 'AuthApiController@logout',
  ]);

  /** @var Router $router */
  $router->get('logout-all', [
    'as' => $locale . 'api.iprofile.logout.all',
    'uses' => 'AuthApiController@logoutAllSessions',
  ]);

  /** @var Router $router */
  $router->get('must-change-password', [
    'as' => $locale . 'api.iprofile.me.must.change.password',
    'uses' => 'AuthApiController@mustChangePassword',
    'middleware' => ['auth:api']
  ]);

  /** @var Router $router */
  $router->get('impersonate', [
    'as' => $locale . 'api.profile.impersonate',
    'uses' => 'AuthApiController@impersonate',
  ]);

  /** @var Router $router */
  $router->get('refresh-token', [
    'as' => $locale . 'api.iprofile.refresh.token',
    'uses' => 'AuthApiController@refreshToken',
    'middleware' => ['auth:api']
  ]);

  #==================================================== Social
      $router->get('social/{provider}', [
        'as' => $locale . 'api.iprofile.social.auth',
        'uses' => 'AuthApiController@getSocialAuth'
      ]);
    
      $router->get('social/callback/{provider}', [
        'as' =>  $locale . 'api.iprofile.social.callback',
        'uses' => 'AuthApiController@getSocialAuthCallback'
      ]);

  
  
});
