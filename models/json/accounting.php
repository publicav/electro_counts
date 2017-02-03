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

$counter = array();

$filter = new \filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

if ( isset( $get_prog['id_lot'] ) ) {
    $id_lot = intval( $get_prog['id_lot'] );
    $put_js['id_lot'] = $id_lot;

    $select = 2;
    if ( $id_lot == 0 ) $select = 1;
} else $id_lot = 0;

if ( isset( $get_prog['id_sub'] ) and ( $select == 2 ) ) {
    $id_sub = intval( $get_prog['id_sub'] );
    $put_js['id_sub'] = $id_sub;
    $select = 3;
    if ( $id_sub == 0 ) $select = 2;
} else $id_sub = 0;

if ( isset( $get_prog['id_counter'] ) ) {
    $id_counter = intval( $get_prog['id_counter'] );
    $put_js['id_counter'] = $id_counter;
    $select = 4;
    if ( $id_counter == 0 ) $select = 3;
} else $id_counter = 0;


if ( !isset( $get_prog['id_counter'] ) ) {
    $type['success'] = true;
    $type['id_error'] = 0;
    $type['data'] = [];
    echo json_encode( $type );
    exit();
}


if ( isset( $get_prog['date_b'] ) ) {
    $date_b = $get_prog['date_b'];
    //	$put_js['date_b'] = $date_b;
} else $date_b = '';


if ( isset( $get_prog['date_e'] ) ) {
    $date_e = $get_prog['date_e'];
    // $put_js['date_e'] = $date_e;
} else $date_e = '';


$getCount = new pdo\getCounts( [ 'id' => $id_counter ] );
$name_counter = $getCount->getName();

$GetCoeffPower = new pdo\GetCoeffPower( $getCount->getCount() );
$coeffPower = $GetCoeffPower->getKoefPowerId();

$dateSql = new date\rangeDateSql( $date_b, '' );
$rangeSql = $dateSql->getSQL( 'date_create' );

$rangeSql = ' AND ' . $rangeSql;
$sq = "SELECT main.id, main.value AS value, UNIX_TIMESTAMP(main.date_create)  AS date_second, 
                   main.date_create AS dt1, main.n_counter
			FROM counter_v AS main
			WHERE (main.id_counter = :id_counter) $rangeSql
			ORDER by date_create;";
$navigationcalc = new \navigation\NavigationCalc( $url_search_action, $date_b, $put_js );
$navigationcalc->classHTML = [ 'navigator', 'pagelink', 'pagecurrent' ];
$navigator = $navigationcalc->getNavigator();

$firstLoop = 0;
$timeNew = 0;
$timeEnd = 0;
$valueNew = 0;
$diffTime = 0;
$diffMinuteVal = 0;
$date1 = 0;
$rateBefore = 0;
$rateAfter = 0;
$count = 0;
$day = 0;
$rare = 0;
$period = 0;
$round = 3;

$res = $pdo->prepare( $sq );
$param = array( 'id_counter' => $id_counter );

if ( !$res->execute( $param ) ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
while ( $row = $res->fetch() ) {
    if ( $firstLoop > 0 ) {
        $dt2 = $row['dt1'];
        $dtMinuteEnd = new date\DivisionDay( $dt2 );
        $day = date( "d-m-Y", strtotime( $dt1 ) );

        $timeEnd = $row['date_second'];
        $diffTime = round( ( $timeEnd - $timeNew ) / 60 );
        $diffValue = ( $row['value'] - $valueNew ) * $coeffPower[ $row['n_counter'] ];
        $diffMinuteVal = $diffValue / $diffTime;

        if ( $count > 0 ) {
            $rateAfter = $diffMinuteVal * $dtMinuteNew->minuteAfter;
            $rare = $rateBefore + $rateAfter;
            $counter[] = array( 'name_counter' => $name_counter, 'date' => $day, 'rare' => round( $rare, $round ) );
        }
        if ( $diffTime > 1440 ) {
            $periodObj = new date\PeriodDay ( $dt2, $dt1, $diffMinuteVal, $name_counter );
            foreach ( $periodObj->day as $colum ) $counter[] = $colum;
        }
        $rateBefore = $diffMinuteVal * $dtMinuteEnd->minuteBefore;
        $count++;
    }
    $timeNew = $row['date_second'];
    $valueNew = $row['value'];
    $dt1 = $row['dt1'];
    $dtMinuteNew = new date\DivisionDay ( $dt1 );
    $firstLoop = 1;
}

// if (!isset($counter)) {
// header("HTTP/1.1 400 Bad Request", true, 400);
// print exit_error( false, 3, 'Данные отсутствуют' );
// exit();
// }


$type['success'] = true;
$type['id_error'] = 0;
$type['data'] = $counter;
$type['navigator'] = $navigator;

echo json_encode( $type );


	