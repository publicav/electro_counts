<?php
include_once  '../../vendor/autoload.php';
//include_once "Autoload.php";
include_once "../open.php";

$result = [
    'success' => true,
    'message' => 'Пользователь разлогинился',
];

\Base\Auth::logout();

echo json_encode( $result );
