<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once("../regv.php");

$url = $_SERVER['REQUEST_URI'];
	
$N_counter = 1;  		// Важный параметр пока не работает номер счётчика в ячейке !!!! убрать когда всё заработает
	
foreach ($_POST as $key => $value) 
{
      $key = filter_var($key, FILTER_SANITIZE_STRING);
      $value = filter_var($value, FILTER_SANITIZE_STRING);
	$get_prog[$key] = $value;
}    
	
$name_lot = validator_input_sql('lots', $get_prog['lot']);
$name_substation = validator_input_sql('substation', $get_prog['substation']);
//$name_count = validator_input_sql('count', $get_prog['counter']);
$id_users = $sid;   // Регистрация

    $sq  = "SELECT n_counter, name FROM  count  WHERE (id = " . $get_prog['counter'] . ");";
    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $name_count = $row['name'];
			$N_counter = $row['n_counter'];				
        }
        $res->free();
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
if ($sid == 0) {
	echo exit_error(false, 2, 'Error user not found');	
	exit();
}
	
if ($get_prog['counter_val'] == '') {
	echo exit_error(false, 2, 'Error input value counter');	
	exit();
}

str_replace(',', '.', $get_prog['counter_val']);
// это у нас на тот случай, если введена хрень
$get_prog['counter_val'] = floatval($get_prog['counter_val']);

$date_create = datetime_sql($get_prog['date_begin'], $get_prog['time_begin']);
if ($date_create == '') {
	echo exit_error(false, 4, 'Error input date time');	
	exit();
}
if ($get_prog['actions'] == 'add'){

    $sq  = "SELECT id FROM  counter_v  
			WHERE (n_counter = '" . $N_counter . "') AND (id_counter = '" . $get_prog['counter'] . "') AND
				  (date_create = '" . $date_create . "');";
			$sqsel = $sq;
    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $id_dupl = $row['id'];
        }
        $res->free();
    }
	
	if (isset($id_dupl)) {
		echo exit_error(false, 2, 'Error, Дублирующая запись');	
		exit();
	}
	
	
	$sq = "INSERT INTO counter_v (n_counter, id_counter, id_users, value,  date_create) 
			VALUES ('" . $N_counter . "' ,'" . $get_prog['counter'] . "', '" . $id_users . "', '" . $get_prog['counter_val'] . "','" .  $date_create ."');";

    if ($res = $db_li->query($sq)) {
       
    } else {
		echo exit_error(false, 3,  $db_li->error);
		exit();
	}	
	 $id_add = $db_li->insert_id;
}
if ($get_prog['actions'] == 'edit'){
	$sq = "UPDATE counter_v  
			SET n_counter = '" . $N_counter . "' ,id_counter='" . $get_prog['counter'] . "',id_users = '" . $id_users . "', value = '" . $get_prog['counter_val'] . "', date_create = '" . $date_create . "', date_create = ' " . $date_create . "'
			WHERE (id = '" . $get_prog['edit_id'] . "');";

    if ($res = $db_li->query($sq)) {
       
    } else {
		echo exit_error(false, 3, $db_li->error);
		exit();
	}	

		$id_add = $get_prog['edit_id'];
}
	
$data = Array("id" => $id_add, "lot" => $get_prog['lot'], "substation" => $get_prog['substation'], "counter" => $get_prog['counter'],
								"name_lot" => $name_lot, "name_substation" => $name_substation, "name_counter" => $name_count, 
								"date" => $get_prog['date_begin'], "time" => $get_prog['time_begin'], "id_users" => $sid,
								"value" => $get_prog['counter_val']);
$type['success'] = true;
$type['id_error'] = 0;
$type['error'] = $sqsel;
$type['data'] = $data;
echo json_encode($type);
?>