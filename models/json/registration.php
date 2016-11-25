<?php
include_once("../open.php");
include_once("../json_e.php");
include_once("../funclib.php");

mb_internal_encoding('UTF-8');

if (isset($_POST['username'])) $username = $_POST['username'];
else {
    echo exit_error(false, 1, 'Ошибка данных');
    exit();
};

if (isset($_POST['password'])) $password = $_POST['password'];
else {
    echo exit_error(false, 1, 'Ошибка данных');
    exit();
};

$md5 = sha1(md5(md5($password).$keys1.$username));
$sq = "SELECT id, users, name, family FROM users WHERE (users = '$username') AND (password = '" . $md5 . "')";
$msg = 'зарегистрирован';

    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $id = $row['id'];
            $users = $row['users'];
            $type['success'] = true;
            $type['id'] = $id;
            $type['name'] = $row['name'];
            $type['family'] = $row['family'];
            $type['message'] = $users . ' ' . $msg;
            $_SESSION['sid']= $id; //      session_start(); вызывается в open.php
        }
		if (isset($type)) echo json_encode($type); else  echo exit_error(false, 1, 'Ошибка регистрации'); 
        $res->free();
    } else {
		echo exit_error(false, 3, 'Error mysql');
        exit();
    }
?>