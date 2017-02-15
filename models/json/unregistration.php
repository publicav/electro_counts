<?php
include_once "Autoload.php";
include_once "../open.php";

$result = [
    'success' => true,
    'message' => 'Пользователь разлогинился',
];

base\Auth::logout();

echo json_encode( $result );
