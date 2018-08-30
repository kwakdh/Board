<?php
session_destroy();
?>
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
    <br />
    <center><h1>게 시 판 로 그 인</h1></center><br/>
</head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/latest/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/latest/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: #f8f8f8;
        padding: 60px 0;
    }
    #login-form > div {
        margin: 15px 0;
    }
</style>

<div class="container">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">다희가 운영하는 게시판 ^__________^ 로그인 하시오 </div>
            </div>
            <div class="panel-body">
                <form id="login-form" method="post" action="<?$_SERVER['PHP_SELF']?>">
                    <div>
                        <input type="text" class="form-control" name="id" placeholder="Username" autofocus>
                    </div>
                    <div>
                        <input type="password" class="form-control" name="pw" placeholder="Password">
                    </div>
                    <div>
                        <button type="submit" name="menu" value="로그인" class="form-control btn btn-primary">로그인</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php

include "dbconnect.php";
$mysql_handler = connectDB();
mysqli_select_db($mysql_handler,"new");

if($_POST['menu']=='로그인'){

    session_start(); //세션 시작

    if(isset($_POST['id'])){
       $id=$_POST['id'];
       $pw=$_POST['pw'];
    }

    $sql="select * from customer where id='$id' and password='$pw'";
    $result = mysqli_query($mysql_handler,$sql);
    $row = mysqli_fetch_array($result);

    if($row[0]==$id){
        if($row[1]==$pw){
            $_SESSION['user_id']=$row[0];
            $_SESSION['password']=$row[1];
            $_SESSION['name']=$row[2];

            echo "<script>alert('로그인 성공')</script>";
            echo "<script>location.replace('list.php?page=1')</script>";
        }else {
            echo "<script>alert('로그인 실패!')</script>";
        }

    }






    close($mysql_handler);

}



?>
