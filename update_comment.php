<?php
$bo_gbn = $_GET['gbn'];
$sort_style = $_GET['sort'];
    $pg_no = $_GET['page_no'];
    $pg_prev = ((int)$pg_no - 1);
    $pg_next = ((int)$pg_no + 1);
$catgo = $_GET['catgo'];
$stx = $_GET['stx'];
include ("./inc/var.php");

if($bo_gbn == all){
$po_count_sql = "SELECT COUNT(*) FROM board_common where gbn!='qa' and gbn!='vc'";
}else{
$po_count_sql = "SELECT COUNT(*) FROM board_common where gbn='{$bo_gbn}'";
}

$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count = $row[0];
$po_total_rows = "총 {$po_count} 건";

if(empty($pg_no)){
    $pg_no = 1;
    $pg_next = 2;
}
$pg_current = "{$pg_no}페이지";
    $a = ((int)$pg_no - 1) * 10;
$b = 10;
if($bo_gbn == all){
$sql_a = "SELECT board_list.title as bt,
board_common.id as pi,
board_common.title as pt,
board_common.views_num,
board_common.comment_num
FROM board_list
left join board_common
on board_list.gbn=board_common.gbn
where board_common.gbn!='qa' and board_common.gbn!='vc'";
}elseif($bo_gbn == vc || $bo_gbn == qa){
$sql_a = "SELECT id as pi,
title as pt,
board_common.views_num,
comment_num
FROM board_common
where gbn='{$bo_gbn}'";
}else{
$sql_a = "SELECT board_list.title as bt,
board_common.id as pi,
board_common.title as pt,
board_common.views_num,
board_common.comment_num
FROM board_list
left join board_common
on board_list.gbn=board_common.gbn
where board_common.gbn='{$bo_gbn}'";
}
$sql_b = "limit {$a}, {$b}";
$sql_sort = "";

if(empty($sort_style) or $sort_style == 'last_date'){
    $sort_style = 'last_date';
    $sql_sort = "order by pin desc, pi desc";
$po_list_no = (int)$po_count - ((int)$pg_no - 1)*10;
$sort_style_exp = "역순으로 표시중";
}elseif($sort_style == 'first_date'){
    $sql_sort = "order by pin desc, pi asc";
$po_list_no = 10 * ((int)$pg_no - 1) + 1;
$sort_style_exp = "순서대로 표시중";
}elseif($sort_style == 'max_views'){
    $sql_sort = "order by pin desc, views_num desc";
$po_list_no = 10 * ((int)$pg_no - 1) + 1;
$sort_style_exp = "인기순으로 표시중";
}elseif($sort_style == 'max_comment'){
    $sql_sort = "order by pin desc, comment_num desc";
$po_list_no = 10 * ((int)$pg_no - 1) + 1;
$sort_style_exp = "댓글많은순으로 표시중";
}
$po_list_sql = "{$sql_a} {$sql_sort} {$sql_b}";

$result = mysqli_query($conn, $po_list_sql);
$po_list = '';
while($row = mysqli_fetch_array($result)) {
  $bo_title = $row['bt'];
  $po_id = $row['pi'];
  $po_title = htmlspecialchars($row['pt']);
    $views_no = "조회수 {$row['views_num']}";
$co_no = '';
if($row['comment_num'] > 0){
    $co_no = "댓글 {$row['comment_num']} 개";
}
if($bo_gbn == vc || $bo_gbn == qa){
  $po_list = $po_list."<li><a href=\"post.php?gbn={$bo_gbn}&id={$po_id}&sort={$sort_style}&page_no={$pg_no}\">{$po_list_no}. {$po_title} {$views_no} {$co_no}</a></li>";
}else{
  $po_list = $po_list."<li><a href=\"post.php?gbn={$bo_gbn}&id={$po_id}&sort={$sort_style}&page_no={$pg_no}\">{$po_list_no}. [{$bo_title}] {$po_title} {$views_no} {$co_no}</a></li>";
}
if($sort_style == 'last_date'){
  $po_list_no = $po_list_no - 1;
}else{
  $po_list_no = $po_list_no + 1;
}
}

    $page_prev_control = '
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="'.$sort_style.'">
<input type="hidden" name="page_no" value="'.$pg_prev.'">
            <input type="submit" value="이전 페이지">
          </form>
';
    $page_next_control = '
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="'.$sort_style.'">
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
         $pg_list = $pg_list."<p><a href=\"board.php?gbn={$bo_gbn}&sort={$sort_style}&page_no={$i}\">{$i}페이지</a></p>";
     }
}

$po = array(
  'title'=>'',
                 'from'=>'',
                 'name'=>'',
                 'create_dt'=>'',
                 'update_dt'=>'',
                 'views_no'=>'',
                 'comment_no'=>'',
                 'media'=>'',
                 'file_name'=>'',
                 'description'=>''
                 );

$co = array(
            'description'=>''
            );

if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $po_read_sql = "SELECT * FROM board_common LEFT JOIN member ON board_common.user_id = member.id WHERE board_common.id={$filtered_id}";

  $result = mysqli_query($conn, $po_read_sql);
  $row = mysqli_fetch_array($result);
  $po['title'] = htmlspecialchars($row['title']);
    $po['from'] = 'by';
    $po['name'] = htmlspecialchars($row['name']);
    $po['create_dt'] = $row['create_dt'];
    $po['update_dt'] = $row['update_dt'];
    $po['views_no'] = $row['views_num'];
    $po['comment_no'] = $row['comment_num'];
    $po['media'] = $row['media'];
    $po['file_name'] = $row['file_name'];
    $po['description'] = nl2br(htmlspecialchars($row['description']));
    $po_create_dt = "등록일: {$po['create_dt']}";
if($po['update_dt'] == True){
    $po_update_dt = "수정일: {$po['update_dt']}";
}
    $views_count = "조회수: {$po['views_no']}";
        $co_count = "댓글: {$po['comment_no']}";
$audio_src = "{$data}{$po['file_name']}";
if($po['file_name'] == True){
$audio = '<p>모바일 브라우저에서는 자동 재생이 지원되지않습니다.</p>';
$audio .= '<audio controls="controls" autoplay="autoplay">
<source src="'.$audio_src.'" type="audio/mp3">
<source src="'.$audio_src.'" type="audio/wav">
<source src="'.$audio_src.'" type="audio/mp4">
</audio>';
}

    $co_read_sql = "SELECT * FROM comment_common WHERE comment_common.cid={$_GET['cid']}";
    $result = mysqli_query($conn, $co_read_sql);
    $row = mysqli_fetch_array($result);
$co['description'] = htmlspecialchars($row['description']);
}
?>

<html>
  <body>
<?php
$title = "{$main} > {$po['title']} > 댓글수정";
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
<section>
<h2><?=$po['title']?></h2>
    <p><?=$po['from']?> <?=$po['name']?></p>
<p><?=$po_create_dt?></p>
<p><?=$po_update_dt?></p>
<p><?=$views_count?></p>
<p><?=$co_count?></p>
<?=$po['media']?>
<?=$po['audio']?>
<article><?=url_auto_link($po['description'], true)?></article>
<?php
function url_auto_link($str = '', $popup = false)
{
    if (empty($str)) {
        return false;
    }
    $target = $popup ? 'target="_blank"' : '';
    $str = str_replace(
        array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"),
        array("\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t", "'"),
        $str
    );
    $str = preg_replace(
        "/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i",
        "\\1<a href=\"\\2\" {$target}>\\2</A>",
        $str
    );
    $str = preg_replace(
        "/(^|[\"'\s(])(www\.[^\"'\s()]+)/i",
        "\\1<a href=\"http://\\2\" {$target}>\\2</A>",
        $str
    );
    $str = preg_replace(
        "/[0-9a-z_-] 
 +@[a-z0-9._-]{4,}/i",
        "<a href=\"mailto:\\0\">\\0</a>",
        $str
    );
    $str = str_replace(
        array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"),
        array("&nbsp;", "&lt;", "&gt;", "&#039;"),
        $str
    );
    return $str;
}
?>
</section>
<section>
<form action="process_update_comment.php" method="POST">
<input type="hidden" name="cid" value="<?=$_GET['cid']?>">
      <input type="hidden" name="id" value="<?=$filtered_id?>">
<input type="hidden" name="gbn" value="<?=$bo_gbn?>">
<input type="hidden" name="sort" value="<?=$sort_style?>">
<input type="hidden" name="page_no" value="<?=$pg_no?>">
<input type="hidden" name="catgo" value="<?=$catgo?>">
<input type="hidden" name="stx" value="<?=$stx?>">
      <p><textarea class="description" name="description" placeholder="내용" required><?=$co['description']?></textarea></p>
<p id="descriptionCounter">입력한 글자수: 0자</p>
<p><input type="submit" value="수정"></p>
    </form>
</section>
</main>

<?php
if(isset($_GET['id'])) {
include ("./inc/middlebanner1.php");
    }
?>

<h1><?=$po_total_rows?> <?=$pg_current?> <?=$sort_style_exp?></h1>
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
echo '<a href="board.php?gbn='.$bo_gbn.'&sort='.$sort_style.'&page_no=1">처음</a>';
}
if($pg_print_stno>1){
 $tmp_print_no = $pg_print_stno-1;
echo "<a href=\"board.php?gbn={$bo_gbn}&sort={$sort_style}&page_no={$tmp_print_no}\">이전</a>";
}
echo $pg_list;
if( $pg_print_edno < $pg_count){
 $tmp_print_no = $pg_print_edno+1;
echo "<a href=\"board.php?gbn={$bo_gbn}&sort={$sort_style}&page_no={$tmp_print_no}\">다음</a>";
}
if($po_count > 10 && $pg_no != $pg_count){
echo '<a href="board.php?gbn='.$bo_gbn.'&sort='.$sort_style.'&page_no='.$pg_count.'">맨끝</a>';
}
?>
</nav>

<?php include ("./inc/footer.php"); ?>
<script>
$('.description').keyup(function (e){
    var content_description = $(this).val();
    $('#descriptionCounter').html("입력한 글자수: "+content_description.length+"자");    //글자수 실시간 카운팅
    if (content_description.length > 500){
        alert("최대 500자까지 입력 가능합니다.");
        $(this).val(content_description.substring(0, 500));
        $('#descriptionCounter').html("입력한 글자수: 500자");
    }
});
</script>
</body>
</html>
