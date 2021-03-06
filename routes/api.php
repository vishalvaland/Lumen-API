<?php
/** @var Router $router */

use Laravel\Lumen\Routing\Router;

/* Public Routes */
$router->get('/', function () {
    return response()->json(['message' => 'Welcome to Lumen API Starter']);
});

/* Auth Routes */
$router->group(['prefix' => 'auth', 'as' => 'auth'], function (Router $router) {

    /* Defaults */
    $router->post('/register', [
        'as' => 'register',
        'uses' => 'AuthController@register',
    ]);
    $router->post('/login', [
        'as' => 'login',
        'uses' => 'AuthController@login',
    ]);
    $router->get('/verify/{token}', [
        'as' => 'verify',
        'uses' => 'AuthController@verify'
    ]);

    /* Password Reset */
    $router->post('/password/forgot', [
        'as' => 'password.forgot',
        'uses' => 'AuthController@forgotPassword'
    ]);
    $router->post('/password/recover/{token}', [
        'as' => 'password.recover',
        'uses' => 'AuthController@recoverPassword'
    ]);

    /* Protected User Endpoint */
    $router->get('/user', [
        'uses' => 'AuthController@getUser',
        'as' => 'user',
        'middleware' => 'auth'
    ]);

});

/* Protected Routes */
$router->group(['middleware' => 'auth'], function (Router $router) {

    $router->get('/admin', function () {
        return response()->json(['message' => 'You are authorized as an administrator.']);
    });

    $router->group(['namespace' => '\App\Http\Controllers'], function (Router $router){

        $router->get('/product',  ['uses' => 'ProductController@showAllProduct', 'as' => 'product']);
        // $router->post('/productTwo',  ['uses' => 'ProductController@createTwo', 'as' => 'product']);

        $router->get('/product/{id}', ['uses' => 'ProductController@showOneProduct', 'as' => 'product' ]);
    
        $router->post('/product', ['uses' => 'ProductController@create', 'as' => 'product' ]);
    
        $router->delete('/product/{id}', ['uses' => 'ProductController@delete', 'as' => 'product']);
    
        $router->put('/product/{id}', ['uses' => 'ProductController@update' ]);
       
    });

    $router->get('images/{slug}', [ 
        'middleware' => 'auth',
    ]);

    // $router->group(['middleware' => 'role:administrator'], function (Router $router) {

    //     $router->get('/admin', function () {
    //         return response()->json(['message' => 'You are authorized as an administrator.']);
    //     });

    // });

});
