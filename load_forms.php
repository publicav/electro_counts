<?php
mb_internal_encoding('UTF-8');
include_once "models/json/AutoloadBase.php";
include_once("models/open.php");
include_once("models/config.php");
include_once("models/funclib.php");


$Full_Page_Name  = 'add_user';
$visibly = 0;
$head=include_h("views/head.tpl");

if ($sid == 0) {
	$menu_json = include_h("models/json/menu.json");
	include("models/load_forms_d.php");
	include("views/blank_v.php");			
} else {
	$menu_json = include_h("models/json/menu_registration.json");
	include("models/load_forms_d.php");
	include("views/load_forms_v.php");
}
exit();
?>