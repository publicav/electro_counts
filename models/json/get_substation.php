<?php
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");
include_once("../regv.php");

	
if (isset($_GET['data'])) $lot = $_GET['data']; else
{
    $result['success'] = false;
    $result['id_error'] = 1;
    $result['error'] = 'Error input data';
    echo json_encode($result);
    exit();
} 

$sq  = "SELECT s.id, s.name
        FROM  substation AS s
        WHERE (s.lots = " . $lot .");";

    if ($res = $db_li->query($sq)) {
        while ($row = $res->fetch_assoc()) {
            $counts_lot[] = $row;
        }
        $res->free();
    }
$result = array('type'=>'success', 'data'=>$counts_lot);
/*
 * Упаковываем данные с помощью JSON
 */
print json_encode($result);

?>