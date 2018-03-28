<?php

namespace App\Http\Controllers;

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
    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         index
     * 함수 설명:                      교과목 교수가 로그인했을 때 가장 먼저 보는 메인 페이지를 출력
     * 만든날:                         2018년 3월 28일
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

    }

    // 01. 회원 관리
    public function check_join(Request $request) {
        // 01. 변수 설정
        $reqMsg     = '';
        $input_id   = $request->post('std_id');

        // 02. 해당 학번의 가입 여부 조회
        $professor = \App\Professor::find($input_id);

        if (!is_null($professor)) {
            $regMsg = 'FALSE'
        }

        return response()->json(['msg' => $reqMsg], 200);
    }
}
