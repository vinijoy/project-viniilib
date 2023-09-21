<?php
include ("./inc/var.php");
$bo_gbn = $_POST['gbn'];
$po_id = $_POST['id'];
$sort_style = $_POST['sort'];
$pg_no = $_POST['page_no'];
$catgo = $_POST['catgo'];
$stx = $_POST['stx'];
if(isset($_POST['stx'])){
$back_link_error = '<a href="search_post.php?gbn='.$bo_gbn.'&id='.$po_id.'&sort='.$sort_style.'&page_no='.$pg_no.'&catgo='.$catgo.'&stx='.$stx.'">확인</a>';
$back_link_ok = header('Location: search_post.php?gbn='.$bo_gbn.'&id='.$po_id.'&sort='.$sort_style.'&page_no='.$pg_no.'&catgo='.$catgo.'&stx='.$stx.'');
}else{
$back_link_error = '<a href="post.php?gbn='.$bo_gbn.'&id='.$po_id.'&sort='.$sort_style.'&page_no='.$pg_no.'">확인</a>';
$back_link_ok = header('Location: post.php?gbn='.$bo_gbn.'&id='.$po_id.'&sort='.$sort_style.'&page_no='.$pg_no.'');
}
settype($_POST['cid'], 'integer');
$filtered = array(
                  'id'=>mysqli_real_escape_string($conn, $_POST['cid'])
);

$sql = "
  DELETE
    FROM comment_common
where cid = {$filtered['id']}
";
$result = mysqli_query($conn, $sql);
if($result === false){
  echo "저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. {$back_link_error}";
  error_log(mysqli_error($conn));
} else {
$back_link_ok;
}
?>
