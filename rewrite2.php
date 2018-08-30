<?php
session_start();
$id = $_SESSION['user_id'];
$pw = $_SESSION['password'];
$name = $_SESSION['name'];


include('dbconnect.php');
$mysql_handler = connectDB();
mysqli_select_db($mysql_handler, "new");

$board_id = $_GET['board_id'];


$subject = $_POST['subject'];
$contents = $_POST['contents'];
$post_pw = $_POST['pw'];


$sql0 = "select * from board where board_id='$board_id'";
$result0 = mysqli_query($mysql_handler, $sql0);
$row0 = mysqli_fetch_array($result0);
$userid = $row0['user_id'];

//If the current writer's ID and session ID are the same
if ($userid == $id) {
    if ($pw == $post_pw) {

        $sql = "update board set subject='$subject', contents='$contents' where  board_id='$board_id'";
        $result = mysqli_query($mysql_handler, $sql);
        echo "<script>alert('성공적으로 수정 되었습니다.')</script>";
        echo "<script>location.replace('listup.php?board_id=$board_id')</script>";

    } else {//Passwords do not match
        echo "<script>alert('비밀번호가 틀립니다.');
           history.go(-1);
</script>";
    }
} //If the current recorder's ID and session ID are not the same
else {
    echo "<script>alert('관리자 권한이 없습니다.');
    history.go(-1);
    </script>";
}


?>
