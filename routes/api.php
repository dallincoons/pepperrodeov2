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
    Route::post('grocery-list', 'GroceryListController@store');
    Route::post('grocery-list/{grocerylist}', 'GroceryListController@delete');
    Route::patch('grocery-list/{grocerylist}', 'GroceryListController@update');

    Route::post('grocery-list-item', 'GroceryListItemController@store');
    Route::delete('grocery-list-item', 'GroceryListItemController@delete');
    Route::post('grocery-list-item-completion/{groceryListItem}', 'GroceryListItemCompletionController@store');

    // vue-router will handle any other requests
    Route::get('/{vue_capture?}', function () {
        return view('welcome');
    })->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
});
