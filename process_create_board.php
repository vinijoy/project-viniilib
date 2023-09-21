<?php
include ("./inc/var.php");
$bo_title = $_POST['title'];
$bo_category = $_POST['category'];
$bo_gbn = $_POST['gbn'];

$board_create_sql = "insert into board_list
(title, category, gbn)
values ('{$bo_title}', {$bo_category}, '{$bo_gbn}')";
$result = mysqli_query($conn, $board_create_sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="manage.php?mgid=bd">확인</a>';
  error_log(mysqli_error($conn));
}else{
  header('Location: manage.php?mgid=bd');
}
?>
