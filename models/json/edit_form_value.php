<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");

$filter = new \filter\FilterInput( $_GET );
$id = $filter->getInt('id');

$sq =  "SELECT main.id AS id, lot.id AS lot_id, sub.id AS sub_id, cnt.id AS counter_id, cnt.name AS counter, 
                DATE_FORMAT(main.date_create, '%d-%m-%Y' ) AS date1, DATE_FORMAT(main.date_create, '%H:%i' ) AS time1 ,main.value AS value,
                sub.name AS substation, lot.name AS lot
        FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot
        WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (main.id = :id)
        ";

$param = array('id' => $id);
$res = $pdo->prepare( $sq );
 if ( !$res->execute( $param ) ) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
while ($row = $res->fetch()) $editCounter = $row;

$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $editCounter;
echo json_encode($type);


	