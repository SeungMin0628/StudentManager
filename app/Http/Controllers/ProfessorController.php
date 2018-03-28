<?php

namespace App\Http\Controllers;

use App\Professor;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\HomeController;
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
    const   USER_TYPE   = HomeController::USER_TYPE['professor'];

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


    // 교수 공통 기능

    // 01. 회원 관리
    /**
     * 함수명:                         check_join
     * 함수 설명:                      (교수 공통) 사용자가 입력한 ID의 현재 회원가입 여부를 조회
     * 만든날:                         2018년 3월 28일
     *
     * 매개변수 목록
     * @param $request:                View 단의 요청 메시지
     *
     * 지역변수 목록
     * $regMsg(string):                View 단에 반환할 메시지
     * $input_id(string):              사용자가 입력한 ID
     * $professor:                     입력 ID로 DB를 조회한 결과
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function check_join(Request $request) {
        // 01. 변수 설정
        $reqMsg     = '';
        $input_id   = $request->post('id');

        // 02. 해당 학번의 가입 여부 조회
        $professor = Professor::find($input_id);

        if (is_null($professor)) {
            $reqMsg = 'TRUE';
        } else {
            $reqMsg = "FALSE";
        }

        return response()->json(['msg' => $reqMsg], 200);
    }

    /**
     * 함수명:                         check_join
     * 함수 설명:                      (교수 공통) 사용자가 입력한 ID의 현재 회원가입 여부를 조회
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
            flash()->warning(@lang('message.login_wrong_id_or_password'))->important();
            return back();
        }
    }
}
