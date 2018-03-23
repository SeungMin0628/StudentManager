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
/**
 *  01. 홈 화면 라우팅
 */
Route::get('/', [
    'as'    =>'home.index',
    'uses'  =>'HomeController@index'
]);

Route::get('/join', [
   'as'     => 'home.join',
   'uses'   => 'HomeController@join'
]);

Route::get('/join/{joinType}', 'HomeController@setJoinForm');

Route::post('/login', [
    'as'    => 'home.login',
    'uses'  => 'HomeController@login'
]);


/**
 * 02. 학생 관련 기능 라우팅
 */

Route::post('/check/student', [
    'as'    => 'student.check',
    'uses'  => 'StudentController@check'
]);

Route::post('/store/student', [
    'as'    => 'student.store',
    'uses'  => 'StudentController@store'
]);
