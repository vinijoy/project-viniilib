<?php
session_start();
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pwd = getenv('MYSQL_PASSWORD');
$db = getenv('MYSQL_DATABASE');
$conn = mysqli_connect($host, $user, $pwd, $db);

$rurl = urlencode($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);

$data = 'uploads/';
             $dateAndTime = date("YmdHis");
$dateTime = date("Y-m-d H:i:s");
$today = date("Y-m-d");

$main = "vini 지식보관소";
if($bo_gbn == vc){
    $main = "방명록";
}elseif($bo_gbn == all){
    $main = "통합게시판";
}elseif($bo_gbn == qa){
    $main = "질문게시판";
}elseif(!empty($bo_gbn)){
$bo_title_sql = "select title from board_list where gbn='{$bo_gbn}'";
$result = mysqli_query($conn, $bo_title_sql);
$row = mysqli_fetch_array($result);
$main = $row[0];
                       }
?>
