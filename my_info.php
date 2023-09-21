<?php
include "./inc/var.php";
?>

<html>
<body>
<?php
$title = "{$main} > {$_SESSION['name']}님의 페이지";
include "./inc/header.php";

echo '<header>';
if(!isset($_SESSION['username'])){
header ('Location: login.php?rurl='.$rurl);
}else{
echo "<p id=\"pagestart\">{$_SESSION['name']}님 로그인 중</p>";
            include ("./inc/menu_etc.php");
echo "<h1><a href=\"/\">vini 지식보관소</a></h1>";
             include ("./inc/menu.php");
             include ("./inc/menu_program.php");
echo '</header>';
echo '<main>';
echo "<h1>내 정보</h1>";
echo "<p>아이디: {$_SESSION['username']}</p>";
echo "<p>닉네임: {$_SESSION['name']}</p>";
echo "<p>최근 접속일: {$_SESSION['last_login_dt']}</p>";
echo "<p>이번 접속일: {$_SESSION['login_dt']}</p>";
$po_count_sql = "SELECT COUNT(*) FROM board_common left join member on board_common.user_id=member.id where username='{$_SESSION['username']}'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count = $row[0];
    echo "<p>내가 쓴 게시물: {$po_count} 건</p>";
if($_SESSION['level'] == 0){
$po_count_sql = "select count(*) from board_like where user_id='{$_SESSION['username']}' and like_yn='Y'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count = $row[0];
echo "<p><a href=\"favorites.php\">좋아요 누른 게시물({$po_count})</a></p>";
echo "<p><a href=\"update_name.php\">닉네임 변경</a></p>";
echo "<p><a href=\"update_password.php\">비밀번호 변경</a></p>";
echo "<p><a href=\"secession.php\">회원 탈퇴</a></p>";
}
}
echo '</main>';

include ("./inc/footer.php");
?>
</body>
</html>
