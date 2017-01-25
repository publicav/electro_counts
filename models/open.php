<?php

$db = \db::getLink();
$pdo = $db->getDb();

$keys1 = 'CoUnTeRs';
session_start();
if (isset($_SESSION['sid'])) $sid = $_SESSION['sid']; else $sid = 0;

?>