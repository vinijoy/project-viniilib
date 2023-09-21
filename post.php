<?php
$bo_gbn = $_GET['gbn'];
$sort_style = $_GET['sort'];
    $pg_no = $_GET['page_no'];
    $pg_prev = ((int)$pg_no - 1);
    $pg_next = ((int)$pg_no + 1);
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
$sql_a = "SELECT id,
title,
views_num,
comment_num
FROM board_common where gbn!='qa' and gbn!='vc'";
}else{
$sql_a = "SELECT id,
title,
views_num,
comment_num
FROM board_common where gbn='{$bo_gbn}'";
}
$sql_b = "limit {$a}, {$b}";
$sql_sort = "";

    $sort_style_select = '
<nav>
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="first_date">
            <input type="submit" value="순서대로보기">
          </form>
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="last_date">
            <input type="submit" value="역순으로보기">
          </form>
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="max_views">
            <input type="submit" value="인기순으로보기">
          </form>
          <form action="board.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="max_comment">
            <input type="submit" value="댓글많은순으로보기">
          </form>
</nav>
';

if(empty($sort_style) or $sort_style == 'last_date'){
    $sort_style = 'last_date';
    $sql_sort = "order by pin desc, id desc";
$po_list_no = (int)$po_count - ((int)$pg_no - 1)*10;
$sort_style_exp = "역순으로 표시중";
}elseif($sort_style == 'first_date'){
    $sql_sort = "order by pin desc, id asc";
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
  $po_id = $row['id'];
  $po_title = htmlspecialchars($row['title']);
    $views_no = "조회수 {$row['views_num']}";
$co_no = '';
if($row['comment_num'] > 0){
    $co_no = "댓글 {$row['comment_num']} 개";
}
    $po_list = $po_list."<li><a href=\"post.php?gbn={$bo_gbn}&id={$po_id}&sort={$sort_style}&page_no={$pg_no}\">{$po_list_no}. {$po_title} {$views_no} {$co_no}</a></li>";
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

$search = '
          <form action="search.php" method="get">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<fieldset>
<legend>게시물 검색</legend>
검색 : <select name="catgo" title="검색옵션">
<option value="title" selected>제목</option>
<option value="description">내용</option>
</select>
<p><input type="search" name="stx" placeholder="검색어" maxlength="50" title="검색어를 입력해 주세요" required></p>
            <input type="submit" value="검색">
</fieldset>
          </form>
';

$po = array(
  'title'=>'',
                 'from'=>'',
                 'name'=>'',
                 'username'=>'',
                 'create_dt'=>'',
                 'update_dt'=>'',
                 'views_no'=>'',
                 'co_no'=>'',
                 'media'=>'',
                 'file_name'=>'',
                 'rf_name'=>'',
                 'description'=>''
                 );

$memo_send_link = '';
$po_up_link = '';
$po_del_link = '';
$co_w = '';
$co_c_link = '';
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $po_read_sql = "SELECT * FROM board_common LEFT JOIN member ON board_common.user_id = member.id WHERE board_common.id={$filtered_id}";

  $result = mysqli_query($conn, $po_read_sql);
  $row = mysqli_fetch_array($result);
  $po['title'] = htmlspecialchars($row['title']);
    $po['from'] = 'by';
    $po['name'] = htmlspecialchars($row['name']);
    $po['username'] = htmlspecialchars($row['username']);
    $po['create_dt'] = $row['create_dt'];
    $po['update_dt'] = $row['update_dt'];
    $po['views_no'] = $row['views_num'];
    $po['co_no'] = $row['comment_num'];
    $po['media'] = $row['media'];
    $po['file_name'] = $row['file_name'];
    $po['rf_name'] = $row['rf_name'];
    $po['description'] = nl2br(htmlspecialchars($row['description']));
    $po_create_dt = "등록일: {$po['create_dt']}";
if($po['update_dt'] == True){
    $po_update_dt = "수정일: {$po['update_dt']}";
}
$views_count = "조회수: {$po['views_no']}";
    $co_count = "댓글: {$po['co_no']}";
$co_no_ceil = ceil((int)$po['co_no']);
$dn_link = '';
$file_src = "{$data}{$po['file_name']}";
if(strrpos($po['file_name'],'mp3') || strrpos($po['file_name'],'wav') || strrpos($po['file_name'],'m4a')){
$audio = '<audio controls="controls">
<source src="'.$file_src.'" type="audio/mp3">
<source src="'.$file_src.'" type="audio/wav">
<source src="'.$file_src.'" type="audio/mp4">
</audio>';
}elseif(strrpos($po['file_name'],'html') || strrpos($po['file_name'],'php') || strrpos($po['file_name'],'js') || strrpos($po['file_name'],'txt') || strrpos($po['file_name'],'zip')){
$dn_link = '<p><a href="'.$file_src.'" download="'.$po['rf_name'].'">'.$po['rf_name'].' 다운로드</a></p>';
}
$like_count_sql = "select count(*) from board_like where b_id={$filtered_id} and like_yn='Y'";
$result = mysqli_query($conn, $like_count_sql);
$row = mysqli_fetch_array($result);
$like_count = $row[0];
$like_count_str = "좋아요: {$like_count}";
if($_SESSION['username'] != $po['username']){
$memo_send_link = '<a href="create_memo.php?rurl='.$rurl.'&to='.$po['username'].'">쪽지 보내기</a>';
}
if(($_SESSION['username'] == $po['username']) or ($_SESSION['level'] == 9)){
    $po_up_link = '<a href="update.php?gbn='.$bo_gbn.'&id='.$filtered_id.'&sort='.$sort_style.'&page_no='.$pg_no.'">수정</a>';
  $po_del_link = '
    <form action="process_delete.php" method="post">
      <input type="hidden" name="id" value="'.$filtered_id.'">
    <input type="hidden" name="gbn" value="'.$bo_gbn.'">
      <input type="submit" value="삭제">
    </form>
  ';
}
if(isset($_SESSION['username']) && $_SESSION['username'] != $po['username']){
$views_up_sql = "
UPDATE board_common
set views_num = views_num + 1
where id = {$filtered_id}
";
$result = mysqli_query($conn, $views_up_sql);
}

$co_w = '<h3>댓글쓰기</h3>';
    $co_c_link = '
    <form action="process_create_comment.php" method="POST">
      <input type="hidden" name="id" value="'.$filtered_id.'">
    <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="'.$sort_style.'">
<input type="hidden" name="page_no" value="'.$pg_no.'">
      <p><textarea class="description" name="description" placeholder="내용" required></textarea></p>
<p id="descriptionCounter">입력한 글자수: 0자</p>
      <p><input type="submit" value="등록"></p>
    </form>
    ';

if($po['co_no'] > 0){
    $co_r = '<h3>댓글목록</h3>';
}
    $co_list_sql = "SELECT * FROM comment_common LEFT JOIN member ON comment_common.user_id = member.id WHERE comment_common.post_id={$filtered_id} limit 0, 10";
    $result = mysqli_query($conn, $co_list_sql);
$co_list = '';
    while($row = mysqli_fetch_array($result)) {
$co = array(
                 'id'=>$row['cid'],
'name'=>htmlspecialchars($row['name']),
'username'=>htmlspecialchars($row['username']),
'create_dt'=>$row['create_dt'],
'description'=>nl2br(htmlspecialchars($row['description']))
                 );
$co_up_link = '';
$co_del_link = '';
if(($_SESSION['username'] == $co['username']) or ($_SESSION['level'] == 9)){
        $co_up_link = '<a href="update_comment.php?gbn='.$bo_gbn.'&id='.$filtered_id.'&cid='.$co['id'].'&sort='.$sort_style.'&page_no='.$pg_no.'">수정</a>';
        $co_del_link = '
          <form action="process_delete_comment.php" method="post">
            <input type="hidden" name="id" value="'.$filtered_id.'">
        <input type="hidden" name="cid" value="'.$co['id'].'">
          <input type="hidden" name="gbn" value="'.$bo_gbn.'">
<input type="hidden" name="sort" value="'.$sort_style.'">
<input type="hidden" name="page_no" value="'.$pg_no.'">
            <input type="submit" value="삭제">
          </form>
        ';
}
        $co_list = $co_list."<article><p>{$co['name']}님</p><p>{$co['create_dt']}</p>{$co['description']}<p>{$co_up_link}</p><p>{$co_del_link}</p></article>";
}
}
?>

<script>
   <?php
       echo "var likeCount ='$like_count';";
?>

    function upLike(id) {
        $.ajax({
               type: 'get',
               url: './like.php?id='+id+'&likecount='+likeCount,
               dataType: 'json',
               contentType: 'application/json; utf-8',
               success: function(data){
                var likeHtml = "";
                if(data.length > 0) {
                 for(var i=0;i<data.length;i++){
                    var likeRow = data[i];
                    likeHtml += `좋아요: ${likeRow.like_count}`;
likeCount = likeRow.like_count;
                 }
                }
                $("#like_point").html(likeHtml);
               },
               error: function() {
                document.write("fail");
               }
});
}

    var clickMore = 10;
   <?php
       echo "var gbn ='$bo_gbn';";
       echo "var sort ='$sort_style';";
       echo "var page_no ='$pg_no';";
       echo "var co_no_ceil ='$co_no_ceil';";
   ?>

    function getCommentMore(id) {
        $.ajax({
               type: 'get',
               url: './comment.php?id='+id+'&clickmore='+clickMore,
               dataType: 'json',
               contentType: 'application/json; utf-8',
               success: function(data){
                var commentHtml = "";
                if(data.length > 0) {
                 for(var i=0;i<data.length;i++){
                    var commentRow = data[i];
var coUplink = "";
var coDellink = "";
if(commentRow.sesUsername == commentRow.username || commentRow.sesLevel == 9) {
coUplink += `<a href="update_comment.php?gbn=${gbn}&id=${id}&cid=${commentRow.cid}&sort=${sort}&page_no=${page_no}">수정</a>`;
            coDellink += `<form action="process_delete_comment.php" method="post">
<input type="hidden" name="id" value="${id}">
<input type="hidden" name="cid" value="${commentRow.cid}">
<input type="hidden" name="gbn" value="${gbn}">
<input type="hidden" name="sort" value="${sort}">
<input type="hidden" name="page_no" value="${page_no}">
<input type="submit" value="삭제"></form>`;
}
                    commentHtml += `<article>
<p>${commentRow.name}님</p>
<p>${commentRow.create_dt}</p>
${commentRow.description}
<p>${coUplink}</p>
<p>${coDellink}</p>
</article>`;
                 }
                }
if(clickMore >= co_no_ceil) {
alert('마지막 댓글입니다.');
}
                $("#comment_list").append(commentHtml);
                clickMore += 10;
               },
               error: function() {
                document.write("fail");
               }
               });
    }
</script>

<html>
  <body>
<?php
$title = "{$main} > {$po['title']}";
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
<p><?=$co_count?></p><br/>
<?=$po['media']?>
<?=$audio?>
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
</section><br/>
<?=$dn_link?>
<p><a id="like_point" href="javascript:upLike(<?=$filtered_id?>);"><?=$like_count_str?></a></p>
<p><?=$memo_send_link?></p>
<p><?=$po_up_link?></p>
<?=$po_del_link?>
<section>
<?=$co_w?>
<?=$co_c_link?>
</section>
<section>
<?=$co_r?>
<?=$co_list?>
    <div id="comment_list"></div>
<?php
if($po['co_no'] > 10){
    echo '<a href="javascript:getCommentMore('.$filtered_id.');">더보기</a>';
}
echo '</section>';
echo '</main>';

if(isset($_GET['id'])) {
include ("./inc/middlebanner1.php");
    }
if(($_SESSION['level'] == 9) | ($bo_gbn == 'qa') | ($bo_gbn == 'vc')){
echo '<p><a href="create.php?gbn='.$bo_gbn.'&sort='.$sort_style.'&page_no='.$pg_no.'">글쓰기</a></p>';
}
?>

<?=$search?>
<?=$sort_style_select?>
<h1><?=$po_total_rows?> <?=$pg_current?> <?=$sort_style_exp?></h1>
<ol style="list-style:none;">
      <?=$po_list?>
    </ol>
<?php
if(($_SESSION['level'] == 9) | ($bo_gbn == 'qa') | ($bo_gbn == 'vc')){
echo '<p><a href="create.php?gbn='.$bo_gbn.'&sort='.$sort_style.'&page_no='.$pg_no.'">글쓰기</a></p>';
}
?>
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

<?php include ("./inc/footer.php");
?>
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
