<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$N_counter = 1;
foreach ($_POST as $key => $value) {
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $get_prog[$key] = $value;
}    

if (isset($get_prog['counter'])) $counter = (int)$get_prog['counter']; else
{
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input counter ');
    exit();
} 

$sq  = "SELECT n_counter FROM  count  WHERE (id = :id);";

$param = array( 'id' => $get_prog['counter'] );	

$res = $pdo->prepare( $sq );
 if ($res->execute( $param )) {
	 $N_counter = $res->fetchAll();
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}

$sq  = "SELECT main.value FROM  counter_v AS main 
        WHERE (main.n_counter = :n_counter) AND (main.id_counter = :id_counter)
        ORDER BY date_create DESC LIMIT 1
        ;";
$param = array( 'n_counter' => $N_counter[0]['n_counter'], 'id_counter' => $get_prog['counter']	);	
$res = $pdo->prepare( $sq );
 if ($res->execute( $param )) {
	 $value1 = $res->fetchAll();
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
if  ( !isset($value1) ) $value1['value'] = '';
$result = array('success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$value1[0], 'counter' => $N_counter[0] );
print json_encode($result);
?>