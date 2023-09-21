<?php
include ("./inc/var.php");

$confirm = $_POST['confirm'];
if($confirm == 'yes'){
    $post_sql = "update board_common set user_id=6 where user_id = {$_SESSION['id']}";
    $result = mysqli_query( $conn, $post_sql );
    $comment_sql = "update comment_common set user_id=6 where user_id = {$_SESSION['id']}";
    $result = mysqli_query( $conn, $comment_sql );
    $visit_sql = "update visit_count set user='null' where user='{$_SESSION['username']}'";
    $result = mysqli_query( $conn, $visit_sql );
    $user_sql = "delete from member where username = '{$_SESSION['username']}';";
    $result = mysqli_query( $conn, $user_sql );
session_destroy();
header('Location: /');
}elseif($confirm == 'no'){
header('Location: /');
}
?>

<html>
  <body>
<?php
$title = "{$main} > 회원 탈퇴";
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
</header>
<main>
    <h1>회원 탈퇴</h1>
    <form action="secession.php" method="POST">
<p>탈퇴를 원하시면 'yes'를 취소하시려면 'no'를 입력해주세요.</p>
      <p><input type="text" name="confirm" placeholder="yes 또는 no" required></p>
      <p><input type="submit" value="확인"></p>
    </form>
      <?php
}
echo '</main>';

include "./inc/footer.php";
      ?>
  </body>
</html>
