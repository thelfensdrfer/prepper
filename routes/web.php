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
    Route::get('/food', 'FoodController@index')
        ->name('food.index');

    Route::get('/checklists', 'ChecklistController@index')
        ->name('checklist.index');

    Route::get('/account', 'AccountController@show')
        ->name('account.show');
    Route::put('/account/personal', 'AccountController@update')
        ->name('account.update');
    Route::put('/account/password', 'AccountController@password')
        ->name('account.password');
    Route::put('/account/reminder', 'AccountController@reminder')
        ->name('account.reminder');
});

if (config('app.debug')) {
    Route::get('/mail/reminder/expires/{user}', function (App\User $user) {
        $foodAboutToExpire = $user->foodAboutToExpire();

        return new App\Mail\FoodExpires($foodAboutToExpire);
    });
}
