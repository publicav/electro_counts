<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

if (isset($get_prog['data'])) $substation = (int)$get_prog['data']; else
{
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input substation ');
    exit();
}

$counterFilter = new pdo\Counter( $pdo, $substation );
$counts_count = $counterFilter->GetCounter();

$result = array('success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$counts_count);
print json_encode($result);
?>