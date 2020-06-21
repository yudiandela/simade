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

Route::post('/survey', 'SurveyController@store')->name('survey.store');
Route::get('/survey/{survey}', 'SurveyController@edit')->name('survey.edit');
Route::put('/survey/{survey}', 'SurveyController@update')->name('survey.update');
Route::put('/survey/{survey}/updatetime', 'SurveyController@updateTime')->name('survey.updateTime');

Route::view('/thanks', 'survey.thanks')->name('survey.thanks');

Auth::routes();
Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/table', 'DashboardController@getTable')->name('dashboard.table');
Route::get('/inbox-maps', 'DashboardController@maps')->name('inbox.maps');
Route::patch('/approve', 'DashboardController@approve')->name('approve');
Route::patch('/not-approve', 'DashboardController@not_approve')->name('not-approve');

Route::get('/new-table', 'DashboardController@getNewTable')->name('dashboard.newtable');
Route::get('/data-api', 'DashboardController@getDataApi')->name('data.api');
// Route::get('/import', 'ImportController');

Route::get('/my-tasks', 'TaskController@overview')->name('task.overview');
Route::get('/my-tasks/search', 'TaskController@search')->name('task.search');
