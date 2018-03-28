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
// 전체 메인 페이지
Route::get('/', [
    'as'    =>'home.index',
    'uses'  =>'HomeController@index'
]);

// 회원가입 페이지
Route::get('/join', [
   'as'     => 'home.join',
   'uses'   => 'HomeController@join'
]);

// 회원가입 유형 획득
Route::get('/join/{joinType}', 'HomeController@setJoinForm');

// 로그인 페이지
Route::post('/login', [
    'as'    => 'home.login',
    'uses'  => 'HomeController@login'
]);

// 로그아웃 기능
Route::get('/logout', [
    'as'    => 'home.logout',
    'uses'  => 'HomeController@logout'
]);

// 언어 설정
Route::get('language/{locale}', 'HomeController@setLanguage');

// 현재 언어설정 획득
Route::get('language', [
    'as'    => 'home.get_language',
    'uses'  => 'HomeController@getLanguage'
]);

/**
 * 02. 학생 관련 기능 라우팅
 */
Route::post('/check/student', [
    'as'    => 'student.check_join',
    'uses'  => 'StudentController@check_join'
]);

Route::post('/store/student', [
    'as'    => 'student.store',
    'uses'  => 'StudentController@store'
]);

Route::get('/student', [
    'as'    => 'student.index',
    'uses'  => 'StudentController@index'
])->middleware('check.login');

/**
 * 03. 교수 공통 기능 관련 라우팅
 */
// 교수 회원가입시 아이디 중복 확인
Route::get('/check/professor', [
    'as'    => 'professor.check_join',
    'uses'  => 'ProfessorController@check_join'
]);