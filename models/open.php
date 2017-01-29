<?php
mb_internal_encoding('UTF-8');
$db = \db::getLink();
$pdo = $db->getDb();

$keys1 = 'CoUnTeRs';
session_start();
//if (isset($_SESSION['user']['id'])) $sid = $_SESSION['sid']; else $sid = null;

?>