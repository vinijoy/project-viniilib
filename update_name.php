<?php
include ("./inc/var.php");

  $name = $_POST[ 'name' ];
  if ( !is_null( $name ) ) {
    $name_sql = "SELECT name FROM member WHERE name = '$name';";
    $name_result = mysqli_query( $conn, $name_sql );
    while ( $name_row = mysqli_fetch_array( $name_result ) ) {
      $name_e = $name_row[ 'name' ];
    }
    if ( $name == $name_e ) {
      $wn = 1;
}else {
      $name_change_sql = "update member set name='{$name}' where name='{$_SESSION['name']}';";
      mysqli_query( $conn, $name_change_sql );
$new_name_sql = "select name from member where id='{$_SESSION['id']}'";
      $result = mysqli_query( $conn, $new_name_sql );
$row = mysqli_fetch_array($result);
$_SESSION['name'] = $row[0];
      header( 'Location: /' );
    }
  }
?>

<html>
  <body>
<?php
$title = "{$main} > 닉네임 변경";
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
    <h1>이름 / 닉네임 변경</h1>
    <form action="update_name.php" method="POST">
      <p><input type="text" name="name" placeholder="새로운 이름 또는 닉네임" required></p>
      <p><input type="submit" value="이름 / 닉네임 변경"></p>
      <?php
        if ( $wn == 1 ) {
          echo "<p>사용 중인 이름입니다.</p>";
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
