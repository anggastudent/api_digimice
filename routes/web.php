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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');
$router->get('/user','UsersController@index');
$router->get('/event','EventController@index');
$router->get('/session-agenda','EventAgendaController@index');
$router->get('/event-agenda','EventAgendaController@agenda');
$router->post('/presensi','EventPresensiController@addPresensi');
$router->get('create-invoice','XenditController@createInvoice');
$router->get('get-invoice','XenditController@getInvoice');
$router->get('get-disbursement','XenditController@getDisbursement');
$router->get('create-disbursement','XenditController@createDisbursement');
$router->get('paket','PaketController@index');