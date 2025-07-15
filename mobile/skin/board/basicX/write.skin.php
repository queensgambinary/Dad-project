<?php
//echo "it works";
//exit; 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

//echo "ddd==>".date('Y/m/d');
//echo "ddd==".date('A h:i');

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
    #container_title{display:none !important;}
    #bo_w{background:#fff;min-height:100vh;border-radius:10px;border:1px solid #172fff;padding-top:20px;}
    .form_01{display:flex;flex-direction:column;}
    .bo_w_space{height:25px;}
    .bo_w_tit{display:flex;align-items:center;}
    .bo_w_tit .lt{display:flex;align-items:center;gap:6px;min-width:20%;font-size:13px;}
    .bo_w_tit .rt{display:flex;align-items:center;gap:6px;flex:1;width:200px;}
    .bo_w_tit .rt em{width:25px;flex:0 0 auto;text-align:center;align-items:center;justify-content:center;font-style:normal;}
    .bo_w_tit .rt label{padding:0;white-space:nowrap;margin:0 auto;}
    .bo_w_tit label{padding:0 20px;font-size:13px;}
    .bo_w_tit label button{white-space:nowrap;display:flex;background:#53a9ff;border:1px solid #172fff;border-radius:8px;padding:4px 8px;}
    .bo_w_tit input{width:60%;height:36px;background:transparent;border:1px dashed #fc1cfb;font-size:15px;background-image:none !important;}
    .bo_w_tit input.bd-blue{border:1px solid #172fff;}
    .bo_w_tit .checkbox{font-size:13px;display:flex;gap:6px;align-items:center;}
    .bo_w_tit .checkbox input{}
    .bo_w_tit.type1{justify-content:center;}
    .bo_w_tit.type1 .lt{width:auto;}
    .bo_w_tit.type1 .rt{width:auto;flex:unset;}
    .bo_w_tit.type1 label{width:auto;padding:0 20px;min-width:100px;}
    .bo_w_tit.type1 input{width:100px!important;}
    .btn_confirm{margin:40px 0 0 0 !important;}
    .btn_cancel{background: #53a9ff !important;border: 1px solid #172fff !important;color:#000000 !important;border-radius:10px !important;}
    .btn_submit{background: #53a9ff !important;border: 1px solid #172fff !important;color:#000000 !important;border-radius:10px !important;}
    .tac{text-align:center;}
</style>
<section id="bo_w">
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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

	<input type="hidden" name="wr_name" value="<?php echo time();?>">



    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) { 
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
        }
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label></li>';
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
	
    <div class="form_01 write_div">
        <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

        <?php if ($is_category) { ?>
        <div class="bo_w_select write_div">
            <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
            <select id="ca_name" name="ca_name" required>
                <option value="">선택하세요</option>
                <?php echo $category_option ?>
            </select>
        </div>
        <?php } ?>         

        <?php
        $prev = sql_fetch("select * from {$write_table} order by wr_id desc limit 1 ");
        ?>
        <div class="bo_w_tit write_div type1">
            <div class="lt">
                <label for="wr_subject">차량번호<strong class="sound_only">필수</strong></label>
            </div>
            <div class="rt">
                <input type="text" pattern="\d*" maxlength="4" name="wr_subject" value="<?php echo $prev['wr_subject'] ?>" id="wr_subject" required class="frm_input full_input required" >
                <em></em>
            </div>
        </div>
		<div class="bo_w_tit write_div type1">
            <div class="lt">
                <label for="wr_1" >기록간격<strong class="sound_only">필수</strong></label>
            </div>
            <div class="rt">
                <input type="text" name="wr_1" value="<?php echo $prev['wr_1'] ?>" id="wr_1" required class="frm_input full_input required" >
                <em>분</em>
            </div>
        </div>
        <div class="bo_w_space"></div>
		<div class="bo_w_tit write_div">
            <div class="lt">
                <label for="wr_2">출발<strong class="sound_only">필수</strong></label>
            </div>
            <div class="rt">
				<input type="hidden" id="wr_2" name="wr_2">
				<?php $wr2=explode(" ",$prev['wr_2']);?>
                <input type="text" name="wr_21" id="wr_21" value="<?php echo date('Y/m/d');?>" required class="from-datepicker frm_input full_input required tac">
				<input type="time" name="wr_22" id="wr_22" required value="<?php echo date('A g:i');?>" class="frm_input full_input required tac">
            </div>
        </div>

		<div class="bo_w_tit write_div">
            <div class="lt">
                <label for="wr_3" >도착<strong class="sound_only">필수</strong></label>
            </div>
            <div class="rt">
				<input type="hidden" id="wr_3" name="wr_3">
				<?php $wr3=explode(" ",$prev['wr_3']);?>
                <input type="text" name="wr_31" id="wr_31" required value="<?php echo date('Y/m/d');?>" class="from-datepicker frm_input full_input required tac" >
				<input type="time" name="wr_32" id="wr_32" required value="<?php echo date('A g:i');?>" class="frm_input full_input required tac" >
            </div>
        </div>	
		
		<div class="bo_w_tit write_div">
            <div class="lt">
                <label for="wr_4" ><button type="button" onclick="calculate_driving_time()" >운행시간 확인</button><strong class="sound_only">필수</strong></label>
            </div>
            <div class="rt">
                <input type="text" name="wr_4" value="<?php //echo $prev['wr_4']; ?>" id="wr_4" required class="frm_input full_input required">
            </div>
        </div>

        <div class="bo_w_space"></div>
		<div class="bo_w_tit write_div" >
			<?php //echo "wr_5==>".$prev['wr_5'];?>
            <div class="lt">채널선택</div>
            <div class="rt">
                <label class="checkbox" ><input type="radio" name="wr_5" <?php if($prev['wr_5']=="A"){ echo "checked";}?> onclick="toggleChannelInput('A')"  value="A"  id="wr_51" required class="frm_input required">A채널</label>
                <label class="checkbox" ><input type="radio" name="wr_5" <?php if($prev['wr_5']=="AB"){ echo "checked";}?> onclick="toggleChannelInput('AB')" value="AB" id="wr_52" required class="frm_input required">A,B채널</label>
            </div>
        </div>

		<div class="bo_w_tit write_div" id="a_channel">
			<div class="lt">A채널온도</div>
            <div class="rt">
                <input type="text" name="wr_6" value="<?php echo $prev['wr_6'] ?>" id="wr_6" required class="frm_input full_input required bd-blue">
                ~
                <input type="text" name="wr_7" value="<?php echo $prev['wr_7'] ?>" id="wr_7" required class="frm_input full_input required bd-blue">
                °C
            </div>
        </div>

		<?php //if($prev['wr_5']=="AB" || $prev['wr_5']==""){ 
			//echo "1234==>".$prev['wr_5'];
		?>
		<div class="bo_w_tit write_div" id="b_channel" <?php echo $prev['wr_5']=="A" ? 'style="display:none!important"':'';?> >
            <div class="lt">B채널온도</div>
            <div class="rt">
                <input type="text" name="wr_8"  value="<?php echo $prev['wr_8'] ?>" id="wr_8" class="frm_input full_input bd-blue">
                ~
                <input type="text" name="wr_9"  value="<?php echo $prev['wr_9'] ?>" id="wr_9" class="frm_input full_input bd-blue">
                °C
            </div>
        </div>
		<?php //} ?>
		
		<input type="hidden" id="wr_content" name="wr_content" value="clac">

<!--         <div class="write_div"> -->
<!--             <label for="wr_content" class="sound_only">내용<strong>필수</strong></label> -->
<!--             <?php if($write_min || $write_max) { ?> -->
<!--             <!-- 최소/최대 글자 수 사용 시 --> -->
<!--             <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p> -->
<!--             <?php } ?> -->
<!--             <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?> -->
<!--             <?php if($write_min || $write_max) { ?> -->
<!--             <!-- 최소/최대 글자 수 사용 시 --> -->
<!--             <div id="char_count_wrap"><span id="char_count"></span>글자</div> -->
<!--             <?php } ?> -->
<!--         </div> -->
    </div>

<!--     <div class="btn_confirm"> -->
<!--         <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel">저장없이 끝내기</a> -->
<!-- 	</div> -->

	<div style="text-align:center;margin-top:10px;">
        <button type="submit" id="btn_submit" class="btn_submit" accesskey="s">결과 확인하기</button>
    </div>
    </form>
</section>

<script>

$("#from-datepicker, .from-datepicker").datepicker({
    dateFormat: 'yy/mm/dd',
});
// $('#wr_22, #wr_32').timepicker({
//     datepicker: false,
//     timeFormat: 'p hh:mm',
//     ampm: true
// });
// $('#wr_22').timepicker({
//     timeFormat: 'p hh:mm',
// });
$(document).ready(function() {


    $('#wr_6, #wr_7, #wr_8, #wr_9').on("change keyup", function () {
        var value = $(this).val();
        console.log('Input value:', value);
        if (value.length > 5) {
            $(this).val(value.substring(0, 5));
        }
    });




//    $("#wr_2,#wr_3").datetimepicker({
//		format: 'Y/m/d A g:i',
//        formatTime: 'A g:i',
//        step: 1 // 1분 간격으로 시간 선택
//    });
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

function calculate_driving_time() {

    var start = $("#wr_21").val() +" " + $("#wr_22").val();
    var end   = $("#wr_31").val() +" " + $("#wr_32").val(); //document.getElementById("wr_3").value;

	console.log(start);
	console.log(end);

	

    var startDate = convertTo24HourFormat(start);
    var endDate = convertTo24HourFormat(end);

	console.log(startDate);
	console.log(endDate);

	//return false; 

    var diff_hour = (endDate - startDate) / (1000 * 60 * 60);
    var hours = Math.floor(diff_hour);
    var minutes = Math.floor((diff_hour - hours) * 60);

    if (hours < 0) {
        alert('도착이 출발보다 빠를 수 없습니다.');
        return false;
    }

    document.getElementById("wr_4").value = hours + "시간 " + minutes + "분";
}

function convertTo24HourFormat(dateTime) {

    var [date, time] = dateTime.split(' ');

	console.log( date ); 
	console.log( time ); 

    var [year, month, day] = date.split('/').map(Number);

	console.log( time ); 
    var [hours, minutes] = time.split(':').map(Number);

//    if (type === 'PM' && hours !== 12) {
//        hours += 12;
//    } else if (type === 'AM' && hours === 12) {
//        hours = 0;
//    }

    return new Date(year, month - 1, day, hours, minutes);
}

function toggleChannelInput(channel) {
    if (channel === 'A') {
        document.getElementById('a_channel').style.display = 'flex';
        document.getElementById('b_channel').style.display = 'none';
    } else if (channel === 'AB') {
        document.getElementById('a_channel').style.display = 'flex';
        document.getElementById('b_channel').style.display = 'flex';
    }
}


// 초기 상태 설정 (AB 채널 선택됨)
window.onload = function() {
    //toggleChannelInput('AB');
};

function fwrite_submit(f)
{
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
	
	$("#wr_2").val( $("#wr_21").val()+" "+$("#wr_22").val() );
	$("#wr_3").val( $("#wr_31").val()+" "+$("#wr_32").val() );

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

    //wr_subject 숫자 네자리 유효성 검사
    if (f.wr_subject.value.length != 4) {
        alert('차량번호는 4자리로 입력해주세요.');
        f.wr_subject.focus();
        return false;
    }

    //wr_1 숫자 2자리 유효성 검사
    if (f.wr_1.value.length > 2) {
        alert('기록간격은 2자리로 입력해주세요.');
        f.wr_1.focus();
        return false;
    }


//    if (document.getElementById("wr_2").value > document.getElementById("wr_3").value) {
//        alert('도착이 출발보다 빠를 수 없습니다.');
//        return false;
//    }

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

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

var uploadFile = $('.filebox .uploadBtn');
uploadFile.on('change', function(){
	if(window.FileReader){
		var filename = $(this)[0].files[0].name;
	} else {
		var filename = $(this).val().split('/').pop().split('\\').pop();
	}
	$(this).siblings('.fileName').val(filename);
});
</script>
