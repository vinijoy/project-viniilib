<?php
include ("./inc/var.php");
$url = $_GET['rurl'];
?>

<html>
  <body>
<?php
$title = "{$main} > 로그인";
    include ("./inc/header.php");

echo '<header>';
      if(isset($_SESSION['username'])){
        echo '이미 '.$_SESSION['name'].'님으로 로그인 중입니다. <a href="/">확인</a>';
      } else {
echo '<h1 id="pagestart"><a href="/">vini 지식보관소</a></h1>';
echo '</header>';
?>
<main>
<h1>로그인</h1>
    <form action="process_login.php" method="POST">
<input type="hidden" name="rurl" value="<?=$url?>">
      <p><input type="text" name="username" placeholder="아이디" required></p>
      <p><input type="password" name="password" placeholder="비밀번호" required></p>
      <p><input type="submit" value="로그인"></p>
    </form>
<p><a href="join.php?rurl=<?=$url?>">회원 가입</a></p>
</main>

<?php
include ("./inc/footer.php");
}
?>
  </body>
</html>
