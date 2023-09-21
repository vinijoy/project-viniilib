<?php
include "./inc/var.php";

$bo = array(
  'title'=>'',
  'category'=>'',
                 'gbn'=>''
                 );

if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  $bo_read_sql = "SELECT * FROM board_list WHERE id={$filtered_id}";

  $result = mysqli_query($conn, $bo_read_sql);
  $row = mysqli_fetch_array($result);
  $bo['title'] = htmlspecialchars($row['title']);
  $bo['category'] = $row['category'];
  $bo['gbn'] = htmlspecialchars($row['gbn']);
}
?>

<html>
<body>
<?php
$title = "{$main} > 관리 페이지";
include "./inc/header.php";

echo '<header>';
if(!isset($_SESSION['username'])){
header ('Location: login.php?rurl='.$rurl);
}elseif($_SESSION['level'] == 9){
?>
<p id="pagestart"><?=$_SESSION['name']?>님 로그인 중</p>
<?php
            include ("./inc/menu_etc.php");
echo '<h1><a href="/">vini 지식보관소</a></h1>';
             include ("./inc/menu.php");
             include ("./inc/menu_program.php");
echo '</header>';
echo '<main>';
echo '<p><a href="manage.php?mgid=bd">게시판 관리</a></p>';
echo '<p><a href="manage.php?mgid=ps">게시물 관리</a></p>';
echo '<p><a href="manage.php?mgid=mb">회원 관리</a></p><br/>';
?>

    <form action="process_update_board.php" method="POST">
      <input type="hidden" name="id" value="<?=$filtered_id?>">
      <p><input type="text" class="title" name="title" placeholder="게시판명" value="<?=$bo['title']?>" maxlength="20" required></p>
<p id="titleCounter">0/20</p>
      <p><input type="text" class="category" name="category" placeholder="게시판카테고리" value="<?=$bo['category']?>" required></p>
      <p><input type="text" class="gbn" name="gbn" placeholder="게시판식별자" value="<?=$bo['gbn']?>" maxlength="3" required></p>
<p id="gbnCounter">0/3</p>
<p><input type="submit" value="게시판수정"></p>
    </form>
</main>

<?php
include ("./inc/footer.php");
}else{
echo '접근 권한이 없습니다. <a href="/">확인</a>';
}
?>

<script>
$('.title').keyup(function (e){
    var content_t = $(this).val();
    $('#titleCounter').html("("+content_t.length+"/20)");    //글자수 실시간 카운팅
    if (content_t.length > 20){
        alert("최대 20자까지 입력 가능합니다.");
        $(this).val(content_t.substring(0, 20));
        $('#titleCounter').html("(20/20자)");
    }
});
$('.gbn').keyup(function (e){
    var content_g = $(this).val();
    $('#gbnCounter').html("("+content_g.length+"/3)");    //글자수 실시간 카운팅
    if (content_g.length > 3){
        alert("최대 3자까지 입력 가능합니다.");
        $(this).val(content_g.substring(0, 3));
        $('#gbnCounter').html("(3/3자)");
    }
});
</script>
</body>
</html>
