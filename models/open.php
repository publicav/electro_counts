<?php


//  $db=mysql_pconnect("localhost","root","1234");
//  mysql_select_db("electro_count",$db);
//  mysql_query("SET NAMES 'utf8'");

// $db_li = new mysqli("localhost", "root", "1234", "electro_count");
// if ($db_li->connect_errno) {
    // echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
// }
// if (!$db_li->set_charset("utf8")) {
    // printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
    // exit();
// } 

$host = "localhost";
$db = "electro_count";
$charset = "utf8";
$user = "root";
$pass = "1234";
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, $user, $pass, $opt);



 $keys1 = 'CoUnTeRs';
   session_start();
   if (isset($_SESSION['sid'])) $sid = $_SESSION['sid']; else $sid = 0;

set_include_path('models/json/pdo');
set_include_path(get_include_path() . PATH_SEPARATOR . 'models/json/date');
// set_include_path(get_include_path() . PATH_SEPARATOR . 'pdo');
// set_include_path(get_include_path() . PATH_SEPARATOR . 'date');

// echo get_include_path();
   
   
?>