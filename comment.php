<?php
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control:no-cashe");
header("Pragma:no-cashe");
include ("./inc/var.php");
$filtered_id = "";
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
}
    $co_list_sql = "SELECT * FROM comment_common LEFT JOIN member ON comment_common.user_id = member.id WHERE comment_common.post_id={$filtered_id} limit {$_GET['clickmore']}, 10";
    $result = mysqli_query($conn, $co_list_sql);
$co_list = array();
    while($row = mysqli_fetch_array($result)) {
        $array_row['cid'] = $row['cid'];
        $array_row['name'] = htmlspecialchars($row['name']);
        $array_row['username'] = htmlspecialchars($row['username']);
        $array_row['sesLevel'] = htmlspecialchars($_SESSION['level']);
        $array_row['create_dt'] = $row['create_dt'];
        $array_row['description'] = nl2br(htmlspecialchars($row['description']));
        array_push($co_list, $array_row);
}
$json_data = json_encode($co_list);
echo urldecode($json_data);
?>
