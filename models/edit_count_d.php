<?php
$st_sql = '';
$st_page ='';
$menu_m = json_menu2array($menu_json);
	
if ( $sid > 0) {
	$menuLeft = new Privelege( $pdo, $sid);
	$menu_left_m = $menuLeft->get_menu_left( $pdo );
    $visibly = $menuLeft->GetVisiblyFilter( $Full_Page_Name );

    $name = new GetUser( $pdo, $sid );
    $user = $name->user;

}

$currentPage = new GetNamePage( $pdo, $Full_Page_Name, $config['LANG'] );
$head = $currentPage->get_head( $head );
    
$sq  = "SELECT l.id, l.name FROM  lots AS l;";
$lots[] = Array('id' => '0','name' => 'Все участки');

$res = $pdo->prepare( $sq );
if ($res->execute()) {
	while ($row = $res->fetch()) {
		$lots[] = $row;
	}
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}
   	
	
?>

	