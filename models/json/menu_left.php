<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

if ( $sid > 0 ) {
	$menuLeft = new pdo\Privelege( $sid );
	$menu_left_m = $menuLeft->getMenuLeft( $pdo );
}

echo json_encode( $menu_left_m );
