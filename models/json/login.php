<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
  
foreach ($_POST as $key => $value) 
{
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $get_prog[$key] = $value;
}    
echo json_encode($get_prog);
?>