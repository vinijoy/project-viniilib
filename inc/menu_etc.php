<?php
$me_count_sql = "SELECT count(*) FROM memo
WHERE toid={$_SESSION['id']}";
$result = mysqli_query($conn, $me_count_sql);
$row = mysqli_fetch_array($result);
$me_count = $row[0];

?>

<html>
    <body>
    <button id="showandhidemenu">내계정</button>
<div id="menu">
<?php
echo '<nav>';
echo '<ol style="list-style:none;">';
if($_SESSION['username'] == 'vini'){
echo '<li><a href="./manage.php">관리 페이지</a></li>';
}
echo "<li><a href=\"my_info.php\">마이 페이지</a></li>";
echo "<li><a href=\"memo.php?rurl={$rurl}\">받은 쪽지({$me_count})</a></li>";
echo "<li><a href=\"create_memo.php?rurl={$rurl}\">쪽지 보내기</a></li>";
echo "<li><a href=\"logout.php\">로그아웃({$_SESSION['username']})</a></li>";
echo '</ol>';
echo '</nav>';
?>
    </div>
<br/>
    </body>
</html>
