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
Route::name('home.')->group(function() {

    // 전체 메인 페이지
    Route::get('/', [
        'as'    => 'index',
        'uses'  => 'HomeController@index'
    ]);

    // 회원가입 페이지
    Route::get('/join', [
        'as'    => 'join',
        'uses'  => 'HomeController@join'
    ]);

    // 로그인 페이지
    Route::post('/login', [
        'as'    => 'login',
        'uses'  => 'HomeController@login'
    ]);

    // 로그아웃 기능
    Route::get('/logout', [
        'as'    => 'logout',
        'uses'  => 'HomeController@logout'
    ]);

    // 아이디/비밀번호 찾기 관련 기능 정의
    Route::get('/forgot', [
        'as'   => 'forgot',
        'uses' => 'HomeController@forgot'
    ]);
});

// 회원가입 유형 획득
Route::get('/join/{joinType}', 'HomeController@setJoinForm');

// 언어 설정
Route::get('language/{locale}', 'HomeController@setLanguage');

/**
 * 02. 학생 관련 기능 라우팅
 */
Route::name('student.')->group(function() {
    Route::prefix('student')->group(function() {

        // 학생 회원가입 여부 확인 링크
        Route::post('/check_join', [
            'as'    => 'check_join',
            'uses'  => 'StudentController@check_join'
        ]);

        // 학생 회원가입
        Route::post('/store', [
            'as'    => 'store',
            'uses'  => 'StudentController@store'
        ]);

        // 학생 계정 접속 이후 사용하는 기능들 => 로그인 여부 확인
        Route::middleware(['check.login'])->group(function() {

            // 학생 메인 페이지
            Route::get('/', [
                'as'    => 'index',
                'uses'  => 'StudentController@index'
            ]);

            // 학생 회원관리 페이지
            Route::get('/info', [
                'as'    => 'info',
                'uses'  => 'StudentController@info'
            ]);

            // 출결 관리 기능
            Route::get('/attendance/{period?}/{date?}', [
                'as'    => 'attendance',
                'uses'  => 'StudentController@getAttendanceRecords'
            ]);

            // 학업 관리 기능
            Route::get('/lecture/{date?}', [
                'as'    => 'lecture',
                'uses'  => 'StudentController@lectureMain'
            ]);

            Route::get('/counsel', [
                'as'    => 'counsel',
                'uses'  => 'StudentController@counsel'
            ]);
        });
    });
});

/**
 *  03. 지도교수 기능 관련 라우팅
 */
Route::name('tutor.')->group(function() {
    Route::prefix('tutor')->group(function() {

        // 지도교수 회원가입
        Route::post('/store', [
            'as'    => 'store',
            'uses'  => 'TutorController@store'
        ]);

        // 지도교수 회원가입시 아이디 중복 확인
        Route::post('/check_join', [
            'as'    => 'check_join',
            'uses'  => 'TutorController@check_join'
        ]);

        // 지도교수 로그인 이후 이용 가능 기능
        Route::middleware(['check.login'])->group(function() {

            // 지도교수 메인 페이지 출력
            Route::get('/', [
                'as'    => 'index',
                'uses'  => 'TutorController@index'
            ]);

            // 계정관리
            Route::get('/info', [
                'as'    => 'info',
                'uses'  => 'TutorController@info'
            ]);

            // 지도반 관련

            // 내 지도반 관리
            Route::get('/myclass/manage/{order?}/{term?}', [
                'as'    => 'myclass.manage',
                'uses'  => 'TutorController@manageMyClass'
            ]);

            // 내 지도반 생성
            Route::get('/myclass/create', [
                'as'    => 'myclass.create',
                'uses'  => 'TutorController@createMyClass'
            ]);
        });
    });
});

/**
 *  04. 교과목 교수 기능 관련 라우팅
 */

Route::name('professor.')->group(function() {
   Route::prefix("professor")->group(function() {
       // 교과목교수 아이디 확인
       Route::post('/check_join', [
           'as'     => 'check_join',
           'uses'   => 'ProfessorController@check_join'
       ]);

        // 교과목교수 회원가입
       Route::post('/store', [
           'as'    => 'store',
           'uses'  => 'ProfessorController@store'
       ]);

       // 교과목교수 로그인 이후 사용 가능 기능
       Route::middleware(['check.login'])->group(function() {

           // 교과목교수 메인 페이지 출력
           Route::get('/', [
               'as'     => 'index',
               'uses'   => 'ProfessorController@index'
           ]);

           // 수강반 관리

           // 출결 관리
           // 출석체크
           Route::get('/lecture/check_attendance', [
               'as'     => 'lecture.attendance.check',
               'uses'   => 'ProfessorController@checkAttendance'
           ]);

           // 학생 관리
           // 성적 조회
           Route::get('/details/scores/{stdId}', [
                'as'    => 'details.scores',
                'uses'  => 'ProfessorController@detailsOfStudent'
           ]);

           // 코멘트 조회
           Route::get('/details/comment/{stdId}/{term?}', [
               'as'     => 'details.comments',
               'uses'   => 'ProfessorController@commentsOfStudent'
           ]);

           // 성적 관리
           Route::get('/scores/store', [
                'as'    => 'scores.store.main',
                'uses'  => function() {
                    return view('professor_score_store', [
                        'title' => __('page_title.professor_score_store_main'),
                    ]);
                }
           ]);

           // 엑셀 양식 다운로드
           Route::post('/scores/store/excel/export', [
                'as'    => 'scores.store.excel.export',
                'uses'  => 'ProfessorController@exportScoresExcelForm'
           ]);

           Route::post('/scores/store/excel/import', [
               'as'     => 'scores.store.excel.import',
               'uses'   => 'ProfessorController@storeScoreAtExcel'
           ]);

           // 교과목교수 상담관리 페이지
           Route::get('/counsel', [
               'as'     => 'counsel',
               'uses'   => 'ProfessorController@counsel'
           ]);
       });
   });
});