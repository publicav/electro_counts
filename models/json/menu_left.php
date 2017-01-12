<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once "pdo/Privelege.php";

	
if ( $sid > 0 ) {
    // $sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = ?)";

    // $res = $pdo->prepare( $sq );
    // if ($res->execute( [$sid] )) {
    //     while ($row = $res->fetch()) $priv[] = $row;
    // } else {
    //     header("HTTP/1.1 400 Bad Request", true, 400);
    //     print exit_error( false, 3, $res->errorInfo()[2] );
    //     exit();
    // }

	// if (!isset( $priv )) {
	// 	header("HTTP/1.1 400 Bad Request", true, 400);    
	// 	echo exit_error(false, 1, 'Error input users ');
	// 	exit();
	// }

	// $sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);";
	// $res = $pdo->prepare( $sq );
	// if ($res->execute( [$sid] )) {
	// 	while ($row = $res->fetch()) {
	// 		for($i = 0; $i < SizeOf( $priv ); $i++) {
	// 			if (($row['id_menu'] == $priv[$i]['id_menu']) AND ($priv[$i]['visibly'] == 1)) {
	// 				$menu_left_m[] = $row; break;
	// 			}    
	// 		}
	// 	}     
	// } else {
	// 	header("HTTP/1.1 400 Bad Request", true, 400);
	// 	print exit_error( false, 3, $res->errorInfo()[2] );
	// 	exit();
	// }
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