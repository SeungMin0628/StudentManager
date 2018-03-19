<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    // 01. 멤버 변수
    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         index
     * 함수 설명:                      학생이 로그인했을 때 가장 먼저 보는 메인 페이지
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
    }

    /**
     * 함수명:                         store
     * 함수 설명:                      학생이 작성한 회원가입 양식을 검증하고 저장
     * 만든날:                         2018년 3월 16일
     *
     * 매개변수 목록
     * @param $request:                학생이 작성한 회원가입 Form 데이터
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request) {
        $rules = [
            'std_id'        => ['required']
        ];

        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }



        return redirect(route('home.index'))->with('flash_message', '안녕');
    }

    /**
     * 함수명:                         checkAccount
     * 함수 설명:                      사용자가 입력한 학번이 현재 회원가입된 학번인지 검증
     * 만든날:                         2018년 3월 16일
     *
     * 매개변수 목록
     * @param $inputId:                사용자가 작성한 학번
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkAccount($inputId) {

    }
}
