<?php
            include ("./inc/var.php");

$list_create_dt = '';
$list = array(
  'api_key'=>'',
                 'create_dt'=>''
                 );

    $api_key_read_sql = "SELECT * FROM api_key WHERE userId='{$_SESSION['username']}'";

  $result = mysqli_query($conn, $api_key_read_sql);
  $row = mysqli_fetch_array($result);
  $list['api_key'] = htmlspecialchars($row['apiKey']);
    $list['create_dt'] = $row['createDt'];
if(isset($list['create_dt'])){
$list_create_dt = "<p>{$list['create_dt']}에 저장된 api key를 사용합니다.</p>";
}
?>

    <script>
let audioResult = new Audio('/sound/result.wav');

      function search() {
        const api_key =
          document.getElementById('api_key').value
        const script = document.getElementById('script').value
        const language = document.getElementById('language').value
if (api_key.length == 51 && script.length > 0 && language.length > 0){
            let resultDiv = document.getElementById('result')
resultDiv.innerHTML = '잠시만 기다려주세요.'
        const messages = [
          { role: 'system', content: '당신은 모든 질문에 답할 수 있습니다. 당신의 이름은 language master입니다. 당신은 세계 최고의 언어학자입니다.' },
          { role: 'user', content: script+'를 '+language+'로 번역해줘.' }
        ]
        const config = {
          headers: {
            Authorization: `Bearer ${api_key}`,
            'Content-Type': 'application/json',
          },
        }
        const data = {
          model: 'gpt-4',
          temperature: 0.5,
          n: 1,
          messages: messages,
        }
        axios
          .post('https://api.openai.com/v1/chat/completions', data, config)
          .then(function (response) {
            response.data.choices.forEach(function (choice, index) {
            let board = document.getElementById('script')
let newText = choice.message.content.replace(/"은 /g, '"은\n')
newText = newText.replace(/"는 /g, '"는\n')
newText = newText.replace(/어로 /g, '어로\n')
newText = newText.replace(/"입니다./g, '"\n입니다.')
              resultDiv.innerHTML = `<h2>번역 결과</h2>${newText
                .split('\n')
                .join('<br/>')}`
board.value = ''
audioResult.play()
            })
          })
          .catch(function (error) {
            console.error(error)
          })
}else{
alert('정확한 api key와 번역할 단어 또는 문장 그리고 도착언어를 입력해주세요.')
}
}
    </script>

<html>
<body>
<?php
$title = "{$main} > 번역";
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
<main>
    <h1>번역</h1>
<form action="process_create_key.php" method="POST">
<input type="hidden" name="rurl" value="<?=$rurl?>">
<p>openai에서 발급받은 본인의 chat gpt api key를 입력하세요.</p>
    <p>api key</p>
<p><input type="password" id="api_key" name="api_key" placeholder="api key" value="<?=$list['api_key']?>" required></p><br/>
      <p><input type="submit" value="서버에 api key 저장"></p>
    </form><br/>
<?=$list_create_dt?><br/>

<p>번역할 단어 또는 문장을 입력하세요.</p>
    <p>번역할 단어 또는 문장</p>
<p><input type="text" id="script" name="script" placeholder="번역할 단어 또는 문장" required></p><br/>

<p>도착언어를 입력하세요.</p>
    <p>도착언어</p>
<p><input type="text" id="language" name="language" placeholder="도착언어" required></p><br/>

    <p><button onclick="search()">전송</button></p>
    <br /><br />

    <div id="result"></div>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>
