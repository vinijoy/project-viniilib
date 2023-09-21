<?php
            include ("./inc/var.php");
$rurl = urlencode('/');
?>

<script>
    function getDb() {
        $.ajax({
               type: 'get',
               url: './visit.php',
               dataType: 'json',
               contentType: 'application/json; utf-8',
               success: function(data){
                var dbHtml = "";
                if(data.length > 0) {
                 for(var i=0;i<data.length;i++){
                    var dbRow = data[i];
                    dbHtml += '누적 방문: '+dbRow.avisitor+'<br/>';
                    dbHtml += '오늘 방문: '+dbRow.tvisitor+'<br/><br/>';
                 }
                }
            var avisitor = document.getElementById("avisitor");
            var tvisitor = document.getElementById("tvisitor");
                avisitor.innerHTML = dbRow.avisitor;
                tvisitor.innerHTML = dbRow.tvisitor;
            setTimeout("getDb()", 5000);
               },
               error: function() {
                document.write("fail");
               }
               });
    }
window.onload = getDb;
</script>

<html>
    <body>
            <?php
$title = $main;
            include ("./inc/header.php");

echo '<header>';
if(!isset($_SESSION['username'])){
echo '<h1 id="pagestart"><a href="/">vini 지식보관소</a></h1>';
echo '<p><a href="login.php?rurl='.$rurl.'">로그인/회원가입</a></p>';
}else{
echo "<p id=\"pagestart\">{$_SESSION['name']}님 로그인 중</p>";
            include ("./inc/menu_etc.php");
echo '<h1><a href="/">vini 지식보관소</a></h1>';
?>
<audio autoplay="autoplay">
<source src="sound/up.mp3" type="audio/mp3" />
<source src="sound/up.ogg" type="audio/ogg" />
</audio>
<?php
}
             include ("./inc/menu.php");
             include ("./inc/menu_program.php");
?>
<div>
<p>Since 2022-08-31</p>
<p>누적 방문: <span id="avisitor"></span></p>
<p>오늘 방문: <span id="tvisitor"></span></p>
</div><br/>
<?php
echo '</header>';
echo '<main>';
echo '<article>';
             echo "이 사이트는 유용한 정보의 기록 및 공유를 목적으로 제작되었습니다.<br>";
             echo "전맹의 입장에서 제작하였으며, 따라서 그래픽적인 부분에 있어서 퀄리티의 결여 및 미흡함이 있을 수 있음을 미리 알려드립니다.<br>";
             echo "모쪼록 이 사이트가 여러분들에게 도움이 되기를 바랍니다.<br>";
             echo "질문이나 기타 문의사항이 있으신 경우 페이지 하단의 수단으로 연락 부탁드립니다.<br/>";
echo '</article>';
echo '</main>';
include ("./inc/footer.php");
?>
         </body>
</html>
