<?php
            include ("./inc/var.php");
?>

<html>
<body>
<?php
$title = "{$main} > 사칙 계산기";
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
window.onload = function() {
document.getElementById('cal').focus();
}

document.addEventListener("keydown", function(event) {
if (event.keyCode == 27) {
setInit();
} else if (event.key == '+') {
setCal('+');
} else if (event.key == '-') {
setCal('-');
} else if (event.key == '*') {
setCal('*');
} else if (event.key == '/') {
setCal('/');
} else if (event.key == '.') {
setCal('.');
} else if (event.keyCode == 13) {
setCal('=');
} else if (event.key == '0') {
setCal('0');
} else if (event.key == '1') {
setCal('1');
} else if (event.key == '2') {
setCal('2');
} else if (event.key == '3') {
setCal('3');
} else if (event.key == '4') {
setCal('4');
} else if (event.key == '5') {
setCal('5');
} else if (event.key == '6') {
setCal('6');
} else if (event.key == '7') {
setCal('7');
} else if (event.key == '8') {
setCal('8');
} else if (event.key == '9') {
setCal('9');
}
});

// 버튼 클릭시 실행
function setCal(inputStr) {
  // 입력창에 0이 있을경우 처리
  if (document.getElementById("cal").value === '0') {
document.getElementById("cal").value = '';
  }
  if (inputStr !== '=') {
    document.getElementById("cal").value += inputStr;
  } else {
if ((document.getElementById("cal").value !== '0') && (document.getElementById("cal").value !== '')) {
let audio = new Audio('./sound/result.wav');
audio.play();
    document.getElementById("cal").value = eval(document.getElementById("cal").value);
  } else {
setInit();
}
}
}

// 계산기 초기화
function setInit() {
  document.getElementById('cal').value = '0';
}
</script>
<main>
<h1>사칙 계산기</h1>
<input type="text" id="cal" readOnly><br/>

<button onClick="setInit();">초기화</button><br/>

<button onClick="setCal('7');">7</button>
<button onClick="setCal('8');">8</button>
<button onClick="setCal('9');">9</button>
<button onClick="setCal('*');">*</button>
<button onClick="setCal('/');">/</button><br/>

<button onClick="setCal('4');">4</button>
<button onClick="setCal('5');">5</button>
<button onClick="setCal('6');">6</button>
<button onClick="setCal('+');">+</button>
<button onClick="setCal('-');">-</button><br/>

<button onClick="setCal('1');">1</button>
<button onClick="setCal('2');">2</button>
<button onClick="setCal('3');">3</button><br/>

<button onClick="setCal('0');">0</button>
<button onClick="setCal('.');">.</button>
<button onClick="setCal('=');">=</button><br/>
</main>
<?php
include ("./inc/footer.php");
}
?>
</body>
</html>