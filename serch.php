<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>다희의 게시판</title>

    <!-- 부트스트랩 -->
    <link href="http://localhost/css/bootstrap.min.css" rel="stylesheet">
    <br/>
    <center><h1>게 시 글 찾 기</h1></center>
    <br/>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php

session_start();
$user_id = $_SESSION['user_id']; //세션 넣을 부분
$user_name = $_SESSION['name'];

echo "<div style='text-align:right'>" . $_SESSION['name'] . "님이 로그인 하셨습니다" . "</div>";
echo "<br />";

include('dbconnect.php');

$mysql_handler = connectDB();
mysqli_select_db($mysql_handler, "new");


//About search options
$serching = $_REQUEST['serching'];//키워드
$filed = $_REQUEST['filed'];


if (strlen($serching) > 0) {
    if ($filed == "sub") {
        $sql = "select * from board where subject like '%$serching%' and board_pid=0 order by board_id desc";
        $result = mysqli_query($mysql_handler, $sql);

    }
    if ($filed == "name") {
        $sql = "select * from board where user_name like '%$serching%' and board_pid=0 order by board_id desc";
        $result = mysqli_query($mysql_handler, $sql);
    }
    if ($filed == "all") {
        $sql = "select * from board where (subject like '%$serching%' and board_pid=0) or
                  (contents like '%$serching%' and board_pid=0) order by board_id desc";
        $result = mysqli_query($mysql_handler, $sql);
    }
} else {
    $sql = "select * from board where board_pid=0 order by board_id desc";
    $result = mysqli_query($mysql_handler, $sql);
}
$total_su = mysqli_num_rows($result);

echo "<div style='text-align:left '>" . "총 검색된 게시글 수: " . $total_su . "</div>";
echo "<br/>";
$page = $_GET[page];
//--------------------------- Pagenation section---------------------------------

if (empty($page)) {
    $page = 1;
}
$start_no = ($page - 1) * 5; //the first number of the present

$total_page = ceil($total_su / 5); //맨 밑에 뜨는 번호 개수

// If there are no search results
if (mysqli_num_rows($result) == 0)
    echo "<tr><td colspan=5 align=center height=50>
        	            등록된 글이 없습니다.
        	        </td>
        	     </tr>";

$line = 0;

//--------------------------- Border body part ----------------------------------


echo "<center>";
echo "<table class='table table-hover'>";

echo "<tr>";
echo "<td>번호</td><td>제목</td><td>작성자</td><td>작성일</td><td>조회수</td>";
echo "</tr>";

while ($row = mysqli_fetch_array($result)) {
    if ($line < ($page - 1) * 5 ) {
        $line++;
        continue;
    } else {
        echo "<tr>";
        echo "<td>" . $row['board_id'] . "</td>";
        echo "<td><a href='listup.php?board_id=$row[board_id]'>" . $row['subject'] . "</a>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['reg_date'] . "</td>";
        echo "<td>" . $row['hits'] . "</td>";
        echo "</tr>";
    }
    $line++;
    if ($line == $page*5) {
        break;
    }
}



echo "</table>";
echo "</center>";


?>

<!--------------------------------- 쪽 이동 ------------------------------------->

<table cellspacing=0 border=0 width=80%>
    <tr>
        <td align="center" bgcolor="#F0F0F0">
            <?
            //밑에 수 표시
            for ($i = 1; $i <= $total_page; $i++) {

                if ($i == $page)
                    echo $i . " ";
                else
                    echo "<a href='serch.php?page=$i&filed=$filed&serching=$serching'>[" . $i . "]</a> ";
            }
            ?>
        </td>
    </tr>
</table>
<br/>

<?

// -------------------------------Return part---------------------------------

echo "<center>";
echo "<input type='button' class='form-control' style='width: 10%'  value='back' onclick=location.href='list.php?page=1'>";
echo "</center>";
close($mysql_handler);


?>
