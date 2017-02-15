<?php
include_once "Autoload.php";
include_once "../open.php";

$filter = new \filter\FilterInput( $_POST );
$get_prog = $filter->getInputAll();

echo json_encode( $get_prog );
