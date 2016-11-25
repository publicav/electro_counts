<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
                                            
$url_search_action =  "edit_count.php";

foreach ($_GET as $key => $value) 
{
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $get_prog[$key] = $value;
}    
	
if(isset($get_prog['id'])) 
{
    $id = intval($get_prog['id']);
    $select=1;
} else {$id = 0; $select = 1;}

$sq = "SELECT id, users, password, name, family FROM users WHERE  (ring > 0) AND (id = $id) ORDER BY id DESC;"; 
if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $user = $row;              
    }
    $res->free();
}
$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $user;

echo json_encode($type);
?>

	