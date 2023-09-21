            <?php
            include ("./inc/var.php");
      if(!isset($_SESSION['username'])){
        echo '로그인 상태가 아닙니다. <a href="/">확인</a>';
      } else {
        session_destroy();
header('Location: /');
      }
?>
