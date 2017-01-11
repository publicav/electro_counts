<?php
$st_sql = '';
$st_page ='';
$menu_m = json_menu2array($menu_json);
	
if ( $sid > 0) {
    $sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = $sid)";
        if ($res = $db_li->query($sq)) {
            while ($row = $res->fetch_assoc()) {
                $priv[] = $row;              
            }
            $res->free();
        }
    $sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);"; 
        if ($res = $db_li->query($sq)) {
            while ($row = $res->fetch_assoc()) {
                for($i=0;$i<SizeOf($priv);$i++)
                {
                    if (($row['id_menu'] == $priv[$i]['id_menu']) AND ($priv[$i]['visibly'] == 1)) 
                    {
                        if ($row['id_a'] == $Full_Page_Name) $visibly = 1;
                        $menu_left_m[] = $row; break;
                    }    
                }
            }
            $res->free();
        }
}

$currentPage = new GetNamePage( $pdo, $Full_Page_Name, $config['LANG'] );
$head = $currentPage->get_head( $head );
    
$sq  = "SELECT l.id, l.name FROM  lots AS l;";
$lots[] = Array('id' => '0','name' => 'Все участки');

$res = $pdo->prepare( $sq );
if ($res->execute( $param )) {
	while ($row = $res->fetch()) {
		$lots[] = $row;
	}
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}
   	
 $name = new GetUser( $pdo, $sid );
 $user = $name->user;
	
?>

	