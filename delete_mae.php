<?php

session_start();
$id=$_SESSION['user_id'];
$pw=$_SESSION['password'];
$name=$_SESSION['name'];


include('dbconnect.php');

$mysql_handler = connectDB();
mysqli_select_db($mysql_handler,"new");
//selectDB($mysql_handler);

$board_id=$_GET['board_id'];

echo "<div style='text-align:right'>".$_SESSION['name']."님이 로그인 하셨습니다"."</div>";
echo "<br />";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>다희의 게시판</title>

    <!-- Bootstrap -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">

    <br />
    <center><h1>비 밀 번 호 입 력</h1></center><br/>
</head>
<body>
<div class="panel-body">
    <center>
    //Password Entry Form
    <form method="post" action='delete_go.php?board_id=<? echo $board_id ?>' >
        <div>
            <input type="password" class="form-control" name="pwpw"  style='width: 23%'  placeholder="Password">
        </div>
        <br/>
        <div>
            <button type="submit" name="menu" value="input" style='width: 23%' class="form-control btn btn-primary">입력</button>
        </div>
    </form>
    </center>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

