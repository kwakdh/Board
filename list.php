
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
    <center><h1>게 시 판 목 록</h1></center><br/>
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

include('dbconnect.php');

$mysql_handler = connectDB();
mysqli_select_db($mysql_handler,"new");
selectDB($mysql_handler);

$user_id= $_SESSION['user_id']; //세션 넣을 부분
$user_name= $_SESSION['name'];

echo "<div style='text-align:right'>".$_SESSION['name']."님이 로그인 하셨습니다"."</div>";
echo "<br />";
//------------------ 게시판 페이지네이션 부분 --------------------

$sql = "SELECT * FROM board";
$result=mysqli_query($mysql_handler, $sql);

$page_per_record =5; //한 페이지당 표시할 자료의 개수 --- 5개
$block_per_page=5; // 글 밑에 목록  --- 5개
$now_page=$_GET['page']; //현재 페이지 번호
$total_record = mysqli_num_rows($result); //전체 올라온 게시글 수

$total_page = ceil($total_record/$page_per_record);
//맨 밑에 구현해야 할 페이지개수 (13개면/5) -> 올림해서 3개 나타남

$now_block = ceil($now_page/$block_per_page);//현재 페이지가 속해있는 블록 번호

$start_record = (($now_page-1)*$page_per_record);//가져올 레코드 시작번호
$start_page = (($now_block-1)*$block_per_page)+1; //가져올 페이지 시작 번호

$sql= "select * from board  where board_pid = 0 order by board_id desc limit $start_record, $page_per_record";
$result = mysqli_query($mysql_handler, $sql);

$end_page = ( ($start_page+$block_per_page) <= $total_page )? ($start_page+$block_per_page) : $total_page; //마지막 페이지*/



//-------------------게시판 body 부분-----------------------------

echo "<center>";
echo "<table class='table table-hover'>";

echo "<tr>";
echo "<td>번호</td><td>제목</td><td>작성자</td><td>작성일</td><td>조회수</td>";
echo "</tr>";
while($row= mysqli_fetch_array($result)){

   echo "<tr>";
   echo "<td>".$row['board_id']."</td>";
   echo "<td><a href='listup.php?board_id=$row[board_id]'>".$row['subject']."</a>";
   echo "<td>".$row['user_name']."</td>";
    echo "<td>".$row['reg_date']."</td>";
    echo "<td>".$row['hits']."</td>";
    echo "</tr>";

}

echo "</center>";
echo "</table>";

// -------------------------------페이지 네이션 결과---------------------------------
echo "<center>";
echo "<td>";
echo "<a href=$_SERVER[PHP_SELF]?page=1> ◀ </a>";


for($i = $start_page; $i <= $end_page-1; $i++){

    echo "&nbsp"."&nbsp";
    echo "<a href=$_SERVER[PHP_SELF]?page=$i> $i </a>";

}
echo "<a href=$_SERVER[PHP_SELF]?page=$end_page> ▶ </a>";

echo "</td>";
echo "</center>";
echo "<br />";

echo "<style>";
echo ".button2{

    position :relative;
    top:15px ;
    bottom: 10px;
    left:0;
    right:0;

    height:10%;
    margin:0 auto;
    padding: 0;
    float: 0;
    
}";
echo "</style>";


echo "<center>";
echo "<input type='button' class='form-control' style='width: 10%'  value='logout' onclick=location.href='board_login.php'>";

echo "<input type='button' class='form-control' style='width: 10%'  value='write' onclick=location.href='board.html'>";


echo "</center>";
close($mysql_handler);

?>

<html>
<style>
.container2{
    position :absolute;
    top:5px ;
    bottom: 10px;
    left:0;
    right:0;

    height:10%;
    margin:0 auto;
}
</style>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<body>
<Br />

<div class="container" >
    <nav class="navbar navbar-default" role="navigation">

        <form class="navbar-form navbar-left" method="post" action="serch.php?page=1" role="search">
       <!-- Collect the nav links, forms, and other content for toggling -->

               <div class="container2">
                    <select name=filed class="form-control" style="width:150px; height:30px;">
                    <option value="sub">subject</option>
                    <option value="name">user_name</option>
                    <option value="all">all</option>
                    </select>

                    <div class="form-group">
                        <input type="text" class="form-control" name="serching" placeholder="Search">
                    </div>

                    <button type="submit" class="btn btn-default">Serch</button>
</div>
           </form>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
</body>
</html>