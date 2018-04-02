<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Student;
use App\Http\Controllers\ConstantEnum;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Mockery\Exception;
use PhpParser\Error;
use Psy\Exception\ErrorException;
use Symfony\Component\CssSelector\Tests\Node\CombinedSelectorNodeTest;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

/**
 * 클래스명:                       StudentController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    학생이 사용하는 기능에 대해 정의하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 16일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class StudentController extends Controller {
    // 01. 멤버 변수
    const   STD_ID_DIGITS   = 7;
    const   USER_TYPE       = ConstantEnum::USER_TYPE['student'];

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
            'title'     => __('page_title.student_index')
        ];

        return view('student_main', $data);
    }

    // 03-01. 계정 관리
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
        $student = Student::find($request->post('id'));

        $student->password  = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $student->email     = $request->post('email');
        $student->phone     = $request->post('phone');

        // 저장 실패시 전 페이지로 돌아감
        if(!$student->save()) {
            flash()->error(__('message.join_failed'))->important();
            return back();
        }

        flash(__('message.join_success'));
        return redirect(route('home.index'));
    }

    /**
     * 함수명:                         check_join
     * 함수 설명:                      사용자가 입력한 학번이 현재 회원가입된 학번인지 검증
     * 만든날:                         2018년 3월 23일
     *
     * 매개변수 목록
     * @param $request:                요청 객체
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_join(Request $request) {
        // 01. 변수 설정
        $reqMsg     = '';
        $input_id   = $request->post('std_id');

        // 02. 해당 학번의 가입 여부 조회
        $student = Student::find($input_id);

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
        $student = Student::find($argId);

        // 02. 조회된 학생 계정의 유효성 검증

        // 등록되지 않은 학생
        if($student->password == "") {
            flash()->warning(__('message.login_not_registered_std_id'))->important();
            return back();

        // 로그인 조건 만족
        } else if(password_verify($argPw, $student->password)) {
            $user_type = self::USER_TYPE;
            session([
                'user' => [
                    'type'  => $user_type,
                    'info'  => $student
                ]
            ]);

            flash()->success(__('message.login_success', ['Name' => $student->name]));
            return redirect(route('student.index'));

        // 잘못된 입력
        } else {
            flash()->warning(__('message.login_wrong_id_or_password'))->important();
            return back();
        }
    }

    // 03-02. 출결 관리
    /**
     * 함수명:                         getAttendanceRecords
     * 함수 설명:                      해당 일자의 출결 기록을 조회
     * 만든날:                         2018년 4월 01일
     *
     * 매개변수 목록
     * @param $argPeriod:              조회기간 설정
     * @param $argDate:                조회일자
     *
     * 지역변수 목록
     * $std_id(integer):               현재 로그한 학생의 학번
     * $attendanceData(array):         조회 결과
     * $data(array):                   View 단에 바인딩할 데이터
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAttendanceRecords($argPeriod = ConstantEnum::PERIOD['weekly'], $argDate = null) {
        // 01. 데이터 획득
        $std_id = session()->get('user')['info']->id;
        $attendanceData =
            app('App\Http\Controllers\AttendanceController')->getAttendanceRecords($std_id, $argPeriod, $argDate);

        if(is_null($attendanceData)) {
            flash()->warning(__('message.ada_records_not_exists'));
            return back();
        }

        // 02. 매개 데이터 삽입
        $data = [
            'title'                 => __('page_title.student_attendance'),
            'period'                => $argPeriod,

            'date'                  => $attendanceData['now_date'],
            'prev_date'             => $attendanceData['prev_date'],
            'next_date'             => $attendanceData['next_date'],

            'attendance_rate'       => number_format($attendanceData['rate'], 2),
            'attendance'            => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['ada']},
            'nearest_attendance'    => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['n_ada']},

            'late'                  => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['late']},
            'nearest_late'          => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['n_late']},

            'absence'               => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['absence']},
            'nearest_absence'       => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['n_absence']},

            'early'                 => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['early']},
            'nearest_early'         => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['n_early']},
        ];

        return view('student_attendance', $data);
    }

    // 03-03. 학업 관리 메인
    public function lectureMain() {
        // 03. View 단에 전송할 데이터
        $data = [
            'title'             => __('page_title.student_lecture_main'),
        ];

        return view('student_lecture_main', $data);
    }
}
