<?php
 $db=mysql_pconnect("localhost","root","1234");
 mysql_select_db("electro_count",$db);mysql_query("SET NAMES 'utf8'");
 $keys1 = 'CoUnTeRs';
   session_start();
   if (isset($_SESSION['sid'])) $sid = $_SESSION['sid']; else $sid = 0;

?>