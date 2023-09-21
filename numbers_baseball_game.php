<?php
            include ("./inc/var.php");
$user = $_SESSION['name'];
?>

<html>
<body>
<?php
$title = "{$main} > 숫자 야구 게임";
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
       echo "var gamePlayer ='$user';";
?>

// 히든넘버 전역변수
var hiddenNumber = ['', '', '', ''];
var tryCnt = 1;

// 게임시작
function gameStart() {
let audioStart = new Audio('./sound/start.wav');
audioStart.play();
  // 4자리 임의의 숫자 생성(중복제거)
  getRandomNumberDuplicationCheck();
  document.getElementById('hiddenNumber').value = hiddenNumber.join('');  
  
  // 기존에 진행한 게임이 있으면 지워준다. 횟수도 초기화.
  document.getElementById('playerArea').innerHTML = '';
  tryCnt = 1;
  
  // 플레이어가 입력할 창과 확인 버튼, 결과보여줄 영역 생성
  createPlayerInput();

}

// 임의의 4자리수 생성(중복제거)
function getRandomNumberDuplicationCheck() {
  let rangeNumber = '0123456789';

  for (let i=0;i<hiddenNumber.length;i++) {
    let rangeNumberIndex = Math.floor(Math.random() * (rangeNumber.length));
    let randomNumber = rangeNumber.charAt(rangeNumberIndex);
    hiddenNumber[i] = randomNumber;
    rangeNumber = rangeNumber.replace(randomNumber, '');
  }
}

// 플레이어가 입력할 창과 확인버튼, 결과보여줄영역 생성
function createPlayerInput() {
  let str = "";
  str += "<input type='text' id='playerInput"+tryCnt+"'>";
  str += "<button onClick='openResult("+tryCnt+");' id='rtnBtn"+tryCnt+"'>결과확인</button>";
  str += "<span id='result"+tryCnt+"'></span><br/>";
  
  let playerDiv = document.createElement("div");
  playerDiv.setAttribute("id", "playerDiv"+tryCnt);
  document.getElementById('playerArea').insertAdjacentElement("beforeend", playerDiv);
  
  document.getElementById("playerDiv"+tryCnt).innerHTML = str;
  document.getElementById("playerInput"+tryCnt).focus();
  tryCnt++;
}

// 결과확인 버튼
function openResult(pTryCnt) {
  let str = "";
  let playerInput = document.getElementById("playerInput"+pTryCnt).value;
  // 자리수 체크
  if (playerInput.length !== 4) {
    alert("입력은 4자리로 해주세요.");
    document.getElementById("playerInput"+pTryCnt).focus();
    return;
  }
  // 숫자인지 체크
  if (isNaN(playerInput)) {
    alert("숫자만 입력 가능합니다.");
    document.getElementById("playerInput"+pTryCnt).focus();
    return;
  }
  // 중복숫자가 있는지 체크
  let duplicationCnt = 0;
  for (let i=0;i<playerInput.length;i++) {
    for (let k=0;k<playerInput.length;k++) {
      if (i != k && playerInput.charAt(i) === playerInput.charAt(k)) {
        duplicationCnt++;
      }
    }
  }
  if (duplicationCnt > 0) {
    alert("입력하신 숫자에 중복이 있습니다.중복숫자를 제거해주세요.");
    document.getElementById("playerInput"+pTryCnt).focus();
    return;
  }
  
  // 결과를 확인하면 입력창과 버튼을 읽기전용 및 사용불가로 변경
  document.getElementById("playerInput"+pTryCnt).readOnly=true;
  document.getElementById("rtnBtn"+pTryCnt).disabled=true;
  
  // 플레이어가 입력한 숫자와 히든숫자를 비교하여 결과를 보여준다.
  let resultStr = resultCheck(playerInput);
  document.getElementById("result"+pTryCnt).innerHTML = resultStr;
  if (resultStr === 'HR') {
let audioHR = new Audio('./sound/hr.wav');
audioHR.play();
  document.getElementById("result"+pTryCnt).innerHTML += "<br/>홈런을 축하합니다. "+gamePlayer+"님은 "+pTryCnt+"회만에 맞추었습니다.";
  } else if(resultStr === 'OUT') {
let audioOUT = new Audio('./sound/out.wav');
audioOUT.play();
    createPlayerInput();
} else {
    // 홈런이 아닌경우 새 입력창을 만든다.
    createPlayerInput();
  }
}

// 플레이어가 입력한 숫자와 히든숫자를 비교하여 결과를 리턴한다.
function resultCheck(playerInput) {
  let resultStr = "";
  let sCnt = 0;
  let bCnt = 0;
  
  // 히든숫자 만큼 반복
  for (let i=0;i<hiddenNumber.length;i++) {
    // 입력한 숫자길이 만큼 반복
    for (let k=0;k<playerInput.length;k++) {
      if (Number(hiddenNumber[i]) === Number(playerInput.charAt(k))) {
        if (i === k) {
          sCnt++;
        } else {
          bCnt++;
        }
      }
    }
  }
  
  if (sCnt === 4) {
    resultStr = "HR";
  } else if (sCnt === 0 && bCnt === 0) {
    resultStr = "OUT";
  } else {
    resultStr = sCnt+"S "+bCnt+"B";
  }
  
  return resultStr;
}
</script>
<main>
<h1>숫자 야구 게임</h1>
<button onClick="gameStart();">게임시작</button><br/>
<input type="hidden" id="hiddenNumber"><br/>
<div id="playerArea"></div>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>