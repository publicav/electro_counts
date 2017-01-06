<?php
mb_internal_encoding('UTF-8');
include_once("../open.php");
include_once("../config.php");
include_once("../json_e.php");
include_once("../funclib.php");

$fields = '';
$vars = '';
$privelege_var = '';

foreach ($_POST as $key => $value) 
{
	$key = filter_var($key, FILTER_SANITIZE_STRING);
	$value = filter_var($value, FILTER_SANITIZE_STRING);
	$get_prog[$key] = $value;
}    
$dataCheck = explode(",", $get_prog['data']);

$sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu, m.name AS name, m.url AS url FROM menu_left AS m;"; 

$res = $pdo->prepare( $sq );
if ($res->execute()) {
	$menu_left_m = $res->fetchAll(); 
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}
// print_r($menu_left_m);
for($i = 0; $i < SizeOf($menu_left_m); $i++) {
    $privelege[] = array('id_users' => $get_prog['id_user']  , 'id_menu' => $menu_left_m[$i]['id_menu'], 'visibly' => $dataCheck[$i]);
}
// print_r($privelege);

$sq = "SELECT t_priv.id FROM tables_priv AS t_priv WHERE (t_priv.id_users = :id_users);"; 
$param = array ('id_users' => $get_prog['id_user'] ); 
$res = $pdo->prepare( $sq );
if ($res->execute( $param )) {
	$id_privelege = $res->fetchAll(); 
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}

 
if (!empty($id_privelege)) {
    for($i = 0; $i < SizeOf($privelege); $i++) 
    {
        $privelege_var = 'visibly = ' . $privelege[$i]['visibly'];
        $id = $id_privelege[$i]['id'];
        $sq = "UPDATE tables_priv SET $privelege_var WHERE ( id = $id );";
        if ($res = $db_li->query($sq)) {
        
        } else {
            echo exit_error(false, 3, 'mysql_error()');
            exit();
        }	
        
    }	
} else {
    for($i = 0; $i < SizeOf($privelege); $i++) {
            $count = 0;  
            if ($i == 0)  $vars = "("; else $vars = ",(";        
            foreach ($privelege[$i] as $key => $value) 
            {
            if ($i == 0) if (($count != 0))  $fields .= ',' . $key;  else $fields .= $key;
            if (($count != 0))  $vars .= ','; 
            $vars .= "'" . $value . "'";
            $count++;
        }
        $vars .= ")";
        $privelege_var .=  $vars;
    }	
    $sq = "INSERT INTO tables_priv ( $fields ) VALUES $privelege_var;";
    if ($res = $db_li->query($sq)) {
       
    } else {
		echo exit_error(false, 3, 'mysql_error()');
		exit();
	}	
    
  
}

$type['id_error'] = 0;
$type['success'] = true;
//$type['sql'] = $sq_arr;
echo json_encode($type);
?>