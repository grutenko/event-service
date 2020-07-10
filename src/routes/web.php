<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/users', "UserController@get");
$router->post('/users', "UserController@post");
$router->put('/users/{id}', "UserController@put");
$router->delete('/users/{id}', "UserController@delete");

$router->post('/users/{id}/events', "UserController@link");
$router->delete('/users/{id}/events', "UserController@unlink");