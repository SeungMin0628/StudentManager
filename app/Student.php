<?php

namespace App;

use App\Http\Controllers\ConstantEnum;
use Illuminate\Database\Eloquent\Model;
use App\Http\DbInfoEnum;
use Illuminate\Support\Facades\DB;

/**
 * 클래스명:                       Student
 * 클래스 설명:                    학생 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Student extends Model {
    // 01. 멤버 변수 설정
    public $incrementing    = false;
    public $timestamps      = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         comments
     * 함수 설명:                      코멘트 테이블과 학생 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany('App\Comment', 'std_id', 'id');
    }

    /**
     * 함수명:                         counsels
     * 함수 설명:                      상담 테이블과 학생 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counsels() {
        return $this->hasMany('App\Counsel', 'std_id', 'id');
    }

    /**
     * 함수명:                         attendances
     * 함수 설명:                      학생 테이블과 출석 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances() {
        return $this->hasMany('App\Attendance', 'std_id', 'id');
    }

    /**
     * 함수명:                         positions
     * 함수 설명:                      학생위치 테이블과 학생 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions() {
        return $this->hasMany('App\Position', 'std_id', 'id');
    }

    /**
     * 함수명:                         fingerprints
     * 함수 설명:                      학생 테이블과 지문 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fingerprints() {
        return $this->hasMany('App\Fingerprint', 'std_id', 'id');
    }

    /**
     * 함수명:                         gainedScores
     * 함수 설명:                      학생 테이블과 취득점수 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gainedScores() {
        return $this->hasMany('App\GainedScore', 'std_id', 'id');
    }

    /**
     * 함수명:                         CheckInLecture
     * 함수 설명:                      학생 테이블과 강의 중 출석 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkInLectures() {
        return $this->hasMany('App\CheckInLecture', 'std_id', 'id');
    }

    /**
     * 함수명:                         signUpLists
     * 함수 설명:                      학생 테이블과 수강목록 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signUpLists() {
        return $this->hasMany('App\SignUpList', 'std_id', 'id');
    }

    /**
     * 함수명:                         group
     * 함수 설명:                      학생 테이블과 반 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group() {
        return $this->belongsTo('App\Group', 'group', 'id');
    }

    /**
     * 함수명:                         alerts
     * 함수 설명:                      학생 테이블과 알림 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts() {
        return $this->hasMany('App\Alert', 'std_id', 'id');
    }

    /**
     *  함수명:                            getLecturesInfo
     *  함수 설명:                         해당 학생이 해당 학기에 수강한 강의의 코드를 조회
     *  만든날:                            2018년 4월 4일
     *
     *  매개변수 목록
     *  @param $argYear:                   조회 연도
     *  @param $argTerm:                   조회 학기
     *
     *  지역변수 목록
     *  null
     *
     *  반환값
     *  @return                            mixed
     */
    public function getLecturesIdAtThisTerm($argYear, $argTerm) {
        return $this->signUpLists()
            // 수강 과목 테이블 조인 - 강의 코드와 과제별 성적 반영율을 획득
            ->join(DbInfoEnum::LECTURES['t_name'], DbInfoEnum::SIGN_UP_LISTS['t_name'].'.'.DbInfoEnum::SIGN_UP_LISTS['lec'], DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['id'])
            // 과목 테이블 조인 - 조회 연도와 학기를 제한하기 위해
            ->join(DbInfoEnum::SUBJECTS['t_name'], function($join) use ($argYear, $argTerm) {
                $join->on(DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['sub_id'], DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['id'])
                    ->where([
                        [DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['year'], $argYear],
                        [DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['term'], $argTerm]
                    ]);
            })
            // 조회목록 : 강의 아이디
            ->select(DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['id'])
            ->get()->all();
    }

    /**
     *  함수명:                            getDetailsOfLecture
     *  함수 설명:                         해당 강의에서 학생이 취득한 성적을 조회
     *  만든날:                            2018년 4월 4일
     *
     *  매개변수 목록
     *  @param $argLectureId:              조회하는 강의 번호
     *
     *  지역변수 목록
     *  null
     *
     *  반환값
     *  @return                            mixed
     */
    public function getDetailsOfLecture($argLectureId) {
        return $this->gainedScores()
            ->rightJoin(DbInfoEnum::SCORES['t_name'], function($join) use ($argLectureId) {
                $join->on(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['id'], DbInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['type'])
                    ->where(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['lecture'], $argLectureId);
            })->selectRaw(
                DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['reg_date'].",
                CASE ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['type']." 
                WHEN ".ConstantEnum::SCORE['midterm']." THEN '".__('lecture.midterm')."'
                WHEN ".ConstantEnum::SCORE['final']." THEN '".__('lecture.final')."'
                    WHEN ".ConstantEnum::SCORE['quiz']." THEN '".__('lecture.quiz')."'
                WHEN ".ConstantEnum::SCORE['task']." THEN '".__('lecture.task')."' 
                END AS '".DbInfoEnum::SCORES['type']."', 
                ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['content'].", 
                ".DBInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['score'].", 
                ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['prefect']
            )->orderBy(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['reg_date'], 'desc');

        /*
         * Student::find(9885116)->gainedScores()
         * ->join('scores', function($join) {
         *      $join->on('scores.id', 'gained_scores.score_type')
         *          ->where('scores.lecture_id', 14);
         * })->selectRaw("
         *      scores.reg_date,
         *      CASE scores.type
         *          WHEN 1 THEN 'AAA'
         *          ELSE 'BBB' END AS 'TYPE',
         *      scores.content, gained_scores.score,
         *      scores.perfect_score
         * ")->orderBy('scores.reg_date', 'desc')
         * ->paginate(3)
         */
    }

    // 누적 지각/결석/조퇴 데이터 조회
    public function selectConsecutiveAttendanceData($argDaysUnit = null) {
        // 출석 테이블 조인 결과
        // 관측 일자를 지정하지 않았을 때
        $joinResult = 0;
        if(is_null($argDaysUnit)) {
            $joinResult = $this->attendances()
                ->join('come_schools', 'attendances.come_school', 'come_schools.id')
                ->leftJoin('leave_schools', 'attendances.leave_school', 'leave_schools.id')
                ->orderBy('attendances.reg_date', 'desc');
        } else {
            // 관측 일자를 지정했을 때
            $endDate = today()->format('Y-m-d');
            $startDate = today()->subDays($argDaysUnit)->format('Y-m-d');

            $joinResult = $this->attendances()
                ->where([['reg_date', '>', "{$startDate}"], ['reg_date', '<=', "{$endDate}"]])
                ->join('come_schools', 'attendances.come_school', 'come_schools.id')
                ->leftJoin('leave_schools', 'attendances.leave_school', 'leave_schools.id')
                ->orderBy('attendances.reg_date', 'desc');
        }

        // 데이터 조회 : 연속 지각횟수, 연속 결석횟수, 연속 조퇴횟수
        // 실제 반영 데이터
        $consecutiveLate = null;
        $consecutiveAbsence = null;
        $consecutiveEarly = null;
        // 계산용 임시 데이터
        $tempLate = 0;
        $tempAbsence = 0;
        $tempEarly = 0;

        // 쿼리 결과 => 행 추출
        foreach ($joinResult->get()->toArray() as $row) {
            // 행 => 각 셀의 데이터 추출
            foreach ($row as $key => $data) {
                switch ($key) {
                    // 지각 횟수 계산
                    case 'lateness_flag':
                        if ($data == TRUE) {
                            $tempLate++;
                        } else if($consecutiveLate <= 0) {
                            $consecutiveLate = $tempLate;
                        }
                        break;
                    // 조퇴 횟수 계산
                    case 'early_flag':
                        if ($data == TRUE) {
                            $tempEarly++;
                        } else if($consecutiveLate <= 0) {
                            $consecutiveEarly = $tempEarly;
                        }
                        break;
                    // 결석 횟수 계산
                    case 'absence_flag':
                        if ($data == TRUE) {
                            $tempAbsence++;
                        } else if($consecutiveLate <= 0) {
                            $consecutiveAbsence = $tempAbsence;
                        }
                        break;
                    default:
                        continue;
                }
            }

            // 연속 출결 횟수 데이터를 모두 구할 시 => 반복문 종료
            if(!is_null($consecutiveEarly)  && !is_null($consecutiveLate) && !is_null($consecutiveAbsence)) {
                break;
            }
        }

        // 데이터 결합
        return [
            'consecutive_late' => $consecutiveLate,
            'consecutive_absence' => $consecutiveAbsence,
            'consecutive_early' => $consecutiveEarly
        ];
    }


    // 최근의 출석 데이터를 조회
    public function selectRecentlyAttendanceRecords($argDaysUnit = null) {
        // 데이터 조회 : 총 출석일, 총 지각횟수, 총 결석횟수, 총 조퇴횟수, 최근 등교&하교 시각,
        //                  최근 지각 일자, 최근 결석일자, 최근 조퇴일자
        $joinResult = null;
        // 관측 일자가 없을 때
        if(is_null($argDaysUnit)) {
            $joinResult = $this->attendances()
                ->join('come_schools', 'attendances.come_school', 'come_schools.id')
                ->leftJoin('leave_schools', 'attendances.leave_school', 'leave_schools.id');
        } else {
            $endDate = today()->format('Y-m-d');
            $startDate = today()->subDays($argDaysUnit)->format('Y-m-d');

            // 관측 일자가 있을 때
            $joinResult = $this->attendances()
                ->where([['reg_date', '>', "{$startDate}"], ['reg_date', '<=', "{$endDate}"]])
                ->join('come_schools', 'attendances.come_school', 'come_schools.id')
                ->leftJoin('leave_schools', 'attendances.leave_school', 'leave_schools.id');
        }

        $queryResult = $joinResult
            ->select(
            // 총 출석 횟수
            DB::raw("(COUNT('attendances.id') - 
                        COUNT(CASE come_schools.lateness_flag WHEN TRUE THEN TRUE END) - 
                        COUNT(CASE attendances.absence_flag WHEN TRUE THEN TRUE END)) AS 'total_ada'"),
            // 총 지각 횟수
            DB::raw("COUNT(CASE come_schools.lateness_flag WHEN TRUE THEN TRUE END) AS 'total_late'"),
            // 총 결석 횟수
            DB::raw("COUNT(CASE attendances.absence_flag WHEN TRUE THEN TRUE END) AS 'total_absence'"),
            // 총 조퇴 횟수
            DB::raw("COUNT(CASE leave_schools.early_flag WHEN TRUE THEN  TRUE END) AS 'total_early'"),

            // 최근 등교
            DB::raw("MAX(come_schools.reg_time) AS 'recent_come'"),
            // 최근 결석
            DB::raw("MAX(CASE attendances.absence_flag WHEN TRUE THEN attendances.reg_date END) AS 'recent_absence'"),
            // 최근 조퇴
            DB::raw("MAX(CASE leave_schools.early_flag WHEN TRUE THEN attendances.reg_date END) AS 'recent_early'"),

            // 최근 하교
            DB::raw("MAX(leave_schools.reg_time) AS 'recent_leave'"),
            // 최근 지각
            DB::raw("MAX(CASE come_schools.lateness_flag WHEN TRUE THEN come_schools.reg_time END) AS 'recent_late'")
        )->get()->all()[0]->toArray();

        // 데이터 결합
        $consecutiveData = $this->selectConsecutiveAttendanceData();

        return array_merge_recursive($queryResult, $consecutiveData);
    }

    // 모든 출석기록 조회 (페이지네이션)
    public function selectMyAbsenceRecords() {
        return $this->attendances()
            ->join('come_schools', 'attendances.come_school', 'come_schools.id')
            ->leftJoin('leave_schools', 'attendances.leave_school',  'leave_schools.id')
            ->select(
                'attendances.reg_date AS reg_date', 'come_schools.reg_time AS come',
                'leave_schools.reg_time AS leave', 'come_schools.lateness_flag AS late',
                'leave_schools.early_flag AS early', 'attendances.absence_flag AS absence'
            )->orderBy('attendances.reg_date', 'desc')
            ->paginate(10);
    }

    // 자신의 오늘 출석 기록을 조회
    public function selectAttendanceRecordOfToday() {
        $today = today()->format('Y-m-d');

        return $this->where('students.id', $this->id)->leftJoin('attendances', function($join) use($today) {
            $join->on('attendances.std_id', 'students.id')->where('reg_date', "{$today}");})
            ->leftJoin('come_schools', 'come_schools.id', 'attendances.come_school')
            ->leftJoin('leave_schools', 'leave_schools.id', 'attendances.leave_school')
            ->select(
                'students.id', 'students.name', 'come_schools.reg_time AS come', 'leave_schools.reg_time AS leave',
                'come_schools.lateness_flag', 'leave_schools.early_flag', 'attendances.absence_flag'
            );
    }

    // 내 지도학생의 오늘 출석 기록 조회
    public function selectMyStudentsAttendanceOfToday($argDaysUnit = null) {
        // 01. 변수 설정
        $todayAttendance        = $this->selectAttendanceRecordOfToday()->get()[0]->toArray();
        $consecutiveAttendance  = $this->selectConsecutiveAttendanceData($argDaysUnit);
        $totalAttendance        = $this->selectRecentlyAttendanceRecords($argDaysUnit);

        return [
            // 학생 정보
            'id'                    => $todayAttendance['id'],
            'name'                  => $todayAttendance['name'],

            // 오늘자 등교 정보
            'come'                  => $todayAttendance['come'],
            'leave'                 => $todayAttendance['leave'],
            'late_flag'             => $todayAttendance['lateness_flag'],
            'absence_flag'          => $todayAttendance['absence_flag'],

            // 연속 출석기록
            'consecutive_late'      => $consecutiveAttendance['consecutive_late'],
            'consecutive_absence'   => $consecutiveAttendance['consecutive_absence'],
            'consecutive_early'     => $consecutiveAttendance['consecutive_early'],

            // 누적 출석기록
            'total_late'            => $totalAttendance['total_late'],
            'total_absence'         => $totalAttendance['total_absence'],
            'total_early'           => $totalAttendance['total_early']
        ];
    }
}