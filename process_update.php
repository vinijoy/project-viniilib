<?php
include ("./inc/var.php");
$bo_gbn = $_POST['gbn'];
settype($_POST['id'], 'integer');
$filtered = array(
  'id'=>mysqli_real_escape_string($conn, $_POST['id']),
  'title'=>mysqli_real_escape_string($conn, $_POST['title']),
  'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);

$sql = "
  UPDATE board_common
    SET
      title = '{$filtered['title']}',
      description = '{$filtered['description']}',
      update_dt = now()
    WHERE
      id = {$filtered['id']}
";
$result = mysqli_query($conn, $sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="board.php?gbn='.$bo_gbn.'">확인</a>';
  error_log(mysqli_error($conn));
} else {
  header('Location: board.php?gbn='.$bo_gbn.'');
}
?>
