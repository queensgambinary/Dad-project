<?php
include_once('./_common.php');
$imagedata = base64_decode($_POST['imgSrc']);
$file_name = $_POST['subject'].'_'.date("YmdHis").".png";

$file = $_SERVER['DOCUMENT_ROOT'] . "/data/board/" . $file_name;
file_put_contents($file, $imagedata);

echo "SUCCESS";
