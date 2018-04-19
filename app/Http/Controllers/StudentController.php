<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAccessibleException;
use App\Http\Controllers\ConstantEnum;
use App\Http\Controllers\ResponseObject;
use App\Http\DbInfoEnum;
use App\Student;
use App\Subject;
use App\Score;
use App\Lecture;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;

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

    // #Web

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
     * @param Request $request :                학생이 작성한 회원가입 Form 데이터
     *
     * 지역변수 목록
     * $data(array):                   View 단에 전달하는 매개인자를 저장하는 배열
     *      $title(string):            HTML Title
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View 예외
     *
     * 예외
     * @throws                         NotAccessibleException
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
        $student = Student::find($request->post('std_id'));

        $student->password  = password_hash($request->post('password'), PASSWORD_DEFAULT);
        $student->email     = $request->post('email');
        $student->phone     = $request->post('phone');

        // 저장 실패시 전 페이지로 돌아감
        if(!$student->save()) {
            throw new NotAccessibleException(__('exception.join_failed'));
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
    public function login($argId, $argPw, $argDevice) {
        // 01. 입력된 아이디를 조회
        $student = Student::find($argId);

        if(is_null($student)) {
            switch($argDevice) {
                case 'android':
                    return response()->json(new ResponseObject(
                            "FALSE", "존재하지 않는 아이디입니다."
                        ), 200
                    );
            }
        }

        // 02. 조회된 학생 계정의 유효성 검증

        // 등록되지 않은 학생
        if($student->password == "") {
            switch($argDevice) {
                case 'android':
                    return response()->json(
                        new ResponseObject('FALSE', __('message.login_not_registered_std_id')),
                        200
                    );
                default:
                    flash()->warning(__('message.login_not_registered_std_id'))->important();
                    return back();
            }

        // 로그인 조건 만족
        } else if(password_verify($argPw, $student->password)) {
            $user_type = self::USER_TYPE;
            session([
                'user' => [
                    'type'  => $user_type,
                    'info'  => $student
                ]
            ]);

            switch($argDevice) {
                case 'android':
                    return response()->json(
                        new ResponseObject('TRUE', __('message.login_success', ['Name' => $student->name])),
                        200
                    );
                default:
                    flash()->success(__('message.login_success', ['Name' => $student->name]));
                    return redirect(route('student.index'));
            }

        // 잘못된 입력
        } else {
            switch($argDevice) {
                case 'android':
                    return response()->json(
                        new ResponseObject("FALSE", __('message.login_wrong_id_or_password')),
                        200
                    );
                default:
                    flash()->warning(__('message.login_wrong_id_or_password'))->important();
                    return back();
            }
        }
    }

    /**
     * 함수명:                         info
     * 함수 설명:                      사용자 정보 관리 페이지를 출력
     * 만든날:                         2018년 4월 05일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info() {
        $data = [
            'title'     => __('page_title.student_info'),
        ];

        return view('student_info', $data);
    }

    // 03-02. 출결 관리

    /**
     * 함수명:                         getAttendanceRecords
     * 함수 설명:                      해당 일자의 출결 기록을 조회
     * 만든날:                         2018년 4월 01일
     *
     * 매개변수 목록
     * @param $argPeriod :             조회기간 설정
     * @param $argDate :               조회일자
     *
     * 지역변수 목록
     * $std_id(integer):               현재 로그한 학생의 학번
     * $attendanceData(array):         조회 결과
     * $data(array):                   View 단에 바인딩할 데이터
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 예외
     *
     * 예외
     * @throws                          NotAccessibleException
     */
    public function getAttendanceRecords($argPeriod = 'weekly', $argDate = null) {
        // 01. 데이터 획득
        $std_id = session()->get('user')['info']->id;
        $attendanceData =
            app('App\Http\Controllers\AttendanceController')->getAttendanceRecords($std_id, $argPeriod, $argDate);

        // 해당 기간동안 출석 데이터가 없을 경우
        $periodData = [];
        switch($argPeriod) {
            case 'weekly':
                $period = $this->getWeeklyValue($argDate);
                $periodData = [
                    'this'      => $period['this_week']->format('Y-m-').$period['this_week']->weekOfMonth,
                    'prev'      => $period['prev_week']->format('Y-m-').$period['prev_week']->weekOfMonth,
                    'next'      => !is_null($period['next_week']) ?
                            $period['next_week']->format('Y-m-').$period['next_week']->weekOfMonth : null
                ];
                break;
            case 'monthly':
                $period = $this->getMonthlyValue($argDate);
                $periodData = [
                    'this'      => $period['this_month']->format('Y-m'),
                    'prev'      => $period['prev_month']->format('Y-m'),
                    'next'      => !is_null($period['next_month']) ?
                        $period['next_month']->format('Y-m') : null
                ];
                break;
        }



        // 02. 매개 데이터 삽입
        $data = [
            'title'                 => __('page_title.student_attendance'),
            'period'                => $argPeriod,

            'date'                  => $periodData['this'],
            'prev_date'             => $periodData['prev'],
            'next_date'             => $periodData['next'],

            // 출석 데이터가 있으면 => 데이터 반환, 없으면 NULL 반환
            'attendance_data'       => $attendanceData
        ];

        return view('student_attendance', $data);
    }

    // 모바일 : 출석율 그래프 그리기
    public function getAttendanceGraph(Request $request) {
        $stdId = $request->post('id');
        $period = 'weekly';
        $date = null;

        $attendanceData =
            app('App\Http\Controllers\AttendanceController')->getAttendanceRecords($stdId, $period, $date);

        $data = [
            'attendance'    => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['ada']},
            'late'          => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['late']},
            'absence'       => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['absence']},
            'early'         => $attendanceData['query_result']->{ConstantEnum::ATTENDANCE['early']}
        ];

        return view('student_attendance_graph', $data);
    }

    // 모바일 : 출석체크
    public function comeSchool() {
        $id = session()->get('user')['info']->id;

        return response()->json(
            app('App\Http\Controllers\AttendanceController')->comeSchool($id),
            200
        );
    }

    // 하드웨어: 출석체크
    public function comeSchoolHardWare(Request $request) {
        $this->validate($request, [
            'stdId'    => 'required|JSON'
        ]);

        $reqData    = json_decode($request->post('stdId'));

        return response()->json(
            app('App\Http\Controllers\AttendanceController')->comeSchool($reqData),
            200
        );
    }

    // 모바일 : 하교하기
    public function leaveSchool() {
        $id = session()->get('user')['info']->id;

        return response()->json(
            app('App\Http\Controllers\AttendanceController')->leaveSchool($id),
            200
        );
    }

    // 하드웨어: 하교하기
    public function leaveSchoolHardWare(Request $request) {
        $this->validate($request, [
            'stdId'    => 'required|JSON'
        ]);

        $reqData    = json_decode($request->post('stdId'));

        return response()->json(
            app('App\Http\Controllers\AttendanceController')->leaveSchool($reqData),
            200
        );
    }

    // 03-03. 학업 관리

    /**
     * 함수명:                         lectureMain
     * 함수 설명:                      사용자가 해당 학기에 수강한 과목에 대한 전과목 학업기록을 조회
     * 만든날:                         2018년 4월 05일
     *
     * 매개변수 목록
     * @param $argTerm :               조회 학기
     *
     * 지역변수 목록
     * $dateInfo(array):               기간 정보
     *      [0]:                       연도
     *      [1]:                       학기
     * $nowTerm(integer):              현재 학기
     * $term(integer):                 조회 시점이 되는 학기
     * $prev_term(integer):            지난 학기
     * $next_term(integer):            다음 학기
     * $stdId(integer):                사용자의 학번
     * $dataList(array):               조회된 과목별 학업 데이터
     *
     * $data(array):                   View 단에 바인딩할 데이터
     *
     * 반환값
     * @return                         \Illuminate\Contracts\View\Factory|\Illuminate\View\View 예외
     *
     * 예외
     * @throws ErrorException
     * @throws NotAccessibleException
     */
    public function lectureMain($argTerm = null) {
        // 01. 변수 설정
        $term           = $this->getTermValue($argTerm);
        $thisTerm       = $term['this_term'];
        $prevTerm       = $term['prev_term'];
        $nextTerm       = $term['next_term'];
        $stdId          = session()->get('user')['info']->id;

        // 02. 학기 정보 설정
        $term_info  = explode('-', $thisTerm);
        $year       = $term_info[0];
        $term       = $term_info[1];

        // 데이터 예외처리
        // 학기 정보가 전송된 경우
        if(!is_null($argTerm)) {
            // 현재 학기에서 조회된 데이터가 없을 경우 예외 발생
            if (sizeof(Subject::where([[DbInfoEnum::SUBJECTS['year'], $year], [DbInfoEnum::SUBJECTS['term'], $term]])
                    ->get()->all()) <= 0) {
                throw new NotAccessibleException(__('exception.not_exists_scores_data'));
            }
        }

        // 03. 학업 데이터 추출
        $dataList       =
            app('App\Http\Controllers\StudyController')->getStudyAchievementList($stdId, $year, $term);

        // 04. View 단에 전송할 데이터
        $term = __('lecture.'.ConstantEnum::TERM[$term]);
        $data = [
            'title'             => __('page_title.student_lecture'),
            'lecture_list'      => $dataList,
            'year'              => $year,
            'term'              => $term,
            'prev_term'         => $prevTerm,
            'next_term'         => $nextTerm
        ];

        return view('student_lecture', $data);
    }

    // 03-04. 상담관리

    /**
     * 함수명:                         counsel
     * 함수 설명:                      해당 일자의 출결 기록을 조회
     * 만든날:                         2018년 4월 05일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 예외
     */
    public function counsel() {
        $data = [
            'title'                 => __('page_title.student_counsel')
        ];

        return view('student_counsel', $data);
    }
}

