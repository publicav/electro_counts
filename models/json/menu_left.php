<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
	
if ($sid>0)
{
    $sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = $sid)";
        if ($res = $db_li->query($sq)) {
            while ($row = $res->fetch_assoc()) {
                $priv[] = $row;              
            }
            $res->free();
        }
    if (isset($priv)) {    
    $sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);"; 
        if ($res = $db_li->query($sq)) {
            while ($row = $res->fetch_assoc()) {
                for($i=0; $i < SizeOf($priv); $i++)
                {
                    if (($row['id_menu'] == $priv[$i]['id_menu']) AND ($priv[$i]['visibly'] == 1)) 
                    {
                        $menu_left_m[] = $row; break;
                    }    
                }
            }
            $res->free();
        }
    }   
}
    print json_encode($menu_left_m);
?>