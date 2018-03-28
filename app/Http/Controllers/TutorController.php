<?php

namespace App\Http\Controllers;

use App\Professor;
use Illuminate\Http\Request;

/**
 * 클래스명:                       TutorController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    지도교수가 사용하는 기능에 대해 정의하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 28일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class TutorController extends Controller {
    // 01. 멤버 변수 설정
    const   USER_TYPE   = HomeController::USER_TYPE['tutor'];

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         index
     * 함수 설명:                      지도 교수가 로그인했을 때 가장 먼저 보는 메인 페이지를 출력
     * 만든날:                         2018년 3월 28일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $data = [
            'title'     => __('page_title.tutor_index')
        ];

        return view('tutor_main', $data);
    }

    // 03-01. 회원관리 기능
    /**
     * 함수명:                         store
     * 함수 설명:                      사용자의 회원가입 정보를 받아 검증 & 지도교수 데이터로 저장
     * 만든날:                         2018년 3월 28일
     *
     * 매개변수 목록
     * @param $request:                View 단에서 전달받은 요청 데이터
     *
     * 지역변수 목록
     * $rules(array):                  Form 데이터 유효성 검증 규칙
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request) {
        // 01. form 입력값 검증
        $rules = [
            'id'                => 'required',
            'id_check'          => 'required|accepted',
            'name'              => 'required',
            'password'          => 'required',
            'check_password'    => 'required|same:password',
            'email'             => 'required|email',
            'phone'             => 'required|digits:11',
            'office'            => 'required'
        ];
        $this->validate($request, $rules);

        // 02. 교수 데이터 입력
        $professor = new Professor();
        $professor->id          = $request->id;
        $professor->name        = $request->name;
        $professor->password    = password_hash($request->password, PASSWORD_DEFAULT);
        $professor->email       = $request->email;
        $professor->phone       = $request->phone;
        $professor->office      = $request->office;

        // 저장 실패시 전 페이지로 돌아감
        if(!$professor->save()) {
            flash()->error(__('message.join_failed'))->important();
            return back();
        }

        flash(__('message.join_success'));
        return redirect(route('home.index'));
    }
    /**
     * 함수명:                         store
     * 함수 설명:                      사용자의 회원가입 정보를 받아 검증 & 지도교수 데이터로 저장
     * 만든날:                         2018년 3월 28일
     *
     * 매개변수 목록
     * @param $professor:              검증이 끝난 교수 데이터
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Professor $professor) {
        // 01. 세션에 사용자 정보 등록
        $user_type = self::USER_TYPE;
        session([
            'user' => [
                'type'  => $user_type,
                'info'  => $professor
            ]
        ]);

        flash()->success(__('message.login_success', ['Name' => $professor->name]));
        return redirect(route('tutor.index'));
    }
}
