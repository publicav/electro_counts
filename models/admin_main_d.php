<?php
	
$menu_m = json_menu2array($menu_json);

if ( $sid > 0 ) {
	$menuLeft = new Privelege( $pdo, $sid);
	$menu_left_m = $menuLeft->get_menu_left( $pdo );

	$name = new GetUser( $pdo, $sid );
	$user = $name->user;
	
}

 $currentPage = new GetNamePage( $pdo, $Full_Page_Name, $config['LANG'] );
 $head = $currentPage->get_head( $head );
 
 
?>

	