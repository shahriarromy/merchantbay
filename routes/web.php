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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index');
Route::get('/adminheading', ['uses'=>'AdminController@tables', 'as'=>'adminheading.tables']);
Route::post('imageresize', ['uses'=>'AdminController@resizeImagePost', 'as'=>'imageresize']);
Route::get('/heading_desc/{id}', 'HeadingsController@index')->name('heading_desc.show');
Route::post('/ajaxchart', 'AjaxController@chartcountry');
Route::post('/ajaxchartinit', 'AjaxController@ajaxchartinit');
Route::post('/loadmore', 'AjaxController@ajaxloadmore');


