<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");


	
if ( $sid > 0 ) {
	$menuLeft = new Privelege( $pdo, $sid);
	$menu_left_m = $menuLeft->get_menu_left( $pdo );
}

if ( !isset($menu_left_m) ) {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, 'Меню отсутствует' );
	exit();
}

    print json_encode($menu_left_m);
?>