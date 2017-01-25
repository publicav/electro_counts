<?php
$menu_m = json_menu2array( $menu_json );
if ( $sid > 0 ) {
	$menuLeft = new pdo\Privelege( $pdo, $sid );
	$menu_left_m = $menuLeft->get_menu_left( $pdo );

	$name = new pdo\GetUser( $pdo, $sid );
	$user = $name->user;
}
$currentPage = new pdo\GetNamePage( $pdo, $Full_Page_Name, $config['LANG'] );
$head = $currentPage->get_head( $head );
 
$lotsFilter = new pdo\Lots( $pdo );
$lots = $lotsFilter->GetLotsFilter();
?>

	