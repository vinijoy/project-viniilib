<?php
include ("./inc/var.php");
$url = $_POST['rurl'];
$urld = urldecode($url);

$filtered = array(
  'api_key'=>mysqli_real_escape_string($conn, $_POST['api_key']),
  'user_id'=>mysqli_real_escape_string($conn, $_SESSION['username'])
);

$back_link = '<a href="'.$urld.'">확인</a>';

$sql = "
  insert into api_key
    (apiKey, createDt, userId)
    VALUES(
        '{$filtered['api_key']}',
        now(),
        '{$filtered['user_id']}')
on duplicate key update
apiKey='{$filtered['api_key']}',
createDt=now()
";

$result = mysqli_query($conn, $sql);
if($result === false){
  echo "저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. {$back_link}";
  error_log(mysqli_error($conn));
} else {
echo "저장되었습니다. {$back_link}";
}
?>
