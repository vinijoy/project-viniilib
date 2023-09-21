<?php
include ("./inc/var.php");

  $current_password = $_POST[ 'current_password' ];
  $new_password = $_POST[ 'new_password' ];
  $new_password_confirm = $_POST[ 'new_password_confirm' ];
  if ( !is_null( $current_password ) ) {
    $password_sql = "SELECT password FROM member WHERE username = '{$_SESSION['username']}';";
    $password_result = mysqli_query( $conn, $password_sql );
    while ( $password_row = mysqli_fetch_array( $password_result ) ) {
      $encrypted_password = $password_row[ 'password' ];
    }
    if ( password_verify ( $current_password, $encrypted_password ) ) {
if ( $new_password == $new_password_confirm ) {
      $encrypted_new_password = password_hash( $new_password, PASSWORD_DEFAULT);
      $password_change_sql = "update member set password='$encrypted_new_password' where username='{$_SESSION['username']}';";
      mysqli_query( $conn, $password_change_sql );
      header( 'Location: /' );
    } else {
$wnp = 1;
}
}else{
$wcp = 1;
    }
}
?>

<html>
  <body>
<?php
$title = "{$main} > 비밀번호 변경";
    include ("./inc/header.php");

echo '<header>';
if(!isset($_SESSION['username'])){
        echo '로그인 상태가 아닙니다. <a href="/">확인</a>';
}else{
?>
<p id="pagestart"><?=$_SESSION['name']?>님 로그인 중</p>
<?php
            include ("./inc/menu_etc.php");
?>
<h1><a href="/">vini 지식보관소</a></h1>
<?php
            include ("./inc/menu.php");
             include ("./inc/menu_program.php");
echo '</header>';
?>
<main>
    <h1>비밀번호 변경</h1>
    <form action="update_password.php" method="POST">
      <p><input type="password" name="current_password" placeholder="현재 비밀번호" required></p>
      <p><input type="password" name="new_password" placeholder="새 비밀번호" required></p>
      <p><input type="password" name="new_password_confirm" placeholder="새 비밀번호 확인" required></p>
      <p><input type="submit" value="비밀번호 변경"></p>
      <?php
        if ( $wcp == 1 ) {
          echo "<p>현재 비밀번호가 틀립니다.</p>";
}
        if ( $wnp == 1 ) {
          echo "<p>새 비밀번호가 일치하지 않습니다.</p>";
        }
      ?>
    </form>
</main>

<?php
}
include "./inc/footer.php";
?>
  </body>
</html>
