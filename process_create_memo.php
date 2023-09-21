<?php
include ("./inc/var.php");
$url = $_POST['rurl'];
$urld = urldecode($url);
$to = $_POST['to'];
$filtered = array(
  'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);

$user_sql = "
select id
from member
where username='{$to}'";
$result = mysqli_query($conn, $user_sql);
$row = mysqli_fetch_array($result);
$check = $row[0];
if(empty($check)){
echo '존재하지 않는 회원입니다. <a href="create_memo.php">확인</a>';
}else{
$sql = "
  INSERT INTO memo
    (description, create_dt, toid, fromid)
    VALUES(
        '{$filtered['description']}',
        NOW(),
        {$check},
        {$_SESSION['id']}
    )
";
$result = mysqli_query($conn, $sql);
$check = 0;
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="create_memo.php">확인</a>';
  error_log(mysqli_error($conn));
} else {
  echo '전송되었습니다. <a href="'.$urld.'">확인</a>';
}
}
?>
