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
    Route::get('grocery-lists/search', 'GroceryListSearchController@index');

    Route::post('grocery-list/{grocerylist}/add/recipes', 'GroceryListRecipeController@post');

    Route::get('grocery-lists', 'GroceryListController@all');
    Route::get('grocery-list/{grocerylist}', 'GroceryListController@show');
    Route::post('grocery-list', 'GroceryListController@store');
    Route::post('grocery-list/{grocerylist}', 'GroceryListController@delete');
    Route::patch('grocery-list/{grocerylist}', 'GroceryListController@update');

    Route::post('grocery-list-item', 'GroceryListItemController@store');
    Route::delete('grocery-list-item/{groceryListItem}', 'GroceryListItemController@delete');
    Route::patch('grocery-list-item/{groceryListItem}', 'GroceryListItemController@update');
    Route::post('grocery-list-item-completion/{groceryListItem}', 'GroceryListItemCompletionController@store');

    Route::get('recipes', 'RecipeController@index');
    Route::post('recipes/create', 'RecipeController@store');
    Route::get('recipes/{recipe}', 'RecipeController@show');
    Route::patch('recipes/{recipe}', 'RecipeController@update');
    Route::delete('recipes/{recipe}', 'RecipeController@delete');

    Route::post('recipe/{recipe}/add-ingredients', 'IngredientController@store');
    Route::delete('ingredients/{ingredient}', 'IngredientController@delete');
    Route::delete('listable_ingredients/{ingredient}', 'ListableIngredientController@delete');

    Route::get('departments', 'DepartmentController@index');
    Route::get('categories', 'CategoryController@index');

    // vue-router will handle any other requests
    Route::get('/{vue_capture?}', function () {
        return view('welcome');
    })->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
});
