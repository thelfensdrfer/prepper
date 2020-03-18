<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/overview', 'OverviewController@index')->name('overview');
    Route::post('/food/{food_group}', 'FoodController@store')
        ->name('food.store');
    Route::put('/food/{food}', 'FoodController@update')
        ->name('food.update');
    Route::delete('/food/{food}', 'FoodController@destroy')
        ->name('food.destroy');
    Route::put('/foodplan/{food_group}', 'FoodPlanController@update')
        ->name('foodplan.update');
});

if (config('app.debug')) {
    Route::get('/mail/reminder/expires/{user}', function (App\User $user) {
        $foodAboutToExpire = $user->foodAboutToExpire();

        return new App\Mail\FoodExpires($foodAboutToExpire);
    });
}
