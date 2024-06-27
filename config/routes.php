<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\HttpServer\Router\Router;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;


Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});


Router::addGroup('/user', function () {
    Router::post('', 'App\Controller\UserController@store'); // Create a new user
    Router::get('/{id}', 'App\Controller\UserController@show'); // Get user by ID
    Router::put('/{id}', 'App\Controller\UserController@update'); // Update user by ID
    Router::delete('/{id}', 'App\Controller\UserController@destroy'); // Delete user by ID
});

Router::get('/test-db', function (HttpResponse $response) {
    try {
        $users = \App\Model\User::all();
        return $response->json($users);
    } catch (\Exception $e) {
        return $response->json(['error' => $e->getMessage()], 500);
    }
});
