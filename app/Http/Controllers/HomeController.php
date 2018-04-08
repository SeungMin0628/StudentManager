<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ConstantEnum;
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
class HomeController extends Controller {
    // 01. 멤버 변수 정의

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
        // 01. 현재 로그인 여부 확인
        if(session()->has('user')) {
            $user_type = session()->get('user')['type'];
            return redirect(route("{$user_type}.index"));
        }

        // 02. 데이터 바인딩
        $data = [
            'title'         => __('page_title.home_index'),
            'user_type'     => ConstantEnum::USER_TYPE
        ];

        return view('login', $data);
    }

    // 03-01. 회원 관리
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
            'title'     => __('page_title.home_join_select'),
            'user_type' => ConstantEnum::USER_TYPE
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
            case ConstantEnum::USER_TYPE['student']:
                $data['title']  = __('page_title.home_join_student');
                $data['type']   = __('account.student');

                return view('join_student', $data);
            case ConstantEnum::USER_TYPE['tutor']:
                $data['title']  = __('page_title.home_join_tutor');
                $data['type']   = __('account.prof_tutor');

                return view('join_tutor', $data);
            case ConstantEnum::USER_TYPE['professor']:
                $data['title']  = __('page_title.home_join_professor');
                $data['type']   = __('account.prof_general');

                return view('join_professor', $data);
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
     */
    public function login(Request $request) {
        // 01. 로그인 관련 데이터 추출
        $type   = $request->post('type');
        $id     = $request->post('id');
        $pw     = $request->post('password');

        // 02. 로그인 유형에 따른 입력 데이터 검증
        $typeValue_student      = ConstantEnum::USER_TYPE['student'];
        $typeValue_professor    = ConstantEnum::USER_TYPE['professor'];
        $rules = [
            'type'      => "required|in:{$typeValue_student},{$typeValue_professor}",
            'password'  => "required"
        ];
        switch($type) {
            case ConstantEnum::USER_TYPE['student']:
                $rules['id'] = 'required|digits:7|exists:students,id';
                break;
            case ConstantEnum::USER_TYPE['professor']:
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

    /**
     * 함수명:                         logout
     * 함수 설명:                      현재 사용자의 로그아웃을 실행
     * 만든날:                         2018년 3월 27일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        if(session()->has('user')) {
            session()->forget('user');
            flash()->success(__('message.logout_success'));
        }
        return redirect(route('home.index'));
    }

    /**
     * 함수명:                         forgot
     * 함수 설명:                      아이디/비밀번호 찾기 관련 기능을 실행
     * 만든날:                         2018년 3월 29일
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
    public function forgot() {
        $data = [
            'title' => __('page_title.home_forgot_select')
        ];

        return view('forgot', $data);
    }

    // 03-02. 다국어 지원
    /**
     * 함수명:                         setLanguage
     * 함수 설명:                      언어 변경 요청을 받아, 제공하는 언어 패키지를 변경
     * 만든날:                         2018년 3월 27일
     *
     * 매개변수 목록
     * @param $locale:                 View 단에서 변경을 요청한 언어 코드
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                          \Illuminate\Http\RedirectResponse
     */
    public function setLanguage($locale) {
        // 01. 언어 설정
        if(in_array($locale, config()->get('app.locales'))) {
            session()->put('locale', $locale);
        }
        app()->setLocale($locale);

        return redirect()->back();
    }
}
