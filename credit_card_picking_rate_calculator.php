<?php
            include ("./inc/var.php");
$user = $_SESSION['name'];
?>

<html>
<body>
<?php
$title = "{$main} > 신용카드 피킹률 계산기";
include "./inc/header.php";

echo '<header>';
if(!isset($_SESSION['username'])){
header ('Location: login.php?rurl='.$rurl);
}else{
?>
<p id="pagestart"><?=$_SESSION['name']?>님 로그인 중</p>
<?php
            include ("./inc/menu_etc.php");
echo '<h1><a href="/">vini 지식보관소</a></h1>';
             include ("./inc/menu.php");
             include ("./inc/menu_program.php");
echo '</header>';
?>
<script>
   <?php
       echo "var user ='$user';";
?>
window.onload = function() {
document.getElementById("cc").focus();
}

function moveNext(next) {
if (event.keyCode == 13) {
document.getElementById(next).focus();
}
}

function calculStart() {
var cc = document.getElementById('cc').value;
var cn = document.getElementById('cn').value;
var cf = document.getElementById('cf').value;
cf /= 12;
var cb = document.getElementById('cb').value;
cbc = cb - cf;
var cu = document.getElementById('cu').value;
if (cc == '') {
alert('카드사에 값이 입력되지 않았습니다.');
document.getElementById("cc").focus();
} else if (cn == '') {
alert('카드명에 값이 입력되지 않았습니다.');
document.getElementById("cn").focus();
} else if (cf == '') {
alert('카드 연회비에 값이 입력되지 않았습니다.');
document.getElementById("cf").focus();
} else if (isNaN(cf)) {
alert('카드 연회비에는 숫자만 입력 가능합니다.');
document.getElementById("cf").focus();
} else if (cb == '') {
alert('월 평균 혜택에 값이 입력되지 않았습니다.');
document.getElementById("cb").focus();
} else if (isNaN(cb)) {
alert('월 평균 혜택에는 숫자만 입력 가능합니다.');
document.getElementById("cb").focus();
} else if (cu == '') {
alert('월 평균 카드 사용량에 값이 입력되지 않았습니다.');
document.getElementById("cu").focus();
} else if (isNaN(cu)) {
alert('월 평균 카드 사용량에는 숫자만 입력 가능합니다.');
document.getElementById("cu").focus();
} else {
let audio = new Audio('./sound/result.wav');
audio.play();
let cp = cbc / cu * 100;
document.getElementById("cc").readOnly=true;
document.getElementById("cn").readOnly=true;
document.getElementById("cf").readOnly=true;
document.getElementById("cb").readOnly=true;
document.getElementById("cu").readOnly=true;

document.getElementById('resultArea').innerHTML = user+"님의 "+cc+"("+cn+")의 피킹률은<br/>"+cp+"% 입니다.<br/>";
if (cp >= 5) {
document.getElementById('resultArea').innerHTML += "카드와 사용자는 천생연분! 소비 패턴에 꼭 맞는 최적의 카드입니다.<br/>";
} else if (cp >= 3) {
document.getElementById('resultArea').innerHTML += "현재 라이프 스타일에 맞는 효율적인 카드입니다.<br/>";
} else if (cp >= 1) {
document.getElementById('resultArea').innerHTML += "그럭저럭 나쁘지 않지만 자주 쓰는 혜택과 전월 실적 제한 등 장단점을 다시 꼼꼼히 확인한 후 유지 또는 해지하는 것이 좋습니다.<br/>";
} else {
document.getElementById('resultArea').innerHTML += "사실상 현재 누리고 있는 혜택이 전무한 카드이므로 해지 고려를 권고드립니다.<br/>";
}
}
}

function calculInit() {
document.getElementById("cc").value = '';
document.getElementById("cn").value = '';
document.getElementById("cf").value = '';
document.getElementById("cb").value = '';
document.getElementById("cu").value = '';
document.getElementById("resultArea").innerHTML = '';
document.getElementById("cc").focus();
}
</script>
<main>
<h1>신용카드 피킹률 계산기</h1>
<input type="text" id="cc" placeholder="카드사?" onkeydown=moveNext("cn")><br/>
<input type="text" id="cn" placeholder="카드명?" onkeydown=moveNext("cf")><br/>
<input type="text" id="cf" placeholder="카드 연회비?" onkeydown=moveNext("cb")><br/>
<input type="text" id="cb" placeholder="월 평균 혜택?" onkeydown=moveNext("cu")><br/>
<input type="text" id="cu" placeholder="월 평균 카드 사용량?" onkeydown=moveNext("start")><br/>
<button id="start" onClick="calculStart();">계산시작</button><br/><br/>
<div id="resultArea"></div>
<button onClick="calculInit();">초기화</button><br/><br/>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>