<?php
include ("./inc/var.php");

settype($_POST['id'], 'integer');
$filtered = array(
                  'id'=>mysqli_real_escape_string($conn, $_POST['id'])
);

$sql = "
  DELETE
    FROM board_list
where id = {$filtered['id']}
";
$result = mysqli_query($conn, $sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="manage.php?mgid=bd">확인</a>';
  error_log(mysqli_error($conn));
} else {
  header('Location: manage.php?mgid=bd');
}
?>
