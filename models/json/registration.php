<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

if (isset($_POST['username'])) $username = $_POST['username'];
else {
	header("HTTP/1.1 400 Bad Request", true, 400);
	print exit_error( false, 3, 'Ошибка данных' );
	exit();
};

if (isset($_POST['password'])) $password = $_POST['password'];
else {
        header("HTTP/1.1 400 Bad Request", true, 400);
        print exit_error( false, 3, 'Ошибка данных' );
        exit();
};

$md5 = sha1(md5(md5($password).$keys1.$username));
$sq = "SELECT id, users, name, family FROM users WHERE (users = ?) AND (password = ?)";
$msg = 'зарегистрирован';


    $res = $pdo->prepare( $sq );
    if ( $res->execute( [$username, $md5] )) {
        while ($row = $res->fetch()) {
            $id = $row['id'];
            $users = $row['users'];
            $type['success'] = true;
            $type['id'] = $id;
            $type['name'] = $row['name'];
            $type['family'] = $row['family'];
            $type['message'] = $users . ' ' . $msg;
            $_SESSION['sid']= $id; //      session_start(); вызывается в open.php
        }
		if (isset($type)) echo json_encode($type); 
		else { 
			header("HTTP/1.1 400 Bad Request", true, 400);		
			echo exit_error(false, 1, 'Ошибка регистрации'); 
			exit();
		}	
    } else {
        header("HTTP/1.1 400 Bad Request", true, 400);
        print exit_error( false, 3, $res->errorInfo()[2] );
        exit();
    }
