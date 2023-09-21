<?php
include ("./inc/var.php");
$bo_gbn = $_POST['gbn'];
$uploads_dir = './uploads';
$allowed_ext = array('mp3','wav','m4a','html','php','js','txt','zip');
$error = $_FILES['myfile']['error'];
$name = $_FILES['myfile']['name'];
$temp_file_explode = explode('.', $name);
$ext = array_pop($temp_file_explode);
$new_file_name = '';
$filtered = array(
  'title'=>mysqli_real_escape_string($conn, $_POST['title']),
                  'media'=>mysqli_real_escape_string($conn, $_POST['media']),
  'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);

if(!empty($name) && !in_array($ext, $allowed_ext)){
  echo '업로드 가능한 파일이 아닙니다.<br>업로드 가능한 확장자: mp3, wav, m4a, html, php, js, txt, zip';
  exit;
}elseif(in_array($ext, $allowed_ext)){
  $new_file_name = $bo_gbn."_".$dateAndTime.".".$ext;
  move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$new_file_name");
 $sql = "
  INSERT INTO board_common
    (gbn, title, media, file_name, rf_name, description, create_dt, user_id)
    VALUES(
        '{$bo_gbn}',
        '{$filtered['title']}',
        '{$filtered['media']}',
        '{$new_file_name}',
        '{$name}',
        '{$filtered['description']}',
        NOW(),
        {$_SESSION['id']}
    )
";
  $result = mysqli_query($conn, $sql);
}else{
  $sql = "
  INSERT INTO board_common
    (gbn, title, media, file_name, rf_name, description, create_dt, user_id)
    VALUES(
        '{$bo_gbn}',
        '{$filtered['title']}',
        '{$filtered['media']}',
        '{$new_file_name}',
        '{$name}',
        '{$filtered['description']}',
        NOW(),
        {$_SESSION['id']}
    )
";
  $result = mysqli_query($conn, $sql);
}

if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요. <a href="board.php?gbn='.$bo_gbn.'">확인</a>';
  error_log(mysqli_error($conn));
} else {
  header('Location: board.php?gbn='.$bo_gbn.'');
}
?>
