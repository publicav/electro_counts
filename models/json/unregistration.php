<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$type['success'] = true;
$type['message'] = 'Пользователь разлогинился';

base\Auth::logout();
echo json_encode($type);
