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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# routes/api.php

Route::get('/greeting', function (Request $request){
    return 'Hello World!';
});

# Route::get('/product/create','ProductController@create')->name("product.create");

Route::get('/product','ProductController@list')->name("product.list");

# Route::get('/product/{product}','ProductController@edit')->name("product.edit");

Route::post('/product','ProductController@store')->name("product.store");

Route::get('/product/{product}','ProductController@show' )->name("product.show");


Route::put('/product/{product}/update','ProductController@update')->name("product.update");

Route::delete('/product/{product}/delete','ProductController@destroy')->name("product.delete");