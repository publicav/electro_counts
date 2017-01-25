<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$user_all = array();

$sq = "SELECT id, users, name, family FROM users WHERE  (ring > 0) ORDER BY id DESC;";

if ($res = $pdo->query( $sq )){
    while ($row = $res->fetch()) $user_all[] = $row;
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}

$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $user_all;
print json_encode($type);
?>

	