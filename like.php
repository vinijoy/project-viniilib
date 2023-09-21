<?php
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control:no-cashe");
header("Pragma:no-cashe");
include ("./inc/var.php");
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  $like_count = $_GET['likecount'];
$user_id = $_SESSION['username'];
$like_point = array();
$my_like_count_sql = "select count(*) from board_like where b_id={$filtered_id} and user_id='{$user_id}' and like_yn='Y'";
$result = mysqli_query($conn, $my_like_count_sql);
$row = mysqli_fetch_array($result);
$my_like_count = $row[0];
$my_dlike_count_sql = "select count(*) from board_like where b_id={$filtered_id} and user_id='{$user_id}' and like_yn='N'";
$result = mysqli_query($conn, $my_dlike_count_sql);
$row = mysqli_fetch_array($result);
$my_dlike_count = $row[0];
if(($my_like_count == 0) && ($my_dlike_count == 0)){
    $po_like_sql = "insert into board_like
(b_id, user_id, like_yn, create_dt)
values ({$filtered_id},
'{$user_id}',
'Y',
now()
)
";
    $result = mysqli_query($conn, $po_like_sql);
        $array_row['like_count'] = ($like_count + 1);
        array_push($like_point, $array_row);
$json_data = json_encode($like_point);
echo urldecode($json_data);
}elseif($my_dlike_count == 1){
    $po_like_sql = "update board_like
set like_yn='Y',
create_dt=now()
where b_id={$filtered_id} and user_id='{$user_id}'
";
    $result = mysqli_query($conn, $po_like_sql);
        $array_row['like_count'] = ($like_count + 1);
        array_push($like_point, $array_row);
$json_data = json_encode($like_point);
echo urldecode($json_data);
}elseif($my_like_count == 1){
    $po_like_sql = "update board_like
set like_yn='N',
create_dt=now()
where b_id={$filtered_id} and user_id='{$user_id}'
";
    $result = mysqli_query($conn, $po_like_sql);
        $array_row['like_count'] = ($like_count - 1);
        array_push($like_point, $array_row);
$json_data = json_encode($like_point);
echo urldecode($json_data);
}
?>
