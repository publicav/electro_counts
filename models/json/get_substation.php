<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once "Autoload.php";

$filter = new \filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

if (isset($get_prog['data'])) $lot = (int)$get_prog['data']; 
else {
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input Lot ');
    exit();
} 

$substationFilter = new pdo\Substation( $pdo, $lot );
$counts_substation = $substationFilter->GetSubstation();

$result = array('success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$counts_substation);
print json_encode($result);

?>