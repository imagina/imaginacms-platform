<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

//==================================================== Overwrite Default Asgard Login

$router->get('auth/login', [
    'middleware' => 'auth.guest',
    'as' => 'login',
    'uses' => 'AuthProfileController@getLogin',
]);

//==================================================== Prefix account
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize']], function (Router $router) use ($locale) {
        $router->get(trans('iprofile::routes.account'), [
            'as' => $locale.'.iprofile.account.index',
            'uses' => 'ProfileController@index',
            'middleware' => 'logged.in',
        ]);
    });

$router->group(['prefix' => '/account'], function (Router $router) {
    $router->get('profile/', [
        'as' => 'account.profile.edit',
        'uses' => 'ProfileController@edit',
        'middleware' => 'can:iprofile.profiles.edit',
    ]);
    $router->post('profile', [
        'as' => 'iprofile.profile.store',
        'uses' => 'ProfileController@store',
        'middleware' => 'can:iprofile.profiles.create',
    ]);

    $router->put('profile/{user_id}', [
        'as' => 'iprofile.profile.update',
        'uses' => 'ProfileController@update',
        'middleware' => 'can:profile.user.edit',
        //'middleware' => 'can:iprofile.profiles.edit'
    ]);
    $router->put('user/update', [
        'as' => 'iprofile.user.update',
        'uses' => 'ProfileController@updateUser',
        'middleware' => 'can:iprofile.profiles.edit',
    ]);

    $router->get('vcard/{user_id}', [
        'as' => 'iprofile.vcard.create',
        'uses' => 'VcardController@create',
    ]);

    $router->get('login', [
        'as' => 'account.login.get',
        'uses' => 'AuthProfileController@getLogin',
    ]);

    $router->post('login', [
        'as' => 'account.login.post',
        'uses' => 'AuthProfileController@postLogin',
    ]);

    //==================================================== Register
    $router->get('register', [
        'middleware' => 'auth.guest',
        'as' => 'account.register',
        'uses' => 'AuthProfileController@getRegister',
    ]);
    $router->post('register', [
        'as' => 'account.register.post',
        'uses' => 'AuthProfileController@userRegister',
    ]);

    //==================================================== Account Activation
    $router->get('activate/{userId}/{activationCode}', 'AuthProfileController@getActivate');

    //==================================================== Reset password
    $router->get('reset', [
        'as' => 'account.reset',
        'uses' => 'AuthProfileController@getReset',
    ]);
    $router->post('reset', [
        'as' => 'account.reset.post',
        'uses' => 'AuthProfileController@postReset',
    ]);
    $router->get('reset/{id}/{code}', [
        'as' => 'account.reset.complete',
        'uses' => 'AuthProfileController@getResetComplete',
    ]);
    $router->post('reset/{id}/{code}', [
        'as' => 'account.reset.complete.post',
        'uses' => 'AuthProfileController@postResetComplete',
    ]);

    //==================================================== Logout
    $router->get('logout', [
        'as' => 'account.logout',
        'uses' => 'AuthProfileController@getLogout',
    ]);

    //==================================================== Social
    $router->get('social/{provider}', [
        'as' => 'account.social.auth',
        'uses' => 'AuthProfileController@getSocialAuth',
    ]);
    $router->get('social/callback/{provider}', [
        'as' => 'account.social.callback',
        'uses' => 'AuthProfileController@getSocialAuthCallback',
    ]);
    $router->post('update_address', [
        'as' => 'account.address.update',
        'uses' => 'ProfileController@updateAddress',
    ]);
    $router->post('save_new_address', [
        'as' => 'account.newaddress.save',
        'uses' => 'ProfileController@storeNewAddress',
    ]);
});
