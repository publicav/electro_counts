<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once "Autoload.php";
 
$st_sql = '';
$st_page = '';
$name_counter = '';

$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];
$url_search_action = $url . '.php';

$counter = array();

	$filter = new \filter\FilterInput( $_GET );
	$get_prog = $filter->getInputAll();
	
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

if(isset($get_prog['id_counter'])) {
	$id_counter = intval($get_prog['id_counter']);
	$put_js['id_counter'] = $id_counter;		
	$select=4;
	if ($id_counter == 0) $select=3;
} else $id_counter = 0;



if(!isset($get_prog['id_counter'])) {
	$type['success'] = true;
	$type['id_error'] = 0;
	$type['data'] = [];
	echo json_encode($type);
	exit();
}


if(isset($get_prog['date_b'])) {
	$date_b = $get_prog['date_b'];
//	$put_js['date_b'] = $date_b;		
} else $date_b = '';


if(isset($get_prog['date_e'])) {
	$date_e = $get_prog['date_e'];
	// $put_js['date_e'] = $date_e;		
} else $date_e = '';
// if(!empty($get_prog['date_b'])) {

// }


$dateSql = new date\rangeDateSql( $date_b, '');
$rangeSql = $dateSql->getSQL( 'date_create' );

$getCount = new pdo\getCounts($pdo, ['id' => $id_counter] );
$test = $getCount->getCountAll();
var_dump($test);

$sq  = "SELECT c.id, c.n_counter, c.name FROM  count AS c WHERE (c.id = :id);";
$res = $pdo->prepare( $sq );
$param = ['id' => $id_counter] ;

 if (!$res->execute( $param )) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
$counts_count = $res->fetchAll();

if (empty( $counts_count )) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
} else {
	$name_counter = $counts_count[0]['name'];
	unset( $counts_count[0]['name'] );
}

$sq  = "SELECT x.koef, x.n_counter  FROM	xchange AS x WHERE (x.id_counter = :id) AND (x.n_counter = :n_counter);";
$res = $pdo->prepare( $sq );


 if ($res->execute( $counts_count[0] )) {
    while ($row = $res->fetch()) $koefPower[$row['n_counter']] = $row['koef'];
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}

// print_r($koefPower['koef']);


  switch( $select ){
    case 1:
		if ($st != '') {
			$st_sql = ' AND ' . $st; 
			$st_page = 'WHERE ' . $st; 
		}	
		// $sq =  "SELECT cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   // sub.name AS substation, lot.name AS lot
				// FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				// WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND 
					  // (sub.lots = lot.id)  $st_sql
				// ORDER by date1
				// LIMIT $position_in, " . $config['PAGE_COUNTER'] .";"; 
		// $page_out = Page($position_in, "SELECT main.id FROM counter_v AS main $st_page;");
		// $navigator = navigator($url_search_action, $page_out, $st_navigator);
		// print_r($sq);
    break;
    case 2:
		if ($st != '') $st_sql = ' AND ' . $st; 
		// $sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   // sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				// FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				// WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND 
						// (sub.lots = lot.id) AND (main.id_users = users.id) AND (lot.id = " . $id_lot . ") $st_sql
				// ORDER by date1
				// LIMIT $position_in, " . $config['PAGE_COUNTER'] .";"; 
		// $page_out = Page($position_in,"SELECT main.id FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
									   // WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (lot.id = " . $id_lot . ") $st_sql;");
		// $navigator = navigator($url_search_action,$page_out,'&id_lot=' . $id_lot . $st_navigator);
		// print_r($sq);
	
    break;
    case 3:
		if ($st != '') $st_sql = ' AND ' . $st; 
		// $sq =  "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, main.value AS value,
					   // sub.name AS substation, lot.name AS lot, concat( users.name, ' ', users.family) AS name_user
				// FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				// WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND
					  // (main.id_users = users.id) AND	(lot.id = " . $id_lot . ") AND (sub.id = " . $id_sub . ") $st_sql
				// ORDER by date1
				// LIMIT $position_in, " . $config['PAGE_COUNTER'] .";"; 
		// $page_out = Page($position_in,"SELECT main.id FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
									   // WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (lot.id = " . $id_lot . ")  AND (sub.id = " . $id_sub . ") $st_sql;");
		// $navigator = navigator($url_search_action,$page_out,'&id_lot=' . $id_lot . '&id_sub=' . $id_sub . $st_navigator);
    break;
    case 4:
		$rangeSql = ' AND ' . $rangeSql;
		$sq =  "SELECT main.id,  DATE_FORMAT(main.date_create, '%d-%m-%Y %H:%i:%s' ) AS date1,  main.value AS value,
				UNIX_TIMESTAMP(main.date_create)  AS date_second, main.date_create AS dt1, main.n_counter
				FROM counter_v AS main
				WHERE (main.id_counter = :id_counter) $rangeSql
				ORDER by date_create;"; 
		$navigationcalc = new \navigation\NavigationCalc( $url_search_action, $date_b, $put_js );
		$navigationcalc->classHTML = ['navigator', 'pagelink', 'pagecurrent'];
		$navigator = $navigationcalc->getNavigator();

    break;
    default:
  }
  
  if ($sq == '') {
		$type['success'] = true;
		$type['id_error'] = 0;
		$type['data'] = [];
		echo json_encode($type);
		exit();
  }
  
$firstLoop = 0;
$timeNew = 0;
$timeEnd =0;
$valueNew =0; 
$diffTime =0; 
$diffMinuteVal = 0;
$date1 = 0;
$rateBefore = 0;
$rateAfter = 0;
$count = 0;
$day = 0;
$rare = 0;
$period = 0;
$round = 3;

$res = $pdo->prepare( $sq );
$param = array( 'id_counter' => $id_counter );

if (!$res->execute( $param )) {
	header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
while ($row = $res->fetch()) {
	if ( $firstLoop > 0 ) {
		$dt2 = $row['dt1'];
		$dtMinuteEnd = new DivisionDay( $dt2 );
		$day = date("d-m-Y", strtotime( $dt1 ));
		
		$timeEnd = $row['date_second'];
		$diffTime  =  round ( ( $timeEnd - $timeNew ) / 60 );
		$diffValue = ( $row['value'] - $valueNew ) * $koefPower[$row['n_counter']];
		$diffMinuteVal = $diffValue / $diffTime;
		
		if ( $count > 0 ) {
			$rateAfter = $diffMinuteVal * $dtMinuteNew->minuteAfter;
			$rare = $rateBefore + $rateAfter;
			$counter[] = array('name_counter' => $name_counter, 'date' => $day, 'rare' => round( $rare, $round) );
		}	
		if ( $diffTime > 1440 ) {
			$periodObj = new PeriodDay ($dt2, $dt1, $diffMinuteVal, $name_counter );
			foreach( $periodObj->day as $colum ) $counter[] = $colum;
		} 
		$rateBefore = $diffMinuteVal * $dtMinuteEnd->minuteBefore ;
		$count++;
	}	
	$timeNew = $row['date_second'];
	$valueNew =  $row['value'] ;
	$dt1 = $row['dt1'];
	$dtMinuteNew = new DivisionDay ( $dt1 );
	$firstLoop = 1;
}	

// if (!isset($counter)) {
    // header("HTTP/1.1 400 Bad Request", true, 400);
    // print exit_error( false, 3, 'Данные отсутствуют' );
    // exit();
// }


$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $counter;
$type['navigator'] = $navigator;

echo json_encode($type);
?>

	