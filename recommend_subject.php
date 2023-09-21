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
        const keywords = document.getElementById('keywords').value
if (api_key.length == 51 && keywords.length > 0){
            let resultDiv = document.getElementById('result')
resultDiv.innerHTML = '잠시만 기다려주세요.'
        const messages = [
          { role: 'system', content: 'You are a helpful assistant.' },
          { role: 'user', content: keywords + '에 대하여 다루어 볼 만한 주제를 10가지 추천해줘.' },
        ]
        const config = {
          headers: {
            Authorization: `Bearer ${api_key}`,
            'Content-Type': 'application/json',
          },
        }
        const data = {
          model: 'gpt-3.5-turbo',
          temperature: 0.5,
          n: 1,
          messages: messages,
        }
        axios
          .post('https://api.openai.com/v1/chat/completions', data, config)
          .then(function (response) {
            response.data.choices.forEach(function (choice, index) {
            let board = document.getElementById('keywords')
              resultDiv.innerHTML = `<h2>답변</h2>${choice.message.content
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
alert('정확한 api key와 키워드를 입력해주세요.')
}
}
    </script>

<html>
<body>
<?php
$title = "{$main} > 주제 추천 AI";
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
    <h1>주제 추천 AI</h1>
<form action="process_create_key.php" method="POST">
<input type="hidden" name="rurl" value="<?=$rurl?>">
<p>openai에서 발급받은 본인의 chat gpt api key를 입력하세요.</p>
    <p>api key</p>
<p><input type="password" id="api_key" name="api_key" placeholder="api key" value="<?=$list['api_key']?>" required></p><br/>
      <p><input type="submit" value="서버에 api key 저장"></p>
    </form><br/>
<?=$list_create_dt?><br/>

<p>추천받고싶은 주제에 해당하는 키워드를 한 개만 입력하세요.</p>
    <p>키워드</p>
<p><input type="text" id="keywords" name="keywords" placeholder="키워드" required></p><br/>

    <p><button onclick="search()">전송</button></p>
    <br /><br />

<p>입력한 키워드를 기반으로 10 개의 주제를 추천해드립니다.</p>
    <div id="result"></div>
</main>

<?php
include ("./inc/footer.php");
}
?>
</body>
</html>
