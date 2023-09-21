<?php
$url = $_GET['rurl'];
$to = $_GET['to'];
include ("./inc/var.php");
?>

<html>
  <body>
<?php
$title = "{$main} > 쪽지 보내기";
include ("./inc/header.php");

echo '<header>';
if(!isset($_SESSION['username'])){
header ('Location: login.php?rurl='.$rurl);
}else{
echo "<p id=\"pagestart\">{$_SESSION['name']}님 로그인 중</p>";
            include ("./inc/menu_etc.php");
echo '<h1><a href="/">vini 지식보관소</a></h1>';
include ("./inc/menu.php");
             include ("./inc/menu_program.php");
}
echo '</header>';
?>
<main>
    <form action="process_create_memo.php" method="POST">
      <input type="hidden" name="rurl" value="<?=$url?>">
      <p><input type="text" name="to" placeholder="받는사람" value="<?=$to?>" required></p>
      <p><input type="text" class="description" name="description" placeholder="내용" maxlength="50" required></p>
<p id="descriptionCounter">(0/50)</p>
      <p><input type="submit" value="전송"></p>
    </form>
</main>

<?php include ("./inc/footer.php"); ?>
<script>
$('.description').keyup(function (e){
    var content_description = $(this).val();
    $('#descriptionCounter').html("("+content_description.length+"/50)");    //글자수 실시간 카운팅
    if (content_description.length > 50){
        alert("최대 50자까지 입력 가능합니다.");
        $(this).val(content_description.substring(0, 50));
        $('#descriptionCounter').html("(50/50자)");
    }
});
</script>
</body>
</html>
