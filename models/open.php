<?php


//  $db=mysql_pconnect("localhost","root","1234");
//  mysql_select_db("electro_count",$db);
//  mysql_query("SET NAMES 'utf8'");

$db_li = new mysqli("localhost", "root", "1234", "electro_count");
if ($db_li->connect_errno) {
    echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
}
if (!$db_li->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
    exit();
} 


 $keys1 = 'CoUnTeRs';
   session_start();
   if (isset($_SESSION['sid'])) $sid = $_SESSION['sid']; else $sid = 0;

?>