<?php
    include_once("../open.php");
    include_once("../config.php");
    include_once("../funclib.php");


	$url_search_action =  "edit_count.php";

    foreach ($_GET as $key => $value) 
    {
      $key = filter_var($key, FILTER_SANITIZE_STRING);
      $value = filter_var($value, FILTER_SANITIZE_STRING);
	  $get_prog[$key] = $value;
    }    
	
	if(isset($get_prog['id'])) 
    {
        $id = intval($get_prog['id']);
		$select=1;
    } else {$id = 0; $select = 1;}
	// print_r($get_prog['st']);


switch($select){
case 1:
    $sq =  "SELECT main.id AS id, lot.id AS lot_id, sub.id AS sub_id, cnt.id AS counter_id, cnt.name AS counter, 
                    DATE_FORMAT(main.date_create, '%d-%m-%Y' ) AS date1, DATE_FORMAT(main.date_create, '%H:%i' ) AS time1 ,main.value AS value,
                    sub.name AS substation, lot.name AS lot
            FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot
            WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (main.id = '" . $id . "')
            "; 
    // print_r($sq);
break;
default:

}


if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $editCounter = $row;
    }
    $res->free();
}
	
$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $editCounter;
echo json_encode($type);
   
?>

	