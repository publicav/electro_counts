<?php
$menu_m = json_menu2array($menu_json);
if ( $sid > 0 ) {
	$menuLeft = new pdo\Privelege( $pdo, $sid);
	$menu_left_m = $menuLeft->get_menu_left( $pdo );

	$name = new pdo\GetUser( $pdo, $sid );
	$user = $name->user;
}
$currentPage = new pdo\GetNamePage( $pdo, $Full_Page_Name, $config['LANG'] );
$head = $currentPage->get_head( $head );

	
$sq = "SELECT id, users, name, family FROM users WHERE  (ring > 0) ORDER BY id DESC;";
$res = $pdo->prepare( $sq );
if ($res->execute()) {
	$user_all = $res->fetchAll(); 
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}
	
?>

	