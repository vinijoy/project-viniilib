<?php
$url = $_GET['rurl'];
    $pg_no = $_GET['page_no'];
    $pg_prev = ((int)$pg_no - 1);
    $pg_next = ((int)$pg_no + 1);
include ("./inc/var.php");

$me_count_sql = "SELECT COUNT(*) FROM memo where toid={$_SESSION['id']}";
$result = mysqli_query($conn, $me_count_sql);
$row = mysqli_fetch_array($result);
$me_count = $row[0];

if(empty($pg_no)){
    $pg_no = 1;
    $pg_next = 2;
}
$pg_current = "{$pg_no}페이지";
    $a = ((int)$pg_no - 1) * 10;
$b = 10;
$sql_a = "SELECT * FROM memo
LEFT JOIN member ON memo.fromid = member.id
WHERE memo.toid={$_SESSION['id']}";
$sql_b = "limit {$a}, {$b}";
$sql_sort = "";

    $sort_style = 'last_date';
    $sql_sort = "order by no desc";
$me_list_sql = "{$sql_a} {$sql_sort} {$sql_b}";

$result = mysqli_query($conn, $me_list_sql);
$me_list = '';
while($row = mysqli_fetch_array($result)) {
$no = $row['no'];
$toid = $row['toid'];
$fromid = htmlspecialchars($row['username']);
$fromname = htmlspecialchars($row['name']);
$create_dt = $row['create_dt'];
$description = htmlspecialchars($row['description']);
$repl_link = '<p><a href="create_memo.php?rurl='.$url.'&to='.$fromid.'">답장</a></p>';
        $del_link = '
          <form action="process_delete_memo.php" method="post">
      <input type="hidden" name="rurl" value="'.$url.'">
        <input type="hidden" name="id" value="'.$no.'">
            <input type="submit" value="삭제">
          </form>
        ';
  $me_list = $me_list."<p>보낸 사람: {$fromid}({$fromname})</p><p>보낸 날짜: {$create_dt}</p><p>{$description}</p>{$repl_link}{$del_link}";
}

    $page_prev_control = '
          <form action="memo.php" method="get">
          <input type="hidden" name="rurl" value="'.$url.'">
<input type="hidden" name="page_no" value="'.$pg_prev.'">
            <input type="submit" value="이전 페이지">
          </form>
';
    $page_next_control = '
          <form action="memo.php" method="get">
          <input type="hidden" name="rurl" value="'.$url.'">
<input type="hidden" name="page_no" value="'.$pg_next.'">
            <input type="submit" value="다음 페이지">
          </form>
';

$pg_list = '';
$pg_count = ceil(((int)$me_count / $b));
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
         $pg_list = $pg_list."<p><a href=\"memo.php?rurl={$url}&page_no={$i}\">{$i}페이지</a></p>";
     }
}
?>

<html>
  <body>
<?php
$title = $main;
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
<h1><?=$pg_current?></h1>
      <?=$me_list?>
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
echo '<a href="memo.php?rurl='.$url.'&page_no=1">처음</a>';
}
if($pg_print_stno>1){
 $tmp_print_no = $pg_print_stno-1;
echo "<a href=\"memo.php?rurl={$url}&page_no={$tmp_print_no}\">이전</a>";
}
echo $pg_list;
if( $pg_print_edno < $pg_count){
 $tmp_print_no = $pg_print_edno+1;
echo "<a href=\"memo.php?rurl={$url}&page_no={$tmp_print_no}\">다음</a>";
}
if($me_count > 10 && $pg_no != $pg_count){
echo '<a href="memo.php?rurl='.$url.'&page_no='.$pg_count.'">맨끝</a>';
}
?>
</nav>
</main>

<?php include ("./inc/footer.php"); ?>
</body>
</html>
