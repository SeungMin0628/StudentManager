<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-04-09
 * Time: 오후 8:40
 */

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

/**
 * 클래스명:                       UploadScoresFormExport
 * @package                        App\Exports
 * 클래스 설명:                    성적 업로드 양식 지정에 사용하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 9일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class UploadScoresFormExport implements FromCollection, WithColumnFormatting, ShouldAutoSize {
    // 엑셀로 반환할 데이터 배열
    private $data;

    public function __construct(array $argData) {
        $this->data = $argData;
    }

    /**
     * @return Collection
     */
    public function collection() {
        // TODO: Implement collection() method.
        return new Collection($this->data);
    }

    /**
     * @return array
     */
    public function columnFormats(): array {
        // TODO: Implement columnFormats() method.
        return [

        ];
    }
}