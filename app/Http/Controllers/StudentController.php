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
     * 함수 설명:                      학생이 로그인했을 때 가장 먼저 보는 메인 페이지를 출력
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
            'title'     => 'student: main'
        ];

        return view('student_main', $data);
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
        // 01. form 입력값 검증
        $rules = [
            'std_id'            => 'required|digits:7',
            'std_id_check'      => 'required|accepted',
            'name'              => 'required',
            'password'          => 'required',
            'check_password'    => 'required|same:password',
            'email'             => 'required|email',
            'phone'             => 'required|digits:11'
        ];
        $this->validate($request, $rules);

        // 02. 학생 데이터 입력
        $student = \App\Student::find($request->std_id);

        $student->password  = password_hash($request->password, PASSWORD_DEFAULT);
        $student->email     = $request->email;
        $student->phone     = $request->phone;

        // 저장 실패시 전 페이지로 돌아감
        if(!$student->save()) {
            return back()->with('flash_message', '에러: 회원가입 실패')->withInput();
        }

        flash('회원가입 완료!');
        return redirect(route('home.index'));
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

        // 02. 해당 학번의 가입 여부 조회
        $student = \App\Student::find($input_id);

        if (is_null($student)) {
            $reqMsg = "FALSE";
        } else if($student->password != "") {
            $reqMsg = "EXISTS";
        } else {
            $reqMsg = $student->name;
        }

        return response()->json(['msg' => $reqMsg], 200);
    }

    /**
     * 함수명:                         login
     * 함수 설명:                      아이디와 비밀번호를 받아 학생 로그인 알고리즘을 실행
     * 만든날:                         2018년 3월 24일
     *
     * 매개변수 목록
     * @param $argId(string)           사용자가 입력한 아이디
     * @param $argPw(string)           사용자가 입력한 비밀번호
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login($argId, $argPw) {
        // 01. 입력된 아이디를 조회
        $student = \App\Student::find($argId);

        // 02. 조회된 학생 계정의 유효성 검증

        // 등록되지 않은 학생
        if($student->password == "") {
            flash()->warning('가입절차를 거치지 않은 학번입니다. 먼저 회원가입을 해주세요.')->important();
            return back();

        // 로그인 조건 만족
        } else if(password_verify($argPw, $student->password)) {
            flash()->success("환영합니다, {$student->name}님!");
            return redirect(route('student.index'));

        // 잘못된 입력
        } else {
            flash()->warning('잘못된 아이디 혹은 비밀번호입니다.')->important();
            return back();
        }
    }
}
