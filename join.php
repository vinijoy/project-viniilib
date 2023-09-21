<?php
include ("./inc/var.php");
$url = $_GET['rurl'];
?>

<html>
  <body>
<?php
$title = "{$main} > 회원 가입";
    include ("./inc/header.php");

echo '<header>';
echo '<h1 id="pagestart"><a href="/">vini 지식보관소</a></h1>';
echo '</header>';
?>
<main>
    <h1>회원 가입</h1>
    <form action="process_join.php" method="POST">
<input type="hidden" name="rurl" value="<?=$url?>">
      <p><input type="text" class="name" name="name" placeholder="닉네임" maxlength="10" required></p>
<p id="nameCounter">(0/10)</p>
      <p><input type="text" class="username" name="username" placeholder="아이디" maxlength="10" required></p>
<p id="usernameCounter">(0/10)</p>
      <p><input type="password" name="password" placeholder="비밀번호" required></p>
      <p><input type="password" name="password_confirm" placeholder="비밀번호 확인" required></p>
      <p><input type="submit" value="회원 가입"></p>
    </form>
</main>

<?php
include "./inc/footer.php";
?>
<script>
$('.name').keyup(function (e){
    var content_name = $(this).val();
    $('#nameCounter').html("("+content_name.length+"/10)");    //글자수 실시간 카운팅
    if (content_name.length > 10){
        alert("최대 10자까지 입력 가능합니다.");
        $(this).val(content_name.substring(0, 10));
        $('#nameCounter').html("(10/10자)");
    }
});
$('.username').keyup(function (e){
    var content_username = $(this).val();
    $('#usernameCounter').html("("+content_username.length+"/10)");    //글자수 실시간 카운팅
    if (content_username.length > 10){
        alert("최대 10자까지 입력 가능합니다.");
        $(this).val(content_username.substring(0, 10));
        $('#usernameCounter').html("(10/10자)");
    }
});
</script>
  </body>
</html>
