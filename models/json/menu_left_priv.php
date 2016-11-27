<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

foreach ($_POST as $key => $value) 
{
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $get_prog[$key] = $value;
}    
$id_user = $get_prog['id_user'];
if ($sid>0)
{
    $sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = $id_user)";
    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $priv[] = $row;              
        }
        $res->free();
    }

}

$sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu, m.name AS name, m.url AS url FROM menu_left AS m;"; 

    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            for($i=0; $i < SizeOf($priv); $i++)
            {
                if (($row['id_menu'] == $priv[$i]['id_menu']) AND ($priv[$i]['visibly'] == 1)) {
                   $row['checked'] = 'checked="checked"'; break;
                }    
            }
            $menu_left_m[] = $row;
        }
        $res->free();
    }

print json_encode($menu_left_m);
?>