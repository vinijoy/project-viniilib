$(document).ready(function() {
$('[role="tab"]').keyup(function(e){
var keyCode = e.keyCode || e.which;
// 키보드코드값
if(keyCode == 39 || keyCode == 40){
// 오른쪽방향키이거나 
// 아래쪽방향키
// 브라우저의기본동작을취소한다.
e.preventDefault();
// 다음 tab 요소에 aria-selected=true로 지정하고
// 형제요소중에 자신 tab 이외의 나머지 tab 요소들을
// aria-selected=false로지정한다.
$(this).next().attr('aria-selected', true)
.siblings().attr('aria-selected', false); 
var selectedId = "#"+$(this).next().attr('aria-controls');
// 자신은 보이게하고 다른 tabpanel은 보이지않게지정한다.
$(selectedId).removeClass('unvisual')
.siblings().addClass('unvisual');
// 다음 요소로 포커스를 이동한다.
$(this).next().focus(); 
// 마지막 요소에서 오른쪽방향키나 아래쪽방향키를 눌렀을경우
if($(this).next()
.prevObject.attr('aria-controls')=='section3'){
// tab, tabpanel, focus 모두 처음으로 이동
$('#tab1').attr('aria-selected', true)
.siblings().attr('aria-selected', false); 
$('#section1').removeClass('unvisual')
.siblings().addClass('unvisual');
$('#tab1').focus();
}
}
if(keyCode == 37 || keyCode ==38){
// 왼쪽방향키 이거나 
// 위쪽 방향키
e.preventDefault();
// 이전 tab 요소에 aria-selected=true로 지정하고 
// 형제요소중에 자신 tab 이외의 나머지 tab 요소들을 
// aria-selected=false로 지정한다.
$(this).prev().attr('aria-selected', true)
.siblings().attr('aria-selected', false);
var selectedId = "#"+$(this).prev().attr('aria-controls');
// 자신은 보이게하고 다른 tabpanel은 보이지 않게 지정한다. 
$(selectedId).removeClass('unvisual')
.siblings().addClass('unvisual');
// 이전요소로 포커스를 이동한다.
$(this).prev().focus();
// 처음요소에서 왼쪽 방향키나 위쪽 방향키를 눌렀을 경우
if($(this).prev().prevObject
.attr('aria-controls')=='section1'){
// tab, tabpanel, focus 모두 마지막으로 이동
$('#tab3').attr('aria-selected', true)
.siblings().attr('aria-selected', false); 
$('#section3').removeClass('unvisual')
.siblings().addClass('unvisual');
$('#tab3').focus();
}
} 
if(keyCode == 35){
// end 키를 눌렀을 때
e.preventDefault();
// tab, tabpanel, focus 모두 마지막으로 이동
$('#tab3').attr('aria-selected', true) 
.siblings().attr('aria-selected', false); 
$('#section3').removeClass('unvisual')
.siblings().addClass('unvisual');
$('#tab3').focus();
}
if(keyCode == 36){
// home키를 눌렀을 때
e.preventDefault();
// tab, tabpanel, focus 모두 처음으로 이동 
$('#tab1').attr('aria-selected', true)
.siblings().attr('aria-selected', false); 
$('#section1').removeClass('unvisual')
.siblings().addClass('unvisual');
$('#tab1').focus();
} 
});
$('[role="tab"]').keydown(function(e){ 
var keyCode = e.keyCode || e.which;
// 키보드 코드값 
if(keyCode == 9){
// 탭키를 눌렀을 때
e.preventDefault();
var selectedId = "#"+$(this).attr('aria-controls');
console.log(selectedId);
$(selectedId).children('a').focus();
} 
});
$('section a').keydown(function(e){
var keyCode = e.keyCode || e.which;
// 키보드 코드값 
if (keyCode == 9 && e.shiftKey) {
// shift+tab 키
$('.tab-list li').each(function( index ) {
if($( this ).attr('aria-selected') == 'true'){
$( this ).next().focus();
return false;
} 
}); 
}
});
// tab 요소에 클릭 이벤트를 추가한다.
$('[role="tab"]').on('click', function(e) {
e.preventDefault();
// 클릭한 tab 요소에 aria-selected=true로 지정하고 
// 형제요소중에 자신 tab 이외의 나머지 tab 요소들을 
// aria-selected=false로 지정한다.
$(this).attr('aria-selected', true)
.siblings().attr('aria-selected', false); 
var selectedId = "#"+$(this).attr('aria-controls');
// 자신은 보이게하고 다른 tabpanel은 보이지 않게 지정한다. 
$(selectedId).removeClass('unvisual')
.siblings().addClass('unvisual');
}); 
});
// 문서가 로드될 때
// sorcecode를 안 보이게 한다.
$(document).ready(function(){
    $("#sorcecode").hide();
    // showandhidesorcecode를 클릭하면
    // 해당 객체의 이름이
    // 소스코드 보기일 때는
    // 소스코드 가리기로
    // 예외일 때는 소스코드 보기로
    // 변경되게 한다.
    $(".showandhidesorcecode").click(function(){
      if($(".showandhidesorcecode").html()=='소스코드 보기'){
        $(".showandhidesorcecode").html('소스코드 가리기');
      }
      else{$(".showandhidesorcecode").html('소스코드 보기');
      };
      // 해당 객체를 클릭할 때마다 sorcecode를 토글되게 한다.
      $("#sorcecode").toggle();
          });
  });
  // 문서가 로드될 때
  // board를 안 보이게 한다.
  $(document).ready(function(){
    $("#menu").hide();
    $("#board").hide();
    $("#program").hide();
    $("#showandhidemenu").click(function(){
      if($(this).html()=='내계정'){
        $(this).html('레이어 닫기');
      }
      else{$(this).html('내계정');
      };
      $("#menu").toggle("slide");
  });
    $("#showandhideboard").click(function(){
      if($(this).html()=='게시판 펼치기'){
        $(this).html('게시판 접기');
      }
      else{$(this).html('게시판 펼치기');
      };
      $("#board").toggle("slide");
          });
    $("#showandhideprogram").click(function(){
      if($(this).html()=='웹프로그램 펼치기'){
        $(this).html('웹프로그램 접기');
      }
      else{$(this).html('웹프로그램 펼치기');
      };
      $("#program").toggle("slide");
  });
  });
// 클립보드로 복사하는 기능을 생성
function copyToClipboard(elementId) {

  // 글을 쓸 수 있는 란을 만든다.
  var aux = document.createElement("input");
  // 지정된 요소의 값을 할당 한다.
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);

  // body에 추가한다.
  document.body.appendChild(aux);

  // 지정된 내용을 강조한다.
  aux.select();

  // 텍스트를 카피 하는 변수를 생성
  document.execCommand("copy");

  // body 로 부터 다시 반환 한다.
  document.body.removeChild(aux);
alert("복사되었습니다.");
}
