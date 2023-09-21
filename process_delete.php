<?php
include ("./inc/var.php");
$bo_gbn = $_POST['gbn'];
$uploads_dir = './uploads';
settype($_POST['id'], 'integer');
$filtered = array(
  'id'=>mysqli_real_escape_string($conn, $_POST['id']),
  'file_name'=>''
);

$file_name_sql = "
select
file_name from board_common
where id = {$filtered['id']}
";
$result = mysqli_query($conn, $file_name_sql);
  $row = mysqli_fetch_array($result);
            $filtered['file_name'] = htmlspecialchars($row['file_name']);
if($filtered['file_name'] == True){
  unlink("{$uploads_dir}/{$filtered['file_name']}");
}
$delete_post_sql = "
  DELETE
    FROM board_common
   WHERE id = {$filtered['id']}
   ";
$result = mysqli_query($conn, $delete_post_sql);
$delete_comment_sql = "
  DELETE
    FROM comment_common
   WHERE post_id = {$filtered['id']}
   ";
$result = mysqli_query($conn, $delete_comment_sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="board.php?gbn='.$bo_gbn.'">확인</a>';
  error_log(mysqli_error($conn));
} else {
  header('Location: board.php?gbn='.$bo_gbn.'');
}
?>
