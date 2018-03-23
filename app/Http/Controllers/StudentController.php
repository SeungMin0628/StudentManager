<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class StudentController extends Controller
{
    // 01. 멤버 변수
    const STD_ID_DIGITS = 7;

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
            'std_id'            => 'required|digits:7',
            'password'          => 'required',
            'password_check'    => 'required|same:password',
            'email'             => 'required|email',
            'phone'             => 'required|digits:11'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }



        return redirect(route('home.index'))->with('flash_message', '안녕');
    }

    /**
     * 함수명:                         check
     * 함수 설명:                      사용자가 입력한 학번이 현재 회원가입된 학번인지 검증
     * 만든날:                         2018년 3월 23일
     *
     * 매개변수 목록
     * @param Request $request         요청 객체
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request) {
        // 01. 변수 설정
        $reqMsg     = '';
        $input_id   = $request->post('std_id');
        $pattern    = "/[0-9]/";

        try {
            // 02. 입력값 유효성 검사
            if(strlen($input_id) != self::STD_ID_DIGITS || !preg_match($pattern, $input_id)) {
                throw new Exception();
            }

            // 03. 해당 학번의 가입 여부 조회
            $student = \App\Student::find($input_id);

            if (is_null($student)) {
                throw new Exception();
            } else if($student->password != "") {
                $reqMsg = "EXISTS";
            } else {
                $reqMsg = $student->name;
            }
        } catch(Exception $e) {
            $reqMsg = "FALSE";
        } finally {
            return response()->json(['msg' => $reqMsg], 200);
        }
    }
}
