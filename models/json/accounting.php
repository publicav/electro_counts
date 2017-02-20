<?php
include_once "Autoload.php";
include_once( "../open.php" );
include_once( "../config.php" );
include_once( "../funclib.php" );


$st_sql = '';
$st_page = '';
$name_counter = '';

$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];
$url_search_action = $url . '.php';

$counter = [];

$filter = new \Filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();


$id_counter = $filter->getInt( 'id_counter' );
$date_b = $filter->getDate( 'date_b' );
$date_e = $filter->getDate( 'date_e' );

$rangeDate = \Date\RangeMonthSql::init( $date_b, '' )->DoRangeDate();
$dt1 = $rangeDate->getDateFirst();
$dt2 = $rangeDate->getDateLast();


if ( $id_counter <= 0 ) {
    $type['success'] = true;
    $type['id_error'] = 0;
    $type['data'] = [];
    echo json_encode( $type );
    exit();
}
$dataCounter = \Pdo\CounterData::init( $id_counter );
$dataCounter->queryGroup( $dt1, $dt2 );

$getCount = new \Pdo\GetCounts( [ 'id' => $id_counter ] );
$name_counter = $getCount->getName();

$calcGroup = new \Base\GroupCounterCalc( $dataCounter, $dt1, $dt2 );
$calcGroup->calc();

$navigationcalc = new \Navigation\NavigationCalc( '', $dt1, $get_prog );
$navigationcalc->classHTML = [ 'navigator', 'pagelink', 'pagecurrent' ];
$navigator = $navigationcalc->getNavigator();

$result = [ 'success'   => true,
            'id_error'  => 0,
            'nameGroup' => $calcGroup->getNameGroup(),
            'title'     => $name_counter,
            'Data'  => $calcGroup->getCalcData(),
            'navigator' => $navigator,
];
echo json_encode( $result );
//var_dump( $result );

