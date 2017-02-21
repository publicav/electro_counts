<?php
include_once  '../../vendor/autoload.php';
//include_once "Autoload.php";
include_once "../open.php";

$filter = new \Filter\FilterInput( $_POST );
$get_prog = $filter->getInputAll();

echo json_encode( $get_prog );
