<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('business/get/logo',"UserController@get_image");
Route::get('user/get/profile',"UserController@get_image");
Route::post('validate/email',"UserController@check_email");


Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('ticket/create', 'TicketController@create');
    Route::get('logout', 'UserController@unauthenticate');
    Route::post('user/update/image', 'UserController@update_profile_img');
    Route::post('user/update/details', 'UserController@update_profile_detailes');
    Route::post('ticket/get', 'TicketController@get_ticket_list');
    Route::post('ticket/validate', 'TicketController@validate_ticket');
});


Route::get('index', function () {
    $response = ["status" => "success", "data" => "not found"];
    return response(json_encode($response), 200, ["Content-Type" => "application/json"]);
});



