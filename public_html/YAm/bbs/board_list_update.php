<?php
include_once('./_common.php');

$count = count($_POST['chk_wr_id']);


if(!$count) {
    alert($_POST['btn_submit'].' 하실 항목을 하나 이상 선택하세요.');
}

if($_POST['btn_submit'] == '선택삭제') {
    include './delete_all.php';
} else if($_POST['btn_submit'] == '선택복사') {
    $sw = 'copy';
    include './move.php';
} else if($_POST['btn_submit'] == '선택이동') {
    $sw = 'move';
    include './move.php';
} else if($_POST['btn_submit'] == '수강취소') {

	for($i = 0; $i < $count; $i++) {
		$sql = "update {$write_table}
					set wr_9 = '0'
				where wr_id = '{$_POST['chk_wr_id'][$i]}'";

		sql_query($sql);
	}

	alert("수강취소가 완료되었습니다.");

} else if($_POST['btn_submit'] == '선택폐강') {

    for($i = 0; $i < $count; $i++) {
		$sql = "update {$write_table}
					set wr_10 = 'N',
                    wr_last ='".G5_TIME_YMDHIS."'
				where wr_id = '{$_POST['chk_wr_id'][$i]}'";

		sql_query($sql);
	}

    alert("폐강 처리 되었습니다.");

} else if($_POST['btn_submit'] == '선택폐강취소') {

    for($i = 0; $i < $count; $i++) {
		$sql = "update {$write_table}
					set wr_10 = '',
                    wr_last ='".G5_TIME_YMDHIS."'
				where wr_id = '{$_POST['chk_wr_id'][$i]}' and wr_10 = 'N'";

		sql_query($sql);
	}


    alert("폐강취소 처리 되었습니다.");

} else if($_POST['btn_submit'] == '선택마감') {

    for($i = 0; $i < $count; $i++) {
		$sql = "update {$write_table}
					set wr_10 = 'F',
                    wr_last ='".G5_TIME_YMDHIS."'
				where wr_id = '{$_POST['chk_wr_id'][$i]}'";

		sql_query($sql);
	}

    alert("마감 처리 되었습니다.");

} else if($_POST['btn_submit'] == '선택마감취소') {

    for($i = 0; $i < $count; $i++) {
		$sql = "update {$write_table}
					set wr_10 = '',
                    wr_last ='".G5_TIME_YMDHIS."'
				where wr_id = '{$_POST['chk_wr_id'][$i]}' and wr_10 = 'F'";

		sql_query($sql);
	}

    alert("마감취소 처리 되었습니다.");

} else {
    alert('올바른 방법으로 이용해 주세요.');
}
?>
