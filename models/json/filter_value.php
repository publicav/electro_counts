<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$st_sql = '';
$st_page = '';


$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];

$counter = array();
foreach ($_GET as $key => $value) 
{
	$key = filter_var($key, FILTER_SANITIZE_STRING);
	$value = filter_var($value, FILTER_SANITIZE_STRING);
	
	$get_prog[$key] = $value;
}    

//$url_search_action = "edit_count.php";
$url_search_action = $url . '.php';

	
if(isset($get_prog['st'])) {
	$position_in = intval($get_prog['st']);
	$put_js['st'] = $position_in;
	$select=1;
} else {$position_in=0;$select=1;}

if(isset($get_prog['id_lot'])) {
	$id_lot = intval($get_prog['id_lot']);
	$put_js['id_lot'] = $id_lot;

	$select=2;
	if ($id_lot == 0) $select=1;
} else $id_lot = 0;

if(isset($get_prog['id_sub']) and ($select == 2)) {
	$id_sub = intval($get_prog['id_sub']);
	$put_js['id_sub'] = $id_sub;
	$select=3;
	if ($id_sub == 0) $select=2;
} else $id_sub = 0;

if(isset($get_prog['id_counter']) and ($select == 3)) {
	$id_counter = intval($get_prog['id_counter']);
	$put_js['id_counter'] = $id_counter;		
	$select=4;
	if ($id_counter == 0) $select=3;
} else $id_counter = 0;

if(isset($get_prog['date_b'])) {
	$date_b = $get_prog['date_b'];
	$put_js['date_b'] = $date_b;		
} else $date_b = '';


if(isset($get_prog['date_e'])) {
	$date_e = $get_prog['date_e'];
	$put_js['date_e'] = $date_e;		
} else $date_e = '';
$dateRange = range_time_day($date_b, $date_e);
$st_navigator = cmd_page_navigator($date_b, $date_e);


  switch($select){
    case 1:
		if ($dateRange != '') {
			$st_sql = ' AND ' . $dateRange; 
			$st_page = 'WHERE ' . $dateRange; 
		}	
		$sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND 
					  (sub.lots = lot.id) AND (main.id_users = users.id)  $st_sql
				ORDER by date_create
				LIMIT :position_in, :total_col;"; 
		$page_out = Page($position_in, "SELECT main.id FROM counter_v AS main $st_page;");
		$navigator = navigator($url_search_action, $page_out, $st_navigator);
		$param = array ('position_in' => $position_in, 'total_col' => $config['PAGE_COUNTER'] ); 
		// print_r($sq);
    break;
    case 2:
		if ($dateRange != '') $st_sql = ' AND ' . $dateRange; 
		$sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND 
						(sub.lots = lot.id) AND (main.id_users = users.id) AND (lot.id = :id_lot) $st_sql
				ORDER by date_create
				LIMIT :position_in, :total_col;"; 
		$page_out = Page($position_in,"SELECT main.id FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
									   WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (lot.id = " . $id_lot . ") $st_sql;");
		$navigator = navigator($url_search_action,$page_out,'&id_lot=' . $id_lot . $st_navigator);
		$param = array ('position_in' => $position_in, 'total_col' => $config['PAGE_COUNTER'], 'id_lot' => $id_lot); 
		// print_r($sq);
	
    break;
    case 3:
		if ($dateRange != '') $st_sql = ' AND ' . $dateRange; 
		$sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND
					  (main.id_users = users.id) AND	(lot.id = :id_lot) AND (sub.id = :id_sub) $st_sql
				ORDER by date_create
				LIMIT :position_in, :total_col;"; 
		$page_out = Page($position_in,"SELECT main.id FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
									   WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (lot.id = " . $id_lot . ")  AND (sub.id = " . $id_sub . ") $st_sql;");
		$navigator = navigator($url_search_action,$page_out,'&id_lot=' . $id_lot . '&id_sub=' . $id_sub . $st_navigator);
		$param = array ('position_in' => $position_in, 'total_col' => $config['PAGE_COUNTER'], 'id_lot' => $id_lot, 'id_sub'=>$id_sub); 
    break;
    case 4:
		if ($dateRange != '') $st_sql = ' AND ' . $dateRange; 
		$sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND 
					  (main.id_users = users.id)  AND (lot.id = :id_lot) AND (cnt.id = :id_counter) $st_sql
				ORDER by date_create
				LIMIT :position_in, :total_col;"; 
		$page_out = Page($position_in,"SELECT main.id FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
									   WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (lot.id = " . $id_lot . ")  AND (sub.id = " . $id_sub . ") AND (cnt.id = " . $id_counter . ") $st_sql;");
		$navigator = navigator($url_search_action,$page_out,'&id_lot=' . $id_lot . '&id_sub=' . $id_sub . '&id_counter=' . $id_counter . $st_navigator);
		$param = array ('position_in' => $position_in, 'total_col' => $config['PAGE_COUNTER'], 'id_lot' => $id_lot, 'id_counter'=>$id_counter); 	
    break;
	
    default:
    
  }


$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
$res = $pdo->prepare( $sq );
if ($res->execute( $param )) {
	while ($row = $res->fetch()) {
		$keyId = 'c'.$row['id'];
		$counter[$keyId] = $row;		
	}
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}
    
$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $counter;
$type['navigator'] = $navigator;
$type['url'] = $url;
echo json_encode($type);

?>

	