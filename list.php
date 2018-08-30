
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>다희의 게시판</title>

    <!-- 부트스트랩 -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">

    <br />
    <center><h1>게 시 판 목 록</h1></center><br/>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>


<?php

session_start();

include('dbconnect.php');

$mysql_handler = connectDB();
mysqli_select_db($mysql_handler,"new");
selectDB($mysql_handler);

$user_id= $_SESSION['user_id']; //Session Insert
$user_name= $_SESSION['name'];

echo "<div style='text-align:right'>".$_SESSION['name']."님이 로그인 하셨습니다"."</div>";
echo "<br />";

//------------------ board pagination  part --------------------

$sql = "SELECT * FROM board";
$result=mysqli_query($mysql_handler, $sql);

$page_per_record =5; //Number of data to display per page --- 5개
$block_per_page=5; // List at the bottom of the article  --- 5개
$now_page=$_GET['page']; //Current Page Number
$total_record = mysqli_num_rows($result); //Total number of posts uploaded

$total_page = ceil($total_record/$page_per_record);
//Number of pages to be implemented at the bottom (13개면/5) -> 올림해서 3개 나타남

$now_block = ceil($now_page/$block_per_page);//Block number to which the current page belongs

$start_record = (($now_page-1)*$page_per_record);//Record start number to import
$start_page = (($now_block-1)*$block_per_page)+1; //Page start number to import

$sql= "select * from board  where board_pid = 0 order by board_id desc limit $start_record, $page_per_record";
$result = mysqli_query($mysql_handler, $sql);

$end_page = ( ($start_page+$block_per_page) <= $total_page )? ($start_page+$block_per_page) : $total_page; //the last page



//------------------- board body  part -----------------------------

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

// --------------------------- PageNation Results --------------------------------
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
