<?php
include_once('./_common.php');

$wr_id = $_POST['wr_id'];
$view = sql_fetch("select * from g5_write_calc where wr_id = '$wr_id'");

$filecontents = "        차량번호 : " . $view['wr_subject'] . "\n";
$filecontents .= "        기록간격 : " . $view['wr_1'] . "분\n";
$filecontents .= "\n";
$filecontents .= "        상       호 :\n";  
$filecontents .= "\n";

$departure_time = $view['wr_2'].":00";
$arrival_time = $view['wr_3'].":00";

//시작
$year = substr($arrival_time, 0, 4);
$month = substr($arrival_time, 5, 2);
$day = substr($arrival_time, 8, 2);

$filecontents .= "      " . $year . "年" . $month . "月" . $day . "日\n";

$time_intervals = divide_time_interval($departure_time, $arrival_time, $view['wr_1']);

// Calculate temperatures for Channel A
$channel_a_temperatures = [];
foreach ($time_intervals as $time) {
    $channel_a_temperatures[] = calculate_temperature($view['wr_6'], $view['wr_7'], $arrival_time, $time);
}

$channel_b_temperatures = []; 
// Calculate temperatures for Channel B
if ($view['wr_8'] && $view['wr_9']) {
    foreach ($time_intervals as $time) {
        $channel_b_temperatures[] = calculate_temperature($view['wr_8'], $view['wr_9'], $arrival_time, $time);
    }
}

for ($j=0; $j<count($time_intervals); $j++) {
    $time_string = substr($time_intervals[$j], 11, 5);

    //if ($departure_time == $time_intervals[$j]) {
    //    $time_string .= 'P';
    //}
    //if ($arrival_time == $time_intervals[$j]) {
    //    $time_string .= 'S';
    //}

	if($before!="" && $before!=substr($time_intervals[$j],0,10)){
//
//		echo '';
//		echo '';
		$filecontents .= " \n";
		$filecontents .= "      " .substr($time_intervals[$j],0,4).'年'.substr($time_intervals[$j],5,2).'月'.substr($time_intervals[$j],8,2).'日';
		$filecontents .= " \n";
	}


	$ma="";
	if (str_replace("/","-",$departure_time) == $time_intervals[$j]) {
		$time_string .= 'P';
		$ma="P";
	}
	if (str_replace("/","-",$arrival_time) == $time_intervals[$j]) {
		$time_string .= 'S';
		$ma="S";
	}

	$plusa="";
	if($channel_a_temperatures[$j] > 0){
		$plusa="+";
	}
	
	$plusb="";
	if($channel_b_temperatures[$j] > 0){
		$plusb="+";
	}

	//$filecontents .="<div>";
	if($ma=="P" || $ma=="S" ){ 

		//$filecontents .="<div>";
		if ($channel_b_temperatures) {
			
			$filecontents .= "        ".$time_string."  A:" .$plusa. number_format($channel_a_temperatures[$j], 1) . " ";
		
		}else{
		
			$filecontents .= "        \t\t\t\t\t\t\t\t\t".$time_string."  A:" .$plusa. number_format($channel_a_temperatures[$j], 1) . " °C";
		
		}
		
	}else{ 
		
		if ($channel_b_temperatures) { 

			$filecontents .= "        ".$time_string."    A:" .$plusa.number_format($channel_a_temperatures[$j], 1) . "  ";

		}else{

			$filecontents .= "        \t\t\t\t\t\t\t\t\t".$time_string."    A:" .$plusa.number_format($channel_a_temperatures[$j], 1) . "  °C";

		}
		
	}
	//$filecontents .="</div>";
	//$filecontents .="<div>";

    if ($channel_b_temperatures) {		
		$filecontents .= " B:" .$plusb.number_format($channel_b_temperatures[$j], 1) . " °C";
    }else{
		$filecontents .= "                                                                 ";
	}
	//$filecontents .="</div>";

   if ( $j == 0 ) {
		$filecontents .= " \n";
	}        

    $filecontents .= "\n"; 

	$before=substr($time_intervals[$j],0,10);

}


$filecontents .= "      USER STOP\n";
//$filecontents .=  "      운행시간: " . $view['wr_4'] . "\n"; 

$file_name = date("Ymd").".txt";//$view['wr_subject'].'_'.date("Ymd").".txt"; 
$file = $_SERVER['DOCUMENT_ROOT'] . "/data/board/" . $file_name;

file_put_contents($file, $filecontents);

sql_fetch("update g5_write_calc set wr_10='".$file_name."' where wr_id = '$wr_id'");

echo $file_name;

