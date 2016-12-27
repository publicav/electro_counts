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

$sq  = "SELECT n_counter, name FROM  count  WHERE (id = " . $get_prog['counter'] . ");";
if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $N_counter = $row['n_counter'];				
    }
    $res->free();
} else {
       header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error № counter ');
    exit();
}


$sq  = "SELECT main.value FROM  counter_v AS main 
        WHERE (main.n_counter = ?) AND (main.id_counter = ?)
        ORDER BY date_create DESC LIMIT 1
        ;";
$res = $pdo->prepare( $sq );
 if ($res->execute( [ $N_counter, $get_prog['counter'] ] )) {
    while ($row = $res->fetch()) $value1 = $row;
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo() );
    exit();
}
if  ( !isset($value1) ) $value1['value'] = '';
$result = array('success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$value1);
print json_encode($result);
?>