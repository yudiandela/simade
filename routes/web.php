<?php

use Illuminate\Http\Request;
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

Route::view('/SurveyPelanggan2020', 'survey.index')->name('survey.index');
Route::post('/survey', 'SurveyController')->name('survey.store');
Route::view('/thanks', 'survey.thanks')->name('survey.thanks');

Auth::routes();
Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/inbox-maps', 'DashboardController@maps')->name('inbox.maps');
Route::get('/my-tasks', 'DashboardController@myTask')->name('mytask');

Route::get('/import', 'ImportController');
