<?php
    mb_internal_encoding('UTF-8'); 
//    include_once("models/lock.php");
    
    include_once("models/open.php");
    include_once("models/config.php");
    include_once("models/funclib.php");
    include_once('models/json_e.php');

	
    // print_r($_SESSION['sid']);
	
    // exit();

    {
    		$Full_Page_Name  = 'main';
		$head=include_h("views/head.tpl");

		if ($sid == 0) {
			$menu_json = include_h("models/json/menu.json");
			include("models/admin_main_d.php");
			include("views/blank_v.php");			
		} else {
			$menu_json = include_h("models/json/menu_registration.json");
//			$menu_left_json = include_h("models/json/menu_left.json");
			include("models/admin_main_d.php");
			include("views/admin_main_v.php");
			
		}

		exit();
    }

?>