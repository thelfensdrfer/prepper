<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::post('/food/{food_group}', 'FoodController@store')
        ->name('food.store');
    Route::put('/food/{food}', 'FoodController@update')
        ->name('food.update');
    Route::delete('/food/{food}', 'FoodController@delete')
        ->name('food.delete');

    Route::put('/foodplan/{food_group}', 'FoodPlanController@update')
        ->name('foodplan.update');

    Route::post('/checklists', 'ChecklistController@store')
        ->name('checklist.store');
    Route::put('/checklists/{checklist}', 'ChecklistController@update')
        ->name('checklist.update');
    Route::post('/checklist/{checklist}/item', 'ChecklistItemController@store')
        ->name('checklist.item.store');
    Route::put('/checklist/item/{item}', 'ChecklistItemController@update')
        ->name('checklist.item.update');
    Route::delete('/checklist/item/{item}', 'ChecklistItemController@delete')
        ->name('checklist.item.delete');
});
