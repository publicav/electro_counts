<?php
mb_internal_encoding('UTF-8');
include_once "models/json/AutoloadBase.php";
try {
    include_once("models/open.php");
    include_once("models/config.php");
    include_once("models/funclib.php");


    $Full_Page_Name = 'help';
    $head = include_h("views/head.tpl");

    if ($sid == 0) {
        $menu_json = include_h("models/json/menu.json");
        include("models/admin_main_d.php");
        include("views/help_v.php");
    } else {
        $menu_json = include_h("models/json/menu_registration.json");
        //	$menu_left_json = include_h("models/json/menu_left.json");
        include("models/admin_main_d.php");
        include("views/help_v.php");

    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>