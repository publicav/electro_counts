<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");


$route = navigation\Route::init();
$id_users = $route->getAuthorization();

if ( $id_users > 0 ) {
	$menuLeft = new pdo\Privelege( $id_users );
	$menu_left_m = $menuLeft->getMenuLeft();
}

echo json_encode( $menu_left_m );
