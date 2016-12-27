<?php
mb_internal_encoding('UTF-8'); 
include_once("models/open.php");
include_once("models/config.php");
include_once("models/funclib.php");
include_once('models/json_e.php');

foreach ($_GET as $key => $value) 
{
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);

    $get_prog[$key] = $value;
}

if(isset($get_prog['st'])) 
{
    $position_in = intval($get_prog['st']);
    $put_js['st'] = $position_in;
    $select=1;
} else {$position_in=0;$select=1;}

if(isset($get_prog['id_lot'])) 
{
    $id_lot = intval($get_prog['id_lot']);
    $put_js['id_lot'] = $id_lot;

    $select=2;
    if ($id_lot == 0) $select=1;
} else $id_lot = 0;

if(isset($get_prog['id_sub']) and ($select == 2)) 
{
    $id_sub = intval($get_prog['id_sub']);
    $put_js['id_sub'] = $id_sub;
    $select=3;
} else $id_sub = 0;

if(isset($get_prog['id_counter']) and ($select == 3)) 
{
    $id_counter = intval($get_prog['id_counter']);
    $put_js['id_counter'] = $id_counter;		
    $select=4;
} else $id_counter = 0;

if(isset($get_prog['date_b'])) 
{
    $date_b = $get_prog['date_b'];
    $put_js['date_b'] = $date_b;		
} else $date_b = '';


if(isset($get_prog['date_e'])) 
{
    $date_e = $get_prog['date_e'];
    $put_js['date_e'] = $date_e;		
} else $date_e = '';

$st = range_time_day($date_b, $date_e);
$st_navigator = cmd_page_navigator($date_b, $date_e);

$url_search_action =  "view_count.php";
$Full_Page_Name  = 'view_count';
$visibly = 0;
$head=include_h("views/head.tpl");
if ($sid == 0) {
    $menu_json = include_h("models/json/menu.json");
    include("models/edit_count_d.php");
    include("views/blank_v.php");
} else {
    $menu_json = include_h("models/json/menu_registration.json");
//    $menu_left_json = include_h("models/json/menu_left.json");
    include("models/calc_count_d.php");
    include("views/calc_count_v.php");
}
exit();
?>