<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
	
foreach ($_GET as $key => $value) {
    $key = filter_var($key, FILTER_SANITIZE_STRING);
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    $get_prog[$key] = $value;
}    

if (isset($get_prog['data'])) $substation = (int)$get_prog['data']; else
{
    header("HTTP/1.1 400 Bad Request", true, 400);    
    echo exit_error(false, 1, 'Error input substation ');
    exit();
}

$sq  = "SELECT c.id, c.name FROM  count AS c WHERE (c.substations = ?);";
$counts_count[] = Array('id' => '0','name' => 'Все ячейки');
$res = $pdo->prepare( $sq );
 if ($res->execute( [$substation] )) {
	// $counts_count = $res->fetchAll(); 
    while ($row = $res->fetch()) $counts_count[] = $row;
} else {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo() );
    exit();
}
// $counts_count[] = Array('id' => '0','name' => 'Все ячейки');
$result = array('success'=> true, 'error' => 'Ok', 'id_error' => 0,  'data'=>$counts_count);
print json_encode($result);
?>