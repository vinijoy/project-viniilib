<?php
include ("./inc/var.php");
$bo_title = $_POST['title'];
$bo_category = $_POST['category'];
$bo_gbn = $_POST['gbn'];

settype($_POST['id'], 'integer');
$filtered = array(
                  'id'=>mysqli_real_escape_string($conn, $_POST['id'])
);

$board_update_sql = "update board_list
set title='{$bo_title}',
category={$bo_category},
gbn='{$bo_gbn}'
where id = {$filtered['id']}
";
$result = mysqli_query($conn, $board_update_sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="manage.php?mgid=bd">확인</a>';
  error_log(mysqli_error($conn));
}else{
  header('Location: manage.php?mgid=bd');
}
?>
