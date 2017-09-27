<?php
session_start();
$id=$_SESSION['user_id'];
$pw=$_SESSION['password'];
$name=$_SESSION['name'];

include('dbconnect.php');
$mysql_handler=connectDB();
mysqli_select_db($mysql_handler,"new");

$board_id=$_GET['board_id'];


//$subject=$_POST['subject'];
//$contents=$_POST['contents'];
$post_pw=$_POST['pwpw'];

$sql0 ="select * from board where board_id='$board_id'";
$result0 = mysqli_query($mysql_handler,$sql0);
$row0 = mysqli_fetch_array($result0);

if($row0['user_id']==$_SESSION['user_id']){
    if($pw==$post_pw){

        $sql= "delete from board where board_id='$board_id'";
        $result = mysqli_query($mysql_handler,$sql);
        echo "<script>alert('성공적으로 삭제 되었습니다.')</script>";
        echo "<script>location.replace('list.php?page=1')</script>";

    }else {
        //비밀번호가 일치하지 않은 경우
        echo "<script>alert('비밀번호가 틀립니다.')</script>";
        echo "<script>location.replace('listup.php?board_id=$board_id') </script>";
    }
}else{
    echo "<script>alert('관리자 권한이 없습니다.')</script>";
    echo "<script>location.replace('listup.php?board_id=$board_id')</script>";
}



?>