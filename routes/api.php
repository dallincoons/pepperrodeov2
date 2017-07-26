<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'v1'
], function () {
    Route::get('grocery-lists', 'GroceryListController@all');
    Route::get('grocery-list/{grocerylist}', 'GroceryListController@show');
    Route::post('grocery-list/create', 'GroceryListController@store');
    Route::post('grocery-list/{grocerylist}/delete', 'GroceryListController@delete');
});
