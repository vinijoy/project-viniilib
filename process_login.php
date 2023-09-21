<?php
include ("./inc/var.php");
$url = $_POST['rurl'];
$urld = urldecode($url);
  $username = $_POST[ 'username' ];
  $password = $_POST[ 'password' ];
  if ( !is_null( $username ) ) {
    $jb_sql = "SELECT password FROM member WHERE username = '" . $username . "';";
    $jb_result = mysqli_query( $conn, $jb_sql );
    while ( $jb_row = mysqli_fetch_array( $jb_result ) ) {
      $encrypted_password = $jb_row[ 'password' ];
    }
    if ( is_null( $encrypted_password ) ) {
      $wu = 1;
    } else {
      if ( password_verify( $password, $encrypted_password ) ) {
$sql = "
select id, name, level, login_dt from member
where username='{$username}'
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$_SESSION['id'] = $row[0];
$_SESSION['name'] = $row[1];
        $_SESSION['username'] = $username;
$_SESSION['level'] = $row[2];
$_SESSION['last_login_dt'] = $row[3];
$_SESSION['login_dt'] = $dateTime;

$count_visit_sql = "select count(*) from visit_count
where visit_d='{$today}' and visit_user='{$username}'";
      $result = mysqli_query($conn, $count_visit_sql);
$row = mysqli_fetch_array($result);
$today_check = $row[0];

if($today_check == 1){
      $visit_up_sql = "update visit_count
set visit_count=visit_count + 1
where visit_d='{$today}'
and visit_user='{$username}'
";
}else{
      $visit_up_sql = "INSERT INTO visit_count
(visit_d, visit_user, visit_level, visit_count)
VALUES (now(),
'{$username}',
{$_SESSION['level']},
1
)
";
}
      $result = mysqli_query($conn, $visit_up_sql);

$update_login_dt_sql = "
update member set login_dt=now()
where username='{$username}'
";
$result = mysqli_query($conn, $update_login_dt_sql);
  header('Location:'.$urld);
      } else {
        $wp = 1;
      }
    }
  }

        if ( $wu == 1 ) {
          echo '사용자이름이 존재하지 않습니다. <a href="login.php?rurl='.$url.'">확인</a>';
        }
        if ( $wp == 1 ) {
          echo '비밀번호가 틀렸습니다. <a href="login.php?rurl='.$url.'">확인</a>';
        }
?>
