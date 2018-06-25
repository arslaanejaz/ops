<?php

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

Route::get('logout', function (){
    Auth::logout();
    return redirect('/');
});

Route::post('login', 'LoginUserController@login');
Route::get('auth/login', 'LoginUserController@index');
Route::get('/', 'LoginUserController@index');
Route::resource('users','UsersController');

Route::group(array('middleware' => ['roleadmin']), function (){
    Route::get('home', 'HomeController@index');
    Route::resource('scrape','WebScraperController');

    Route::resource('projects', 'ProjectsController');
    Route::resource('projects.links', 'LinksController');
    Route::resource('projects.forms', 'FormsController');
    Route::resource('projects.test-cases', 'TestCasesController');
    Route::resource('projects.docs', 'DocsController');
    Route::resource('projects.reports', 'ReportController');
    Route::resource('projects.page-speed', 'PageSpeedController');
    Route::post('remove_all', 'RemoveController@index');

});

Route::resource('projects', 'ProjectsController');