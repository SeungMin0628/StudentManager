<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 7:24
 */
?>
<div>언어 선택</div>
<select id="select_language">
    <option id="ko" value="ko">한국어</option>
    <option id="ja" value="ja">日本語</option>
</select>
<script language="JavaScript">
    document.getElementById('select_language').addEventListener('change', function(event) {
        if(event.target.value === '{{ App::getLocale() }}') {
            return;
        }

        location.replace('/language/' + event.target.value);
    });
</script>