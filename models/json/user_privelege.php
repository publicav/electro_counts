<?php
include_once "Autoload.php";
include_once( "../open.php" );
include_once( "../config.php" );
include_once( "../funclib.php" );

$filter = new \filter\FilterInput( $_POST );
$get_prog = $filter->getInputAll();

$validator = new filter\Validator( $get_prog, [
    'id_user' => [ 'required', 'isPositive', ],
    'data'    => [ 'required', ],

] );

$dataCheck = explode( ",", $get_prog['data'] );
$id_user = $get_prog['id_user'];

$privelegeObj = new pdo\Privelege( $id_user );
$id_privelege = $privelegeObj->getPriv();
$getMenuLeft = new \pdo\GetMenuLeft();
$leftMenu = new \base\LeftMenu( $privelegeObj, $getMenuLeft );
$leftMenu->setSqlData( $dataCheck );


if ( !empty( $id_privelege ) ) {
    $countPriv = count( $id_privelege );
    $fields = $leftMenu->getSqlFieldsReplace();
    $values = $leftMenu->getSqlValuesReplace();
    $sq = "REPLACE INTO tables_priv ( $fields ) VALUES $values;";

} else {
    $fields = $leftMenu->getSqlFields();
    $values = $leftMenu->getSqlValues();
    $sq = "INSERT INTO tables_priv ( $fields ) VALUES $values;";
}

$res = $pdo->prepare( $sq );
if ( !$res->execute() ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}

$type['id_error'] = 0;
$type['success'] = true;
$type['sql'] = $sq;

echo json_encode( $type );
