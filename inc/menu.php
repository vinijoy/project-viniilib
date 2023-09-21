<html>
    <body>
    <button id="showandhideboard">게시판 펼치기</button>
<div id="board">
<?php
$po_count_sql = "SELECT COUNT(*) FROM board_common where gbn='vc'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count_vc = $row[0];

$po_count_sql = "SELECT COUNT(*) FROM board_common where gbn!='qa' and gbn!='vc'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count_all = $row[0];

$po_count_sql = "SELECT COUNT(*) FROM board_common where gbn='qa'";
$result = mysqli_query($conn, $po_count_sql);
$row = mysqli_fetch_array($result);
$po_count_qa = $row[0] - 1;

$bo_list_sql = "select board_list.gbn as bg,
board_list.title as bt,
count(board_common.title) as cnt
from board_list
left join board_common
on board_list.gbn=board_common.gbn
group by bg
having bg!='qa' and bg!='vc'
order by category asc, bg asc";
$result = mysqli_query($conn, $bo_list_sql);
$bo_list = '';
while($row = mysqli_fetch_array($result)) {
  $board_gbn = $row['bg'];
  $board_title = htmlspecialchars($row['bt']);
  $po_count = $row['cnt'];
  $bo_list = $bo_list."<li><a href=\"board.php?gbn={$board_gbn}\">{$board_title}({$po_count})</a></li>";
}
?>

<nav>
<ol style="list-style:none;">
<li><a href="/board.php?gbn=vc" target="_self">방명록(<?=$po_count_vc?>)</a></li>
<li><a href="/board.php?gbn=all" target="_self">통합게시판(<?=$po_count_all?>)</a></li>
<li><a href="/board.php?gbn=qa" target="_self">질문게시판(<?=$po_count_qa?>)</a></li>
<?=$bo_list?>
</ol>
</nav>
    </div>
<br/>
    </body>
</html>
