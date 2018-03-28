<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 7:24
 */
?>
<div>@lang('interface.language')</div>
<select id="select_language">
    <option id="ko" value="ko">@lang('interface.korean')</option>
    <option id="ja" value="ja">@lang('interface.japanese')</option>
</select>
<script language="JavaScript">
    // 언어 설정
    document.getElementById('select_language').addEventListener('change', function(event) {
        if(event.target.value === '{{ App::getLocale() }}') {
            return;
        }

        location.replace('/language/' + event.target.value);
    });

    // 현재 언어설정 획득하여, 기본 선택 옵션을 해당 언어로 변경
    (function() {
        document.getElementById('{{app()->getLocale()}}').setAttribute('selected', 'selected');
    })();
</script>