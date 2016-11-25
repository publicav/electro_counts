<?php
include_once("../open.php");
include_once("../config.php");
include_once("../json_e.php");
include_once("../funclib.php");

mb_internal_encoding('UTF-8'); 
    
if (isset($_POST['actions'])) $action = $_POST['actions']; 
if (isset($_POST['table'])) $table = $_POST['table']; 
	
foreach ($_POST as $key => $value) 
{
	$key = filter_var($key, FILTER_SANITIZE_STRING);
	$value = filter_var($value, FILTER_SANITIZE_STRING);
	$get_prog[$key] = $value;
}    

if  ($action == 'add') {
	if ((strlen($get_prog['user_add']) <=  3) OR (strlen($get_prog['user_add']) >  11)) { 
		echo exit_error(false, 2, 'Длина логина меньше 3 или больше 11');
		exit();
	}
	$user_id = validator_user($get_prog['user_add']);
	if (isset($user_id)) { 
		echo exit_error(false, 2, 'Такой пользователь существует');
		exit();
	}
	if ( $get_prog['pass_add'] !=  $get_prog['pass_repeat_add']) { 
		echo exit_error(false, 2, 'Пароли не совпадают');
		exit();
	}
	if ( strlen($get_prog['pass_add']) <=  $config['LEN_PASS']) { 
		echo exit_error(false, 2, 'Длина пароля меньше ' .  $config['LEN_PASS']);
		exit();
	}
	if ( strlen($get_prog['family_add']) ==  '') { 
		echo exit_error(false, 2, 'Отсутствует Фамилия пользователя ');
		exit();
	}
	if ( strlen($get_prog['name_add']) ==  '') { 
		echo exit_error(false, 2, 'Отсутствует Имя пользователя ');
		exit();
	}

	$md5 = sha1(md5(md5($get_prog['pass_add']) . $keys1 . $get_prog['user_add']));		
			
	$sq = "INSERT INTO users (users, password, name, family,  ring) 
			VALUES ('" . $get_prog['user_add'] . "' ,'" . $md5 . "', '" .  $get_prog['name_add'] . "', '" . $get_prog['family_add'] . "','" .  $config['RING'] ."');";
	$msg = 'Пользователь ' . $get_prog['name_add'] .  ' добавлен';        
	
}

if  ($action == 'edit') {
	if ((strlen($get_prog['user_edit']) <=  3) OR (strlen($get_prog['user_edit']) >  11)) { 
		echo exit_error(false, 2, 'Длина логина меньше 3 или больше 11');
		exit();
	}
	if ( $get_prog['pass_edit'] !=  $get_prog['pass_repeat_edit']) { 
		echo exit_error(false, 2, 'Пароли не совпадают');
		exit();
	}
	if ( strlen($get_prog['pass_edit']) <=  $config['LEN_PASS']) { 
		echo exit_error(false, 2, 'Длина пароля меньше ' .  $config['LEN_PASS']);
		exit();
	}
	if ( strlen($get_prog['family_edit']) ==  '') { 
		echo exit_error(false, 2, 'Отсутствует Фамилия пользователя ');
		exit();
	}
	if ( strlen($get_prog['name_edit']) ==  '') { 
		echo exit_error(false, 2, 'Отсутствует Имя пользователя ');
		exit();
	}
	$md5 = sha1(md5(md5($get_prog['pass_edit']) . $keys1 . $get_prog['user_edit']));

	$sq = "UPDATE users  
			SET users = '" . $get_prog['user_edit'] . "' ,password = '" . $md5 . "',name = '" . $get_prog['name_edit'] . "', family = '" . $get_prog['family_edit'] . "', ring = '" . $config['RING'] . "'
			WHERE (id = '" . $get_prog['edit_user_id'] . "');";

	$msg = 'Пользователь ' . $get_prog['name_edit'] .  ' изменён';        

}

if ($res = $db_li->query($sq)) {
} else {
	$type['success'] = false;
	$type['id_error'] = 3;
	$type['error'] = $db_li->error;
	echo json_encode($type);
	exit();
}
$type['id_error'] = 0;
$type['success'] = true;
$type['message'] = ' ' . $msg;
echo json_encode($type);
?>