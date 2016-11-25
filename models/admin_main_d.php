<?php
	
$menu_m = json_menu2array($menu_json);

if ($sid>0)
{
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
                        $menu_left_m[] = $row; break;
                    }    
                }
            }
            $res->free();
        }
}

$sq = "SELECT m.title, m.meta_k, m.meta_d FROM adm_main_struct AS m WHERE (m.name='".$Full_Page_Name."') AND (id_lang = ".$config['LANG'].");";
    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $conf_h[] = $row;              
        }
        $res->free();
    }
     
for($i=0;$i<SizeOf($conf_h);$i++) 
{
    foreach ($conf_h[$i] as $key => $value) 
    {
        $head = str_replace(':'.$key.':', $value , $head);
    }	
}

$sq = "SELECT name, family FROM users WHERE (id='" . $sid . "');"; 
if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $user = $row;              
    }
    $res->free();
}
?>

	