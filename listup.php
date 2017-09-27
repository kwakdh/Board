<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>다희의 게시판</title>

    <!-- 부트스트랩 -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <br />
    <center><h1>게 시 글 내 용</h1></center><br/>
</head>
<body>
<!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>



<?php

session_start();
$user_id= $_SESSION['user_id']; //세션 넣을 부분
$user_name= $_SESSION['name'];

echo "<div style='text-align:right'>".$_SESSION['name']."님이 로그인 하셨습니다"."</div>";
echo "<br />";

include('dbconnect.php');

$mysql_handler = connectDB();
mysqli_select_db($mysql_handler,"new");
//selectDB($mysql_handler);

$board_id=$_GET['board_id'];
$sql= "select * from board where board_id = '$board_id'";
$result = mysqli_query($mysql_handler,$sql);

//--------------------------------------- 조회수 증가 ------------------------------------------------

if(!empty($board_id) && empty($_COOKIE['count' .$board_id])) {
    $sql1 = "update board set hits = hits + 1 where board_id='$board_id'";
    $result1 = mysqli_query($mysql_handler,$sql1);
    if(!empty($result1)) {
      setcookie('count' . $board_id, TRUE, time() + (60 * 60 * 24), '/');
    }
}


echo "<table class='table table-striped table-bordered table-hover'>";
echo "<center>";
while($row=mysqli_fetch_array($result)) {

    echo "<tr>" . "<td nowrap width='60' >제  목</td>" . "<td nowrap width='450'>" .$row['subject']."</td>" . "</tr>";
    echo "<tr>" . "<td>작성자</td>" . "<td>" .$row['user_name']."</td>" . "</tr>";
    echo "<tr>" . "<td>아이디</td>" . "<td>" .$row['user_id']."</td>" . "</tr>";
    echo "<tr>" . "<td>작성일</td>" . "<td>" .$row['reg_date']."</td>" . "</tr>";
    echo "<tr>" . "<td nowrap height='260'>내  용</td>" . "<td>" .$row['contents']."</td>" . "</tr>";

}

echo "</center>";
echo "</table>";
//--------------------------------- 댓글 구현 부분--------------------------------------------------

$sql2="select * from board WHERE board_pid = $board_id";
$result2=mysqli_query($mysql_handler,$sql2);
echo"<table class='table table-condensed'>";
while ($row2=mysqli_fetch_array($result2)){

  echo "<tr>";
  echo "<td>".$row2['user_id']."</td>";
  echo "<td>".$row2['contents']."</td>";
  echo "<td>".$row2['reg_date']."</td>";
  echo "</tr>";

}
echo "</table>";
//-------------------------------------- 댓글 작성 부분 --------------------------------------------

echo "<form action='comment.php?board_id=$board_id' method='post'>";
echo "< 댓 글 >";
echo "<input type='text' name='comment' id='comment' class='form-control' style='width: 80%'  placeholder='comment' >";
echo "<input type='submit' class='btn btn-default' value='submit'>";
echo "</form>";

//-------------------------------------- 버튼 부분 -------------------------------------------------
echo "<br />";
echo "<center>";
echo "<input type='button' class='btn btn-default' onclick=location.href='list.php?page=1' value='back'>";  //리스트 다시 돌아가기
echo "&nbsp;&nbsp;&nbsp;";
echo "<input type='button' class='btn btn-default' onclick=location.href='rewrite.php?board_id=$board_id' value='rewrite'>"; //수정하기
echo "&nbsp;&nbsp;&nbsp;";
echo "<input type='button' class='btn btn-default' onclick='deleteGo()' value='delete'>"; //삭제하기
echo "</center>";
echo "<br />";

echo "<script>
     function deleteGo() {
       var deleteHonto = confirm('정말 삭제하겠습니까?');
       if(deleteHonto==false){
          
         alert('소중한 글....ㅎ');

       }else {
           
        document.location.href='delete_mae.php?board_id=$board_id'; 
      
       }
     }
</script>";

close($mysql_handler);


?>