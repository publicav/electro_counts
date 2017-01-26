<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_GET );
$lot = $filter->getInt('data');

if ( is_null( $lot ) ) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    echo exit_error(false, 1, 'Error input Lot ');
    exit();
} 
$substationFilter = new pdo\Substation( $pdo, $lot );

$result = [ 'success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$substationFilter->GetSubstationFilter() ];
print json_encode($result);
