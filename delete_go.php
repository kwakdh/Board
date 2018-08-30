<?php
session_start();
$id=$_SESSION['user_id'];
$pw=$_SESSION['password'];
$name=$_SESSION['name'];

include('dbconnect.php');
$mysql_handler=connectDB();
mysqli_select_db($mysql_handler,"new");

$board_id=$_GET['board_id'];
$post_pw=$_POST['pwpw'];

$sql0 ="select * from board where board_id='$board_id'";
$result0 = mysqli_query($mysql_handler,$sql0);
$row0 = mysqli_fetch_array($result0);

//If session ID and table corresponding row ID are the same
if($row0['user_id']==$_SESSION['user_id']){
    
    //If session password and table corresponding row password are the same
    if($pw==$post_pw){

        $sql= "delete from board where board_id='$board_id'";
        $result = mysqli_query($mysql_handler,$sql);
        echo "<script>alert('성공적으로 삭제 되었습니다.')</script>";
        echo "<script>location.replace('list.php?page=1')</script>";

    }//If session password and corresponding password are not the same
    else {
       echo "<script>alert('비밀번호가 틀립니다.')</script>";
       echo "<script>location.replace('listup.php?board_id=$board_id') </script>";
    }
 }  
//If session password and table corresponding row password are not the same
else{
    echo "<script>alert('관리자 권한이 없습니다.')</script>";
    echo "<script>location.replace('listup.php?board_id=$board_id')</script>";
}



?>
