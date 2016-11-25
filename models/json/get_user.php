<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
	
$sq = "SELECT id, users, name, family FROM users WHERE  (ring > 0) ORDER BY id DESC;";
if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $user_all[] = $row;              
    }
    $res->free();
}

$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $user_all;
print json_encode($type);
?>

	