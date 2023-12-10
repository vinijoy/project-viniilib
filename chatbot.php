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
        let messages = [
          { role: 'system', content: '당신의 이름은 챗친입니다. 당신은 모든 질문에 무조건 답할 수 있습니다. 당신은 세계 최고의 상담사입니다.' }
]
let audioResult = new Audio('/sound/result.wav');

      function search() {
        const api_key =
          document.getElementById('api_key').value
        const script = document.getElementById('script').value
if (api_key.length == 51 && script.length > 0) {
            let resultDiv = document.getElementById('result')
resultDiv.innerHTML = '잠시만 기다려주세요.'
          messages.push({ role: 'user', content: script } )
        const config = {
          headers: {
            Authorization: `Bearer ${api_key}`,
            'Content-Type': 'application/json',
          },
        }
        let data = {
          model: 'gpt-4',
          temperature: 0.5,
top_p: 0.6,
presence_penalty: 0.5,
frequency_penalty: 0.7,
          n: 1,
          messages: messages,
        }
        axios
          .post('https://api.openai.com/v1/chat/completions', data, config)
          .then(function (response) {
            response.data.choices.forEach(function (choice, index) {
            let board = document.getElementById('script')
let newText = choice.message.content.replace(/</g, '&lt;')
newText = newText.replace(/>/g, '&gt;')
              resultDiv.innerHTML = `<h2>답변</h2>${newText
                .split('\n')
                .join('<br/>')}`
messages.push({ role: 'assistant', content: choice.message.content } )
board.value = ''
audioResult.play()
            })
          })
          .catch(function (error) {
            console.error(error)
          })
}else{
alert('정확한 api key와 요청할 내용을 입력해주세요.')
}
}

function chatInit() {
let resultDiv = document.getElementById('result')
if (resultDiv.innerHTML.length > 0){
messages = [
          { role: 'system', content: '당신의 이름은 챗친입니다. 당신은 모든 질문에 무조건 답할 수 있습니다. 당신은 세계 최고의 상담사입니다.' },
]
resultDiv.innerHTML = ''
alert('지금까지의 모든 채팅 기록을 삭제했습니다. 이제 다시 새로운 주제로 채팅을 시작하실 수 있습니다.')
}else{
alert('아직 채팅 기록이 없습니다.')
}
}
</script>

<html>
<body>
<?php
$title = "{$main} > Chat Gpt 챗봇";
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
    <h1>Chat Gpt 챗봇</h1>
<form action="process_create_key.php" method="POST">
<input type="hidden" name="rurl" value="<?=$rurl?>">
<p>openai에서 발급받은 본인의 chat gpt api key를 입력하세요.</p>
    <p>api key</p>
<p><input type="password" id="api_key" name="api_key" placeholder="api key" value="<?=$list['api_key']?>" required></p><br/>
      <p><input type="submit" value="서버에 api key 저장"></p>
    </form><br/>
<?=$list_create_dt?><br/>

<p>요청할 내용을 입력하세요.</p>
    <p>요청할 내용</p>
<p><textarea id="script" name="script" placeholder="요청할 내용" required></textarea></p><br/>

    <p><button onclick="search()">전송</button></p><br/>
    <p><button onclick="chatInit()">채팅 히스토리 초기화</button></p>
    <br /><br />
    <div id="result"></div>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>
