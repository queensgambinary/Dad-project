<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

//table: g5_write_calc
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시판 이름 표시 <div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div> -->
<ul class="btn_top top btn_bo_user"> 
	<li><a href="#bo_vc" class="btn_b03 btn" title="댓글"><i class="fa fa-commenting" aria-hidden="true"></i><span class="sound_only">댓글</span></a></li>
    <?php if ($board['bo_use_sns'] || $scrap_href){ ?>
    <li class="bo_share">
    	<button type="button" class="btn_share_opt btn_b03 btn is_view_btn" title="공유"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="sound_only">공유</span></button>
    	<div id="bo_v_share" class="is_view_btn">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href; ?>" target="_blank" class=" btn_scrap" onclick="win_scrap(this.href); return false;" title="스크랩"><i class="fa fa-thumb-tack" aria-hidden="true"></i><span class="sound_only">스크랩</span></a><?php } ?>
            <?php include_once(G5_SNS_PATH."/view.sns.skin.php"); ?>
        </div>	
    </li>
    <?php } ?>
    <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b03 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</a></li><?php } ?>
	
	<li>
		<button type="button" class="btn_more_opt btn_b03 btn is_view_btn" title="게시판 리스트 옵션"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트 옵션</span></button>
    	<?php ob_start(); ?>
	    <ul class="more_opt is_view_btn">
	    	<?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>"><i class="fa fa-reply" aria-hidden="true"></i> 답변</a></li><?php } ?>
			<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 수정</a></li><?php } ?>
	    	<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;"><i class="fa fa-trash-o" aria-hidden="true"></i> 삭제</a></li><?php } ?>
	    	<?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;"><i class="fa fa-files-o" aria-hidden="true"></i> 복사</a></li><?php } ?>
	    	<?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;"><i class="fa fa-arrows" aria-hidden="true"></i> 이동</a></li><?php } ?>
	    	<?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>">검색</a></li><?php } ?>
	    	<li><a href="<?php echo $list_href ?>" class="btn_list"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li>
		</ul>
		<?php $link_buttons = ob_get_contents(); ob_end_flush(); ?>
	</li>
</ul>
<script>
jQuery(function($){
    // 게시판 보기 버튼 옵션
    $(".btn_more_opt.is_view_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_view_btn").toggle();
    });
    // 게시글 공유
    $(".btn_share_opt").on("click", function(e) {
        e.stopPropagation();
        $("#bo_v_share").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_view_btn').length) {
            $(".more_opt.is_view_btn").hide();
            $("#bo_v_share").hide();
        }
    });
});
</script>
<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h2 id="bo_v_title">
            <?php if ($category_name) { ?>
            <span class="bo_v_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span> 
            <?php } ?>
            <span class="bo_v_tit"><?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?></span>
        </h2>
        <div id="bo_v_info">
	        <h2>페이지 정보</h2>
	        <span class="sound_only">작성자 </span><?php echo $view['name'] ?><span class="ip"><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></span>
	        <span class="sound_only">작성일</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?>
	        <span class="sound_only">조회</span><strong><i class="fa fa-eye" aria-hidden="true"></i> <?php echo number_format($view['wr_hit']) ?></strong>
	        <span class="sound_only">댓글</span><strong><i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo number_format($view['wr_comment']) ?></strong>
	    </div>
    </header>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            foreach($view['file'] as $view_file) {
                echo get_file_thumbnail($view_file);
            }
            echo "</div>\n";
		}
		?>
		<!-- 실제화면 -->
		
		<!-- 실제화면 -->
<!--        <div id="bo_v_con">--><?php ////echo get_view_thumbnail($view['content']); ?><!--</div>-->
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <style>
            .cal_td{padding:5px}
        </style>

        <div id="bo_v_con">
            <div id="bo_view_content">
                <div class="text">
                    <dl>
                        <dt><em>차</em><em>량</em> <em>번</em><em>호</em></dt>
                        <dd><?php echo $view['wr_subject']?></dd>
                    </dl>
                </div>
                <div class="text">
                    <dl>
                        <dt><em>기</em><em>록</em> <em>간</em><em>격</em></dt>
                        <dd><?php echo $view['wr_1']?>분</dd>
                    </dl>
                </div>
                <div class="text name">
                    <dl>
                        <dt><em>상</em> <em>호</em></dt>
                        <dd></dd>
                    </dl>
                </div>
                <div class="space"></div>
                <div class="time">
                    <?php
                    $departure_time = $view['wr_2'].":00";
                    $arrival_time = $view['wr_3'].":00";

                    $year = substr($arrival_time, 0, 4);
                    $month = substr($arrival_time, 5, 2);
                    $day = substr($arrival_time, 8, 2);
                    echo '<div class="date">'.$year."年".$month."月".$day."日".'</div>';

                    $time_intervals = divide_time_interval($departure_time, $arrival_time, $view['wr_1']);

                    // Calculate temperatures for Channel A
                    $channel_a_temperatures = [];
                    foreach ($time_intervals as $time) {
                        $channel_a_temperatures[] = calculate_temperature($view['wr_6'], $view['wr_7'], $arrival_time, $time);
                    }

                    $channel_b_temperatures = [];
                    // Calculate temperatures for Channel B

					//echo "111-->".$view['wr_8'];
					//echo "<BR>"; 
					//echo "222-->".$view['wr_9'];
					//echo "<BR>"; 

                    if ($view['wr_8'] && $view['wr_9']) {
						
						//echo "dfjlkjdlkjfdlkjfd";  
						
                        foreach ($time_intervals as $time) {
                            $channel_b_temperatures[] = calculate_temperature($view['wr_8'], $view['wr_9'], $arrival_time, $time);
                        }
                    }


//					echo "111-->".substr($time_intervals[0],0,4);
//					echo "<BR>";
//					echo "222-->".substr($time_intervals[0],5,2);
//					echo "<BR>";
//					echo "333-->".substr($time_intervals[0],8,2);
//					echo "<BR>"; 

                    echo '<table>';
                    for ($j=0; $j<count($time_intervals); $j++) {


						if($before!="" && $before!=substr($time_intervals[$j],0,10)){
							echo '</table>';
							echo '<table>';
							echo '<BR><div class="date">'.substr($time_intervals[$j],0,4).'年'.substr($time_intervals[$j],5,2).'月'.substr($time_intervals[$j],8,2).'日</div>';
//							echo '<tr>';
//							echo '<td colspan="4">'.substr($time_intervals[$j],0,10).'</td>';
//							echo '</tr>';
						}

                        echo '<tr>';
                        echo '<td class="cal_td">'.substr($time_intervals[$j], 11, 5);

						//echo "<BR>";
						//echo "1111==".str_replace("/","-",$departure_time);
						//echo "<BR>";
						//echo "2222==".$time_intervals[$j]; 
						//echo "<BR>";
						$ma=""; 
                        if (str_replace("/","-",$departure_time) == $time_intervals[$j]) {
                            echo 'P';
							$ma="P";
                        }
                        if (str_replace("/","-",$arrival_time) == $time_intervals[$j]) {
                            echo 'S';
							$ma="S";
                        }
                        echo '</td>'; 

						$plusa="";
						if($channel_a_temperatures[$j] > 0){ 
							$plusa="+";
						}

						$plusb="";
						if($channel_b_temperatures[$j] > 0){
							$plusb="+";
						}
						
						if($ma=="P" || $ma=="S" ){

							if ($channel_b_temperatures) {
								echo '<td class="cal_td" style="margin-right:12px"> A: '.$plusa.number_format($channel_a_temperatures[$j], 1).' </td>';
							}else{
								echo '<td class="cal_td" style="margin-left:20px"> A: '.$plusa.number_format($channel_a_temperatures[$j], 1).' </td>';
							}
						}else{
							if ($channel_b_temperatures) {
								echo '<td class="cal_td" > A: '.$plusa.number_format($channel_a_temperatures[$j], 1).'</td>';
							}else{
								echo '<td class="cal_td" style="margin-left:20px"> A: '.$plusa.number_format($channel_a_temperatures[$j], 1).'</td>';
							}
						}

						//echo "djfkljfl==>";
						//var_dump($channel_b_temperatures); 

                        if ($channel_b_temperatures) {

							//echo "11111111111111";

                            echo '<td class="cal_td"> B: '.$plusb.number_format($channel_b_temperatures[$j],1).'°C</td>';
                        }else{
							//echo "22222222222222";
							echo '<td class="cal_td">                                                             </td>';
						}

                        echo '</tr>';

						if($j==0){ 
							echo '<tr><td class="cal_td"></td><td class="cal_td"></td><td class="cal_td"></td><td class="cal_td"></td></tr>';
						}

						$before=substr($time_intervals[$j],0,10);

                    }
                    echo '</table>';
                    ?>
                    <div class="stop">USER STOP</div>
                </div>
            </div>
        </div>
		
        <div class="btn_wrap" style="display: flex;justify-content: space-between; width: 100%;margin-top:40px;">
            <input type="button" value="뒤로" id="btn_back" style="padding:5px 5px;color:#fff;background-color:blue;width:100px;">
            
<!--                 <span><?php echo '운행시간: '. $view['wr_4']?></span> -->
<!--                 <input type="button" value="파일저장 및 종료" id="btn_save">				 -->
			<a href="/data/board/<?php echo $view['wr_10'];?>" download class="view_file_download2" style="padding:5px 5px;color:#fff;background-color:blue;text-align:center;width:100px;line-height:40px;">저장</a>
            
        </div>
		
		<?php if($view['wr_10']!=""){ ?>
		<div>
			
		</div>
		<?php }?>
		
        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act">

            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good">이 글을 추천하셨습니다</b>
            </span>
            <?php } ?>

            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span class="bo_v_good"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="sound_only">비추천</span> <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
    </section>
    
    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
	?>

    <?php if($cnt) { ?>
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span> |
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>
    <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <i class="fa fa-link" aria-hidden="true"></i>
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <?php if ($prev_href || $next_href) { ?>
    <ul class="bo_v_nb" style="display:none">
        <?php if ($prev_href) { ?><li class="bo_v_prev"><a href="<?php echo $prev_href ?>"><i class="fa fa-chevron-up" aria-hidden="true"></i><span class="sound_only">이전글</span> <?php echo $prev_wr_subject;?></a></li><?php } ?>
        <?php if ($next_href) { ?><li class="bo_v_next"><a href="<?php echo $next_href ?>"><i class="fa fa-chevron-down" aria-hidden="true"></i><span class="sound_only">다음글</span> <?php echo $next_wr_subject;?></a></li><?php } ?>
    </ul>
    <?php } ?>
    
    <?php
    // 코멘트 입출력
    //include_once(G5_BBS_PATH.'/view_comment.php');
	?>
</article>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script>
$(function() {
    //$("#btn_save").on('click', async function(e) {
        var wr_id = "<?php echo $view['wr_id']; ?>";
        $.ajax({
             type: "POST",
             url: "./save_process.php",
             data: {
                 wr_id: wr_id
             },
             success: function(data) {

				var href = "/data/board/"+data;
				$(".view_file_download2").attr("href", href); 
//				$(".view_file_download2").attr('download' , 'TACO.txt');
//                 console.log(data);
//                 if (data === "SUCCESS") {
//                    alert("저장 성공");

					 //location.reload();
//                 } else {
//                     alert("저장 실패");
//					 location.reload();
//                 }
             },
             error: function(xhr, status, error) {
                 console.error("Error:", error);
                 alert("저장 중 오류가 발생했습니다.");
             }
         });


        //html2canvas($("#bo_view_content")[0]).then(function(canvas) {
        //    var imgData = canvas.toDataURL('image/png').replace("data:image/png;base64,", "");
        //    var subject = "<?php //echo $view['wr_subject']; ?>//";
        //
        //    // Ajax를 이용한 서버로의 데이터 전송
        //    $.ajax({
        //        type: "POST",
        //        url: "./save_process.php",
        //        data: {
        //            imgSrc: imgData,
        //            subject: subject
        //        },
        //        success: function(data) {
        //            console.log(data);
        //            if (data === "SUCCESS") {
        //                alert("이미지 저장 성공");
        //            } else {
        //                alert("이미지 저장 실패");
        //            }
        //        },
        //        error: function(xhr, status, error) { 
        //            console.error("Error:", error);
        //            alert("이미지 저장 중 오류가 발생했습니다."); 
        //        }
        //    });
        //}).catch(function(error) {
        //    console.error('html2canvas 에러:', error);
        //    alert('이미지 캡처 중 에러가 발생했습니다.');
        //});

    //});

    $("a.view_image").click(function() { 
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    // $("#bo_v_atc").viewimageresize();

    $("#btn_back").click(function () {
        history.back();
    });

});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>