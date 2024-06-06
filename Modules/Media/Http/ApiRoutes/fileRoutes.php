<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/files','middleware' => ['auth:api']], function (Router $router) {
  $router->bind('file', function ($id) {
    return app(\Modules\Media\Repositories\FileRepository::class)->find($id);
  });

  $router->get('/', [
    'as' => 'api.imedia.files.index',
    'uses' => 'NewApi\MediaApiController@index',
    'middleware' => 'auth-can:media.medias.index'
  ]);

  $router->post('/', [
    'as' => 'api.imedia.files.create',
    'uses' => 'NewApi\MediaApiController@create',
    'middleware' => 'auth-can:media.medias.create'
  ]);
  
  $router->put('/{id}', [
    'as' => 'api.imedia.files.update',
    'uses' => 'NewApi\MediaApiController@update',
    'middleware' => 'auth-can:media.medias.edit'
  ]);


  $router->get('/{criteria}', [
    'as' => 'api.imedia.files.show',
    'uses' => 'NewApi\MediaApiController@show',
    'middleware' => 'auth-can:media.medias.show'
  ]);

  $router->delete('/{file}', [
    'as' => 'api.imedia.files.destroy',
    'uses' => 'NewApi\MediaApiController@delete',
    'middleware' => 'auth-can:media.medias.destroy'
  ]);
  
});