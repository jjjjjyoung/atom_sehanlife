<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$edu_id) {
	alert('잘못된 접근입니다.');
	exit;
}

add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$edu = sql_fetch("SELECT wr_subject, ca_name, wr_10 FROM `".$g5['write_prefix']."4_3` WHERE wr_id =".$edu_id); // 교육과정(학점은행제) 수강신청정보
if($edu['wr_10'] == 'N') {
	alert('폐강된 강좌입니다.');
}

if($edu['wr_10'] == 'F') {
	alert('마감된 강좌입니다.');
}
$document = array('1. 수강신청서','2. 개인정보제공동의서','3. 선이수과목 성적증명서','4. 학적부','5. 신분증 사본'); // 제출서류확인
?>


<section id="bo_w">
    <h2 class="sound_only"><?php echo $g5['title'] ?>장비공유신청</h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="wr_name" value="비회원">
	<input type="hidden" name="wr_password" value="1111">
	<input type="hidden" name="wr_9" value="1">
	<input type="hidden" name="wr_10" value="<?php echo $edu_id ?>">



    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            //$option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
        }
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                //$option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label></li>';
            }
        }
        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret"><span></span>비밀글</label></li>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }
        if ($is_mail) {
            $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail"><span></span>답변메일받기</label></li>';
        }
    }
    echo $option_hidden;
    ?>

	<!--
    <?php if ($is_category) { ?>
    <div class="bo_w_select write_div">
        <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
        <select name="ca_name" id="ca_name" required>
            <option value="">분류를 선택하세요</option>
            <?php echo $category_option ?>
        </select>
    </div>
    <?php } ?>
	-->

    <!--<div class="bo_w_info write_div">
	    <?php if ($is_name) { ?>
	        <label for="wr_name" class="sound_only">이름<strong>필수</strong></label>
	        <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input half_input required" placeholder="이름">
	    <?php } ?>

	    <?php if ($is_password) { ?>
	        <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
	        <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
	    <?php } ?>

	    <?php if ($is_email) { ?>
			<label for="wr_email" class="sound_only">이메일</label>
			<input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input half_input email " placeholder="이메일">
	    <?php } ?>

	    <?php if ($is_homepage) { ?>
	        <label for="wr_homepage" class="sound_only">홈페이지</label>
	        <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input half_input" size="50" placeholder="홈페이지">
	    <?php } ?>
	</div>-->

    <?php if ($option) { ?>
    <!--div class="write_div">
        <span class="sound_only">옵션</span>
        <ul class="bo_v_option">
        <?php echo $option ?>
        </ul>
    </div-->
    <?php } ?>

    <div class="rent_info">
        <h2>수강신청정보</h2>
        <div class="rentlist_tbl01">
            <table>
				<tr>
					<th>수강분류</th>
					<td>
						<input type="hidden" name="wr_1" value="<?php echo $edu['ca_name'] ?>" id="wr_1">
						<span><?php echo $edu['ca_name'] ?></span>
					</td>
				</tr>
                <tr>
					<th>수강명</th>
                    <td>
                        <input type="hidden" name="wr_subject" value="<?php echo $edu['wr_subject'] ?>" id="wr_subject">
                        <span><?php echo $edu['wr_subject'] ?></span>
                    </td>
                <tr>

            </table>
        </div>
    </div>

    <div class="rent_info">
        <h2>신청자정보</h2>
        <div class="rentlist_tbl01">
            <table>
                <tr>
                    <th>성명</th>
                    <td>
                        <label for="wr_2" class="sound_only">이름<strong>필수</strong></label>
                        <input type="text" name="wr_2" value="<?php echo $wr_2 ? $wr_2 : $member['mb_name'] ?>" id="wr_2" required class="frm_input required" placeholder="">
                    </td>
                <tr>
				<tr>
                    <th>생년월일</th>
                    <td>
                        <label for="wr_3" class="sound_only">생년월일<strong>필수</strong></label>
                        <input type="text" name="wr_3" value="<?php echo $wr_3 ?>" id="wr_3" required class="frm_input required number_format margin" maxlength="6">
						<span style="display:inline-block;">예) 1990년1월1일 -> 900101</span>
                    </td>
                <tr>
				<tr>
					<th>주소</th>
					<td>
						<label for="reg_mb_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
						<input type="text" name="wr_zip" value="<?php echo $write['wr_zip'] ?>" id="reg_mb_zip"  class="frm_input twopart_input required" required size="10" maxlength="6" placeholder="우편번호">
						<button type="button" class="btn_frmline" onclick="win_zip('fwrite', 'wr_zip', 'wr_addr1', 'wr_addr2', 'wr_addr3');">주소 검색</button>
						<br><br>
						<label for="reg_mb_addr1" class="sound_only">기본주소<strong> 필수</strong></label>
						<input type="text" name="wr_addr1" value="<?php echo $write['wr_addr1'] ?>" id="reg_mb_addr1" required class="frm_input frm_address full_input required" size="50"  placeholder="기본주소">
						<label for="reg_mb_addr2" class="sound_only">상세주소</label>
						<input type="text" name="wr_addr2" value="<?php echo $write['wr_addr2'] ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
						<label for="reg_mb_addr3" class="sound_only">참고항목</label>
						<input type="text" name="wr_addr3" value="<?php echo $wirte['wr_addr3'] ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
						<!--input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>"-->
					</td>
				</tr>
                <tr>
                    <th>연락처</th>
                    <td>
                        <label for="wr_4" class="sound_only">연락처<strong>필수</strong></label>
                        <input type="text" name="wr_4" value="<?php echo $wr_4 ? $wr_4 : $member['mb_hp'] ?>" id="wr_4" required class="frm_input required number_format" maxlength="11" placeholder="'-' 없이 작성">
                    </td>
                </tr>
				<tr>
                    <th>이메일</th>
                    <td>
                        <label for="wr_5" class="sound_only">이메일</label>
                        <input type="text" name="wr_5" value="<?php echo $wr_5 ? $wr_5 : $member['mb_email'] ?>" id="wr_5" class="frm_input email">
                    </td>
                </tr>
                <tr>
                    <th>선이수과목</th>
                    <td>
						<label for="wr_6" class="sound_only">필수과목<strong>필수</strong></label>
                        <input type="text" name="wr_6" value="<?php echo $wr_6 ?>" id="wr_6" required class="frm_input required margin" placeholder="필수과목">
						<br>
						<label for="wr_7" class="sound_only">선택과목<strong>필수</strong></label>
                        <input type="text" name="wr_7" value="<?php echo $wr_7 ?>" id="wr_7" required class="frm_input required margin" placeholder="선택과목">
                    </td>
                </tr>
                <tr>
                    <th>제출서류확인</th>
                    <td>
						<?php
							$applyTxt = explode('<br>', $write['wr_8']);

							for($i = 0; $i < count($document);  $i++) {
								$is_apply = in_array($document[$i], $applyTxt);
								echo '<div class="margin">';
								echo '<input type="checkbox" name="w_wr_8[]" id="wr_8_'.$i.'" class="chk_box0 required" required value="'.$document[$i].'"'.($is_apply == true ? 'checked' : '').'> ';
								echo '<label for="wr_8_'.$i.'">'.$document[$i].'</label>';
								echo '</div>';
							}
						?>
						<h3>
							※ 체크하신 제출서류를 인터넷 접수 완료 후 3일 이내(우체국 접수소인 기준) 교육원으로 우편발송 하시기 바랍니다.<br>
							(제출서류가 교육원에 도착해야 최종 접수가 완료됩니다.)<br><br>
							※ 문의사항:061-287-3501~3, 469-1503~4
						</h3>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <!--div class="rent_info">
        <h2>개인정보취급방침</h2>
        <textarea class="txtarea"></textarea>
        <div style="text-align:right"><input type="checkbox" name="agree_1" id="agree_1" value="1" styel="zoom:1.3;"><label for="agree_1" class="input_p">약관에 동의합니다.<label></div>
    </div-->

    <!-- div class="bo_w_tit write_div">
        <label for="wr_subject" class="sound_only">내용<strong>필수</strong></label>

        <div id="autosave_wrapper" class="write_div">
            <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input full_input required" size="50" maxlength="255" placeholder="">
            <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
            <?php if($editor_content_js) echo $editor_content_js; ?>
            <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
            <div id="autosave_pop">
                <strong>임시 저장된 글 목록</strong>
                <ul></ul>
                <div><button type="button" class="autosave_close">닫기</button></div>
            </div>
            <?php } ?>
        </div>
    </div -->


    <!-- h2 class="w_title">내용</h2 -->
    <div class="write_div" style="display: none;">
        <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
        <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
            <?php } ?>
            <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_wrap"><span id="char_count"></span>글자</div>
            <?php } ?>
        </div>
    </div>

	<!--
    <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
    <div class="bo_w_link write_div">
        <label for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i><span class="sound_only"> 링크  #<?php echo $i ?></span></label>
        <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
    </div>
    <?php } ?>-->




    <?php if ($is_use_captcha) { //자동등록방지  ?>
    <div class="write_div">
        <?php echo $captcha_html ?>
    </div>
    <?php } ?>

    <div class="btn_confirm write_div">
        <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn">취소</a>
        <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">작성완료</button>
    </div>
    </form>

	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

    <script>
    $(document).ready(function() {

        $(".number_format").on("keyup", function() {
            var number_replace = $(this).val().replace(/[^0-9]/g, "");
            $(this).val(number_replace);
        });

    });

    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {

        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        /*if(f.agree_1.checked == false) {
            alert("약관에 동의해주세요.");
            f.agree_1.focus();
            return false;
        }*/



        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

		/*
		var edu_id = f.wr_10.value;
		var edu_chk = "";

		$.ajax({
			url: g5_bbs_url+"/ajax.edu_check.php",
			type: "POST",
			data: {
				"edu_id": edu_id
			},
			dataType: "json",
			success: function(res) {
					//console.log(res);
				if(res.status == "error") {
					if(res.error == "1") {
						alert('접수기간이 아닙니다');
					} else if(res.error == "2") {
						alert('인원이 꽉찼습니다.');
					} else if(res.error == "3") {
						alert('이미 신청을 하셨습니다');
					} else {
						alert('로그인 후 이용해 주시기 바랍니다.');
					}
					edu_chk = res.error;
				}
			}
		});

		if(edu_chk) {
			//alert("return false 전");
			return false;
			//alert("return false 후");
		}*/

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";



        return true;
    }

    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->
