<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");


$url = $_SERVER['REQUEST_URI'];
$route = \Navigation\Route::init();
$id_users = $route->getAuthorization();

	
$N_counter = 1;  		// Важный параметр пока не работает номер счётчика в ячейке !!!! убрать когда всё заработает

	$filter = new \Filter\FilterInput( $_POST );
	$get_prog = $filter->getInputAll();
	
	
$name_lot = validator_input_sql('lots', $get_prog['lot']);
$name_substation = validator_input_sql('substation', $get_prog['substation']);
//$name_count = validator_input_sql('count', $get_prog['counter']);


$sq  = "SELECT n_counter, name FROM  count  WHERE (id = :id );";
$param = array ('id' => $get_prog['counter'] ); 
$res = $pdo->prepare( $sq );
if ($res->execute( $param )) {
	$infoCount = $res->fetchAll(); 
} else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, $res->errorInfo()[2] );
	exit();
}

if ( !empty($infoCount) ) {
	$name_count = $infoCount[0]['name'];
	$N_counter = $infoCount[0]['n_counter'];				
}

if (!isset($name_lot)) { 
	echo exit_error(false, 2, 'Error input select lots');
	exit();
}
if (!isset($name_substation)) {
	echo exit_error(false, 2, 'Error input select substation ');	
	exit();
}
if (!isset($name_count)) {
	echo exit_error(false, 2, 'Error input select counter');	
	exit();
}
if ( $id_users == 0 ) {
	echo exit_error(false, 2, 'Error user not found');	
	exit();
}
	
if ($get_prog['counter_val'] == '') {
	echo exit_error(false, 2, 'Error input value counter');	
	exit();
}

$get_prog['counter_val'] = str_replace(',', '.', $get_prog['counter_val']);
// это у нас на тот случай, если введена хрень
$get_prog['counter_val'] = floatval($get_prog['counter_val']);

$date_create = datetime_sql($get_prog['date_begin'], $get_prog['time_begin']);
if ($date_create == '') {
	echo exit_error(false, 4, 'Error input date time');	
	exit();
}
if ($get_prog['actions'] == 'add'){

    $sq  = "SELECT id FROM  counter_v  
			WHERE (n_counter = :n_counter) AND (id_counter = :id_counter) AND (date_create = :date_create);";
				  
	$param = array ('n_counter' => $N_counter, 'id_counter' => $get_prog['counter'], 'date_create' => $date_create ); 
	$res = $pdo->prepare( $sq );
	if ($res->execute( $param )) {
		while ($row = $res->fetch()) {
            $id_dupl = $row['id'];
		}
	} else {
		header("HTTP/1.1 400 Bad Request", true, 400);
		print exit_error( false, 3, $res->errorInfo()[2] );
		exit();
	}
			
	if (isset($id_dupl)) {
		echo exit_error(false, 2, 'Error, Дублирующая запись');	
		exit();
	}
	
	$sq = "INSERT INTO counter_v (n_counter, id_counter, id_users, value,  date_create) 
		   VALUES (:n_counter , :id_counter, :id_users, :value, :date_create);";

	$param = array ('n_counter' => $N_counter, 'id_counter' => $get_prog['counter'], 'id_users' => $id_users, 
			'value' => $get_prog['counter_val'], 'date_create' => $date_create ); 
			
	$res = $pdo->prepare( $sq );
	if (!$res->execute( $param )) {
		header("HTTP/1.1 400 Bad Request", true, 400);
		print exit_error( false, 3, $res->errorInfo()[2] );
		exit();
	}
	$id_add = $pdo->lastInsertId();
}
if ($get_prog['actions'] == 'edit'){
	$sq = "UPDATE counter_v  
		   SET n_counter = :n_counter, id_counter = :id_counter, id_users = :id_users, value = :value , date_create = :date_create
		   WHERE (id = :id );";

	$param = array ('n_counter' => $N_counter, 'id_counter' => $get_prog['counter'], 'id_users' => $id_users, 
					'value' => $get_prog['counter_val'], 'date_create' => $date_create, 'id' => $get_prog['edit_id'] ); 
			
	$res = $pdo->prepare( $sq );
	if (!$res->execute( $param )) {
		header("HTTP/1.1 400 Bad Request", true, 400);
		print exit_error( false, 3, $res->errorInfo()[2] );
		exit();
	}
	$id_add = $get_prog['edit_id'];
}
	
$data = Array("id" => $id_add, "lot" => $get_prog['lot'], "substation" => $get_prog['substation'], "counter" => $get_prog['counter'],
								"name_lot" => $name_lot, "name_substation" => $name_substation, "name_counter" => $name_count, 
								"date" => $get_prog['date_begin'], "time" => $get_prog['time_begin'], "id_users" => $id_users,
								"value" => $get_prog['counter_val']);
$type['success'] = true;
$type['id_error'] = 0;
$type['error'] = '';
$type['data'] = $data;
echo json_encode($type);
?>