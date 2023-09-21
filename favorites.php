<?php
$bo_gbn = $_GET['gbn'];
$sort_style = $_GET['sort'];
    $pg_no = $_GET['page_no'];
    $pg_prev = ((int)$pg_no - 1);
    $pg_next = ((int)$pg_no + 1);
include ("./inc/var.php");

$po_count_sql = "select count(*) from board_like where user_id='{$_SESSION['username']}' and like_yn='Y'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count = $row[0];
$po_total_rows = "총 {$po_count} 건";

if(empty($pg_no)){
    $pg_no = 1;
    $pg_next = 2;
}
$pg_current = "{$pg_no}페이지 표시 중";
    $a = ((int)$pg_no - 1) * 10;
$b = 10;
$sql_a = "select * from board_common join board_like on board_common.id=board_like.b_id where board_like.user_id='{$_SESSION['username']}' and board_like.like_yn='Y'";
$sql_b = "limit {$a}, {$b}";
$sql_sort = "";

if(empty($sort_style) or $sort_style == 'last_date'){
    $sort_style = 'last_date';
    $sql_sort = "order by id desc";
$po_list_no = (int)$po_count - ((int)$pg_no - 1)*10;
$sort_style_exp = "역순으로 표시중";
}
$po_list_sql = "{$sql_a} {$sql_sort} {$sql_b}";

$result = mysqli_query($conn, $po_list_sql);
$po_list = '';
while($row = mysqli_fetch_array($result)) {
  $po_title = htmlspecialchars($row['title']);
    $views_no = "조회수 {$row['views_num']}";
$co_no = '';
if($row['comment_num'] > 0){
    $co_no = "댓글 {$row['comment_num']} 개";
}
  $po_list = $po_list."<li><a href=\"post.php?gbn={$bo_gbn}&id={$row['id']}&sort={$sort_style}&page_no={$pg_no}\">{$po_list_no}. {$po_title} {$views_no} {$co_no}</a></li>";
if($sort_style == 'last_date'){
  $po_list_no = $po_list_no - 1;
}else{
  $po_list_no = $po_list_no + 1;
}
}

    $page_prev_control = '
          <form action="favorites.php" method="get">
<input type="hidden" name="page_no" value="'.$pg_prev.'">
            <input type="submit" value="이전 페이지">
          </form>
';
    $page_next_control = '
          <form action="favorites.php" method="get">
<input type="hidden" name="page_no" value="'.$pg_next.'">
            <input type="submit" value="다음 페이지">
          </form>
';

$pg_list = '';
$pg_count = ceil(((int)$po_count / $b));
$pg_list_no = 1;
$pg_print_stno = ((int)((int)$pg_no/5)*5)+1;
if( (int)($pg_no%5) == 0 ){
 $pg_print_stno = ((int)((int)$pg_no/5)*5)-4;
}
$pg_print_edno = $pg_print_stno + 5;
if($pg_print_edno > $pg_count){
 $pg_print_edno = $pg_count;
}

for($i = $pg_print_stno;$i<=$pg_print_edno;$i++){
     if((int)$i == $pg_no){
         $pg_list = $pg_list."<p>열림</p><strong>$i</strong><p>페이지</p>";
     }else{
         $pg_list = $pg_list."<p><a href=\"favorites.php?page_no={$i}\">{$i}페이지</a></p>";
     }
}
?>

<html>
  <body>
<?php
$title = "{$main} > 좋아요 누른 게시물";
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
echo '</header>';
?>
<main>
<h1><?=$po_total_rows?> <?=$pg_current?></h1>
<ol style="list-style:none;">
      <?=$po_list?>
    </ol>
<nav>
<?php
if($pg_no == 1 && $pg_count > 1){
echo $page_next_control;
}
if($pg_count > 1 && $pg_no == $pg_count){
echo $page_prev_control;
}
if($pg_no > 1 && $pg_no != $pg_count){
echo $page_prev_control;
echo $page_next_control;
}
?>
</nav>

<nav>
<?php
if($pg_no != 1){
echo '<a href="favorites.php?page_no=1">처음</a>';
}
if($pg_print_stno>1){
 $tmp_print_no = $pg_print_stno-1;
echo "<a href=\"favorites.php?page_no={$tmp_print_no}\">이전</a>";
}
echo $pg_list;
if( $pg_print_edno < $pg_count){
 $tmp_print_no = $pg_print_edno+1;
echo "<a href=\"favorites.php?page_no={$tmp_print_no}\">다음</a>";
}
if($po_count > 10 && $pg_no != $pg_count){
echo '<a href="favorites.php?page_no='.$pg_count.'">맨끝</a>';
}
?>
</nav>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>
