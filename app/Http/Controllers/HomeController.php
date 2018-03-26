<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Symfony\Component\HttpKernel\Tests\Controller\controller_function;
use function Symfony\Component\HttpKernel\Tests\controller_func;
use Whoops\Exception\ErrorException;

/**
 * 클래스명:                       HomeController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    홈 화면에서 계정 관련 기능을 수행하는 컨트롤러 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 16일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *  public index(null):            메인에서 로그인 화면을 출력
 *
 */
class HomeController extends Controller
{
    // 01. 멤버 변수 정의
    const USER_TYPE = [
        'student'       => 'student',
        'tutor'         => 'tutor',
        'professor'     => 'professor'
    ];

    // 02. 생성자 정의

    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         index
     * 함수 설명:                      메인에서 로그인 화면을 출력
     * 만든날:                         2018년 3월 16일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $data = [
            'title'         => 'home',
            'user_type'     => self::USER_TYPE
        ];

        return view('login', $data);
    }

    /**
     * 함수명:                         join
     * 함수 설명:                      회원가입의 유형을 선택하는 페이지를 출력
     * 만든날:                         2018년 3월 16일
     *
     * 매개변수 목록
     *  null
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function join() {
        $data = [
            'title'     => 'join: select type',
            'user_type' => self::USER_TYPE
        ];

        return view('join_select', $data);
    }

    /**
     * 함수명:                         setJoinForm
     * 함수 설명:                      선택한 회원가입 유형에 따라 정보를 받는 Form 생성
     * 만든날:                         2018년 3월 16일
     *
     * 매개변수 목록
     * @param $joinType :               회원가입 유형을 정의
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *      $type(string):             현재 회원가입 유형을 알림
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * 예외처리
     * @throws ErrorException
     */
    public function setJoinForm($joinType) {
        $data = array();

        switch ($joinType) {
            case self::USER_TYPE['student']:
                $data['title'] = 'join : student';
                $data['type'] = '학생';

                return view('join_student', $data);
            case self::USER_TYPE['tutor']:
                $data['title'] = 'join : tutor';
                $data['type'] = '지도교수';

                return view('join_tutor', $data);
            case self::USER_TYPE['professor']:
                $data['title'] = 'join : professor';
                $data['type'] = '교과목 교수';

                return view('join_tutor', $data);
            default:
                throw new ErrorException();
        }
    }
    /**
     * 함수명:                         login
     * 함수 설명:                      사용자가 작성한 로그인 양식을 받아, 회원 유형에 맞는 로그인 알고리즘을 실행
     * 만든날:                         2018년 3월 18일
     *
     * 매개변수 목록
     * @param $request:
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *      $type(string):             현재 회원가입 유형을 알림
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request) {
        // 01. 로그인 관련 데이터 추출
        $type   = $request->type;
        $id     = $request->id;
        $pw     = $request->password;

        // 02. 로그인 유형에 따른 입력 데이터 검증
        $typeValue_student      = self::USER_TYPE['student'];
        $typeValue_professor    = self::USER_TYPE['professor'];
        $rules = [
            'type'      => "required|in:{$typeValue_student},{$typeValue_professor}",
            'password'  => "required"
        ];
        switch($type) {
            case self::USER_TYPE['student']:
                $rules['id'] = 'required|digits:7|exists:students,id';
                break;
            case self::USER_TYPE['professor']:
                $rules['id'] = 'required|exists:professors,id';
                break;
        }
        $this->validate($request, $rules);


        // 03. 로그인 유형에 따른 컨트롤러 라우팅
        if ($type == 'student') {
            return app('App\Http\Controllers\StudentController')->login($id, $pw);
        } else if ($type == 'professor') {
            return app('App\Http\Controllers\ProfessorController')->login($id, $pw);
        }
    }
}
