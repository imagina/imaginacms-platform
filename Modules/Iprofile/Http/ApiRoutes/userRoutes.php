<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/users'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/register', [
    'as' => $locale . 'api.iprofile.users.register',
    'uses' => 'UserApiController@register',
    'middleware' => ['captcha']
  ]);
  $router->post('/', [
    'as' => $locale . 'api.iprofile.users.create',
    'uses' => 'UserApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.users.index',
    'uses' => 'UserApiController@index',
    'middleware' => ['auth:api']
  ]);
  $router->post('change-password', [
    'as' => $locale . 'api.iprofile.change.password',
    'uses' => 'UserApiController@changePassword',
    //'middleware' => ['auth:api']
  ]);
  $router->get('/birthday', [
    'as' => $locale . 'api.iprofile.users.birthday',
    'uses' => 'UserApiController@usersBirthday',
    'middleware' => ['auth:api']
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.users.update',
    'uses' => 'UserApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.users.delete',
    'uses' => 'UserApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.users.show',
    'uses' => 'UserApiController@show',
    'middleware' => ['auth:api']
  ]);
  $router->post('/media/upload', [
    'as' => 'api.profile.users.media.upload',
    'uses' => 'UserApiController@mediaUpload',
    'middleware' => ['auth:api']
  ]);
  $router->post('/media/delete', [
    'as' => 'api.profile.users.media.delete',
    'uses' => 'UserApiController@mediaDelete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/password/validate-change', [
    'as' => 'api.profile.users.password.validate-change',
    'uses' => 'UserApiController@passwordValidateChange',
    'middleware' => ['auth:api']
  ]);

});
