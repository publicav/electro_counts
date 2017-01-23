<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once "Autoload.php";

$filter = new \filter\FilterInput( $_POST );
$get_prog = $filter->getInputAll();
  
echo json_encode($get_prog);
?>