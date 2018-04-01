<?php

namespace App\Http\Controllers;

use App\Professor;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\ConstantEnum;
use Illuminate\Http\Request;

/**
 * 클래스명:                       ProfessorController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    교과목 교수가 필요로하는 수행하는 컨트롤러 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 28일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class ProfessorController extends Controller {
    // 01. 멤버 변수 설정
    const   USER_TYPE   = ConstantEnum::USER_TYPE['professor'];
    const   MIN_STRLEN  = 2;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 교과목 교수 전용 기능
    /**
     * 함수명:                         index
     * 함수 설명:                      교과목 교수가 로그인했을 때 가장 먼저 보는 메인 페이지를 출력
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
            'title'     => __('page_title.professor_index')
        ];

        return view('professor_main', $data);
    }

    /**
     * 함수명:                         store
     * 함수 설명:                      사용자의 회원가입 정보를 받아 검증 & 교과목교수 데이터로 저장
     * 만든날:                         2018년 3월 29일
     *
     * 매개변수 목록
     * @param $request :               View 단에서 전달받은 요청 데이터
     *
     * 지역변수 목록
     * $rules(array):                  Form 데이터 유효성 검증 규칙
     *
     * 반환값
     * @return                         \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
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
        $professor = Professor::find($request->post('id'));
        $professor->name        = $request->post('name');
        $professor->password    = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $professor->email       = $request->post('email');
        $professor->phone       = $request->post('phone');
        $professor->office      = $request->post('office');

        // 저장 실패시 전 페이지로 돌아감
        if(!$professor->save()) {
            flash()->error(__('message.join_failed'))->important();
            return back();
        }

        flash(__('message.join_success'));
        return redirect(route('home.index'));
    }

    /**
     * 함수명:                         check_join
     * 함수 설명:                      사용자가 입력한 아이디가 등록 가능한 아이디인지 검증
     * 만든날:                         2018년 3월 29일
     *
     * 매개변수 목록
     * @param $request :               View 단에서 전송한 메시지
     *
     * 지역변수 목록
     * $rules(array):                  Form 데이터 유효성 검증 규칙
     *
     * 반환값
     * @return                         \Illuminate\Http\JsonResponse
     */
    public function check_join(Request $request) {
        // 01. 사용자 입력 ID 획득
        $regMsg     = '';
        $inputId    = $request->post('id');

        // 02. 입력한 ID를 DB에 조회
        $professor  = Professor::find($inputId);

        // 03. 조건 검사
        if($professor->password === "" && !is_null($professor->expire_date)) {
            $regMsg = "TRUE";
        } else {
            $regMsg = "FALSE";
        }

        return response()->json(['msg' => $regMsg], 200);
    }

    // 교수 공통 기능

    // 01. 회원 관리
    /**
     * 함수명:                         login
     * 함수 설명:                      (교수 공통) 사용자가 입력한 ID로 로그인 알고리즘 실행
     * 만든날:                         2018년 3월 28일
     *
     * 매개변수 목록
     * @param $argId:                  사용자 ID
     * @param $argPw:                  사용자 패스워드
     *
     * 지역변수 목록
     * $regMsg(string):                View 단에 반환할 메시지
     * $input_id(string):              사용자가 입력한 ID
     * $professor:                     입력 ID로 DB를 조회한 결과
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login($argId, $argPw) {
        // 01. 입력된 아이디를 조회
        $professor = Professor::find($argId);

        // 02. 조회된 교수 계정의 유효성 검증

        // 로그인 조건 만족
        if(password_verify($argPw, $professor->password)) {

            // 해당 사용자가 지도교수 계정인 경우
            if(is_null($professor->manager) && is_null($professor->expire_date)) {
                return app('App\Http\Controllers\TutorController')->login($professor);
            }

            // 해당 사용자가 교과목 교수 계정인 경우
            // 세션에 사용자 정보 등록
            $user_type = self::USER_TYPE;
            session([
                'user' => [
                    'type'  => $user_type,
                    'info'  => $professor
                ]
            ]);

            flash()->success(__('message.login_success', ['Name' => $professor->name]));
            return redirect(route('professor.index'));

        // 잘못된 입력
        } else {
            flash()->warning(__('message.login_wrong_id_or_password'))->important();
            return back();
        }
    }
}
