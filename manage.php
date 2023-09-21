<?php
include "./inc/var.php";
$mgid = $_GET['mgid'];

$up = '
<form action="process_create_board.php" method="POST">
      <p><input type="text" class="title" name="title" placeholder="추가할게시판명" maxlength="20" required></p>
<p id="titleCounter">(0/20)</p>
      <p><input type="text" class="category" name="category" placeholder="추가할게시판카테고리" required></p>
      <p><input type="text" class="gbn" name="gbn" placeholder="추가할게시판식별자" maxlength="3" required></p>
<p id="gbnCounter">(0/3)</p>
<p><input type="submit" value="게시판추가"></p>
    </form>
';

$board_count_sql = "SELECT COUNT(*) FROM board_list";
$result = mysqli_query($conn, $board_count_sql);
$row = mysqli_fetch_array($result);
$board_count = $row[0] + 3;
$board_total_rows = "게시판수: {$board_count} 개";

$board_list_sql = "SELECT * FROM board_list order by category asc, gbn asc";
$result = mysqli_query($conn, $board_list_sql);
$board_list = '';
while($row = mysqli_fetch_array($result)){
$id = $row['id'];
$category = $row['category'];
$gbn = $row['gbn'];
$title = $row['title'];
        $up_link = '<a href="update_board.php?id='.$id.'">수정</a>';
        $del_link = '
          <form action="process_delete_board.php" method="post">
        <input type="hidden" name="id" value="'.$id.'">
            <input type="submit" value="삭제">
          </form>
        ';
$board_list = $board_list."<tr><td>{$title}</td><td>{$category}</td><td>{$gbn}</td><td>{$up_link}</td><td>{$del_link}</td></tr>";
}

$post_count_sql = "SELECT COUNT(*) FROM board_common where gbn!='qa'";
$result = mysqli_query($conn, $post_count_sql);
$row = mysqli_fetch_array($result);
$post_count = $row[0];
$post_total_rows = "총 게시물 수: {$post_count} 건";

$views_count_sql = "SELECT sum(views_num) FROM board_common where gbn!='qa'";
$result = mysqli_query($conn, $views_count_sql);
$row = mysqli_fetch_array($result);
$views_count = $row[0];
$views_total_rows = "총 조회수: {$views_count} 회";
$views_ever_rows = round(($views_count / $post_count), 2);

$comment_count_sql = "SELECT sum(comment_num) FROM board_common where gbn!='qa'";
$result = mysqli_query($conn, $comment_count_sql);
$row = mysqli_fetch_array($result);
$comment_count = $row[0];
$comment_total_rows = "총 댓글수: {$comment_count} 건";
$comment_ever_rows = round(($comment_count / $post_count), 2);

$like_count_sql = "SELECT count(*) FROM board_like where like_yn='Y'";
$result = mysqli_query($conn, $like_count_sql);
$row = mysqli_fetch_array($result);
$like_count = $row[0];
$like_total_rows = "총 좋아요수: {$like_count} 건";
$like_ever_rows = round(($like_count / $post_count), 2);
$like_pro_rows = round(($like_count / $views_count * 100), 2);

$user_count_sql = "SELECT COUNT(*) FROM member where level=0 and username!='unknown'";
$result = mysqli_query($conn, $user_count_sql);
$row = mysqli_fetch_array($result);
$user_count = $row[0];
$user_total_rows = "회원 수: {$user_count} 명";

$user_list_sql = "SELECT * FROM member where level=0 and username!='unknown'";
$result = mysqli_query($conn, $user_list_sql);
$user_list = '';
while($row = mysqli_fetch_array($result)){
$name = $row['name'];
$username = $row['username'];
$last_login_dt = $row['login_dt'];
$user_list = $user_list."<tr><td>{$name}</td><td>{$username}</td><td>{$last_login_dt}</td></tr>";
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
if($mgid==bd){
?>
<h1>게시판 추가</h1>
<?=$up?><br/>

<h1>게시판 정보</h1>
<p><?=$board_total_rows?></p>
<table>
<thead>
<tr>
<th>게시판명</th>
<th>게시판카테고리</th>
<th>게시판식별자</th>
<th>수정</th>
<th>삭제</th>
</tr>
</thead>
<tbody>
<tr>
<td>방명록</td>
<td></td>
<td>vc</td>
<td></td>
<td></td>
</tr>
<tr>
<td>통합게시판</td>
<td></td>
<td>all</td>
<td></td>
<td></td>
</tr>
<tr>
<td>질문게시판</td>
<td></td>
<td>qa</td>
<td></td>
<td></td>
</tr>
<?=$board_list?>
</tbody>
</table>
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
<?php
}elseif($mgid==ps){
?>
<h1>게시물 정보</h1>
<p><?=$post_total_rows?></p>
<p><?=$views_total_rows?></p>
<p>게시물당 평균 조회수: <?=$views_ever_rows?> 회</p>
<p><?=$comment_total_rows?></p>
<p>게시물당 평균 댓글수: <?=$comment_ever_rows?> 건</p>
<p><?=$like_total_rows?></p>
<p>게시물당 평균 좋아요수: <?=$like_ever_rows?> 건(총 조회수 대비 <?=$like_pro_rows?>%)</p>
<?php
}elseif($mgid==mb){
?>
<h1>회원 정보</h1>
<p><?=$user_total_rows?></p>
<table>
<thead>
<tr>
<th>닉네임</th>
<th>아이디</th>
<th>최근 접속일</th>
</tr>
</thead>
<tbody>
<?=$user_list?>
</tbody>
</table>
<?php
}
echo '</main>';
include ("./inc/footer.php");
}else{
echo '접근 권한이 없습니다. <a href="/">확인</a>';
}
?>
</body>
</html>
