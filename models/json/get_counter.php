<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_GET );
$substation = $filter->getInt('data');

if ( is_null( $substation ) ) {
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input substation ');
    exit();
}
$counterFilter = new pdo\Counter( $pdo, $substation );

$result = ['success' => true, 'error' => 'Ok', 'id_error' => 0,  'data' => $counterFilter->GetCounter() ];
print json_encode($result);
