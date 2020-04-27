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
$router->get('/user/{id}','UsersController@index');
$router->get('/event','EventController@index');
$router->get('agenda','EventAgendaController@index');
$router->get('create-invoice','XenditController@createInvoice');
$router->get('get-invoice','XenditController@getInvoice');
$router->get('get-disbursement','XenditController@getDisbursement');
$router->get('create-disbursement','XenditController@createDisbursement');
$router->get('paket','PaketController@index');
$router->post('add-event','EventController@create');
$router->get('edit-event/{id}','EventController@edit');
$router->put('update-event/{id}','EventController@update');
$router->get('session/{id}','SessionController@index');
$router->post('add-agenda','EventAgendaController@create');
$router->get('edit-agenda/{id}','EventAgendaController@edit');
$router->put('update-agenda/{id}','EventAgendaController@update');
$router->post('add-panitia','UsersController@addPanitia');
$router->post('upload-materi','MateriController@upload');
$router->get('materi/{id}','MateriController@index');
$router->post('add-session','SessionController@create');
$router->put('edit-session/{id}','SessionController@edit');
$router->get('show-session/{id}','SessionController@show');
$router->get('provinsi','UsersController@provinsi');
$router->post('add-pemateri','UsersController@addPemateri');
$router->get('edit-user/{id}','UsersController@edit');
$router->put('update-user/{id}','UsersController@update');
$router->post('add-participant','EventPresensiController@addParticipant');
$router->post('set-qrcode','EventPresensiController@setQrCode');
$router->post('scan-qrcode','EventPresensiController@scanQrCode');
$router->get('rekapitulasi','EventPresensiController@rekapitulasi');
$router->post('callback-invoice/{id}','XenditController@callbackInvoice');
$router->post('callback-disbursement/{id}','XenditController@callbackDisbursement');
$router->get('pending/{id}','EventController@orderEventPending');
$router->get('expired/{id}','EventController@orderEventExpired');
$router->get('paid/{id}','EventController@orderEventPaid');