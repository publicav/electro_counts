<?php
include_once "Autoload.php";                                            
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_GET );
$id = $filter->getInt('id');

$sq = "SELECT id, users, password, name, family FROM users WHERE  (ring > 0) AND (id = :id) ORDER BY id DESC;"; 

$param = array('id' => $id);
$res = $pdo->prepare( $sq );
 if ( !$res->execute( $param ) ) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
while ($row = $res->fetch()) $user = $row;

$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $user;

echo json_encode($type);


	