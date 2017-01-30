<?php
include_once "Autoload.php";
include_once("../open.php");
include_once("../config.php");
include_once("../funclib.php");


$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];
$url_search_action = $url . '.php';

$counter = array();

$filter = new \filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

$validator = new filter\Validator($get_prog, ['group' => ['required','isPositive']]);
if ( !$validator->validateThis() ) {
    header("HTTP/1.1 400 Bad Request", true, 400);
    echo exception\JsonError::exitError(false, 1, $validator->getErrors());
    exit();
}

$calcGroup = new \pdo\CalcGroup( $filter->getInt('group') );
$nameGroup = $calcGroup->getNameGroup();
$cell = $calcGroup->getIdCell();

echo 'Группа - ' , $nameGroup;
echo 'Ячейки - ', $cell;


$type['success'] = true;
$type['id_error'] = 0;
$type['input'] = $get_prog;
$type['data'] = $counter;
$type['navigator'] = $navigator;
$type['url'] = $url_search_action;
//var_dump($type);
//echo json_encode($type);


	