<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

if (isset($_GET['data'])) $substation = $_GET['data']; else
{
    $result['success'] = false;
    $result['id_error'] = 1;
    $result['error'] = 'Error input data';
    echo json_encode($result);
    exit();
} 

$sq  = "SELECT c.id, c.name
        FROM  count AS c
        WHERE (c.substations = " . $substation .");";


if ($res = $db_li->query($sq)) {
    while ($row = $res->fetch_assoc()) {
        $counts_count[] = $row;              
    }
    $res->free();
}

$result = array('type'=>'success', 'data'=>$counts_count);
print json_encode($result);

?>