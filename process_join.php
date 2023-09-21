<?php
include ("./inc/var.php");
$url = $_POST['rurl'];
$urld = urldecode($url);
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password_confirm = $_POST['password_confirm'];
  if(!is_null($username)){
    $check_sql = "SELECT name, username
FROM member
WHERE name='{$name}'
";
    $result = mysqli_query($conn, $check_sql);
    while($row = mysqli_fetch_array($result)){
      $name_e = $row['name'];
      $username_e = $row['username'];
    }
    if($name == $name_e){
      $wn = 1;
}elseif($username == $username_e){
      $wu = 1;
    }elseif($password != $password_confirm){
      $wp = 1;
    }else{
      $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
      $join_user_sql = "INSERT INTO member
(name, username, password, login_dt)
VALUES ('{$name}',
'{$username}',
'{$encrypted_password}',
now()
)
";
      $result = mysqli_query($conn, $join_user_sql);

$count_visit_sql = "select count(*) from visit_count
where visit_d='{$today}'
and visit_user='{$username}'";
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
(visit_d, visit_user, visit_count)
VALUES (now(),
'{$username}',
1
)
";
}
      $result = mysqli_query($conn, $visit_up_sql);

$user_info_sql = "select id, level from member
where username='{$username}'";
      $result = mysqli_query($conn, $user_info_sql);
$row = mysqli_fetch_array($result);
$_SESSION['id'] = $row[0];
$_SESSION['name'] = $name;
$_SESSION['username'] = $username;
$_SESSION['level'] = $row[1];
$_SESSION['login_dt'] = $dateTime;
  header('Location:'.$urld);
    }
  }

        if($wn == 1){
          echo '사용 중인 이름입니다. <a href="join.php?rurl='.$url.'">확인</a>';
}
        if($wu == 1){
          echo '사용 중인 아이디입니다. <a href="join.php?rurl='.$url.'">확인</a>';
        }
        if($wp == 1){
          echo '비밀번호가 일치하지 않습니다. <a href="join.php?rurl='.$url.'">확인</a>';
        }
?>
