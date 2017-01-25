<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_POST );
$get_prog = $filter->getInputAll();


if (isset( $get_prog['id_user'] )) $id_user = (int)$get_prog['id_user']; else
{
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input users ');
    exit();
}
   
if ( $sid >0 ) {
    $sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = ?)";
    $res = $pdo->prepare( $sq );
    if ( $res->execute( [$id_user] ) ) {
        while ($row = $res->fetch()) $priv[] = $row;
    } else {
        header("HTTP/1.1 400 Bad Request", true, 400);
        print exit_error( false, 3, $res->errorInfo()[2] );
        exit();
    }
}

// if (!isset( $priv )) {
    // header("HTTP/1.1 400 Bad Request", true, 400);    
    // echo exit_error(false, 1, 'Error input users ' . $id_user);
    // exit();
// }

$sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu, m.name AS name, m.url AS url FROM menu_left AS m;"; 
if ($res = $pdo->query( $sq )) {
	while ($row = $res->fetch()) {
		for($i = 0; $i < SizeOf( $priv ); $i++) {
			if (($row['id_menu'] == $priv[$i]['id_menu']) AND ($priv[$i]['visibly'] == 1)) {
			   $row['checked'] = 'checked="checked"'; break;
			}    
		}
		$menu_left_m[] = $row;
	}     
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}

print json_encode($menu_left_m);
?>