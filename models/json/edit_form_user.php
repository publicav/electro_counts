<?php
include_once("../open.php");
include_once("../config.php");
//include_once("../funclib.php");
                                            

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

$sq = "SELECT id, users, password, name, family FROM users WHERE  (ring > 0) AND (id = :id) ORDER BY id DESC;"; 

$param = array('id' => $id);
$res = $pdo->prepare( $sq );
 if ($res->execute( $param )) {
    while ($row = $res->fetch()) $user = $row;
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo() );
    exit();
}

$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $user;

echo json_encode($type);
?>

	