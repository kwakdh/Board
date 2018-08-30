<?php

define("HOST","127.0.0.1");
define("USER", "root");
define("PASSWORD", "autoset");
define("DB_NAME", "new");
define("TABLE_NAME", "board");

//echo mysqli_connect_error();
function connectDB()
{
    $mysql_handler = mysqli_connect(HOST, USER, PASSWORD);

    return $mysql_handler;
}
//--------------------------Create Database------------------------------

function selectDB($mysql_handler)
{
    mysqli_select_db($mysql_handler,"new"); //unable to select database here



}
function close( $mysql_handler)
{
    $mysql_handler->close();

}?>
