<?php
include_once "Autoload.php";
include_once( "../open.php" );
include_once( "../config.php" );
include_once( "../funclib.php" );

$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];
$url_search_action = $url . '.php';

$counter = array();

$filter = new \Filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

if ( isset( $get_prog['st'] ) ) {
    $position_in = intval( $get_prog['st'] );
    $select = 1;
} else {
    $position_in = 0;
    $select = 1;
}

if ( isset( $get_prog['id_lot'] ) ) {
    $id_lot = intval( $get_prog['id_lot'] );
    $select = 2;
    if ( $id_lot == 0 ) $select = 1;
} else $id_lot = 0;

if ( isset( $get_prog['id_sub'] ) and ( $select == 2 ) ) {
    $id_sub = intval( $get_prog['id_sub'] );
    $select = 3;
    if ( $id_sub == 0 ) $select = 2;
} else $id_sub = 0;

if ( isset( $get_prog['id_counter'] ) and ( $select == 3 ) ) {
    $id_counter = intval( $get_prog['id_counter'] );
    $select = 4;
    if ( $id_counter == 0 ) $select = 3;
} else $id_counter = 0;

if ( isset( $get_prog['date_b'] ) ) {
    $date_b = $get_prog['date_b'];
} else $date_b = '';

if ( isset( $get_prog['date_e'] ) ) {
    $date_e = $get_prog['date_e'];
} else $date_e = '';

$dateRange = range_time_day( $date_b, $date_e );
if ( $dateRange != '' ) {
    $dtRangeSql = " AND $dateRange";
} else {
    $dtRangeSql = '';
}
//$st_navigator = cmd_page_navigator( $date_b, $date_e );


switch ( $select ) {
    case 1:
        $filterSql = '';
        $paramNrange = [];
        $param = [ 'position_in' => $position_in,
                   'total_col'   => $config['PAGE_COUNTER']
        ];
        break;
    case 2:
        $filterSql = ' AND (lot.id = :id_lot)';
        $paramNrange = [ 'id_lot' => $id_lot ];
        $param = [ 'position_in' => $position_in,
                   'total_col'   => $config['PAGE_COUNTER'],
                   'id_lot'      => $id_lot
        ];
        break;
    case 3:
        $filterSql = ' AND (sub.id = :id_sub)';
        $paramNrange = [ 'id_sub' => $id_sub ];
        $param = [ 'position_in' => $position_in,
                   'total_col'   => $config['PAGE_COUNTER'],
                   'id_sub'      => $id_sub
        ];
        break;
    case 4:
        $filterSql = ' AND (cnt.id = :id_counter)';
        $paramNrange = [ 'id_counter' => $id_counter ];
        $param = [ 'position_in' => $position_in,
                   'total_col'   => $config['PAGE_COUNTER'],
                   'id_counter'  => $id_counter
        ];
        break;

    default:
}
$sqlNumberRecords = "SELECT main.id 
                     FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot 
                     WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) 
                     $filterSql $dtRangeSql;
                     ";

$res = $pdo->prepare( $sqlNumberRecords );
if ( !$res->execute( $paramNrange ) ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}
$total = $res->rowCount();

$sq = "SELECT main.id, cnt.name AS counter, DATE_FORMAT(main.date_create, '%d-%m-%y %H:%i' ) AS date1, 
                      main.value AS value, sub.name AS substation, lot.name AS lot, 
                      concat( users.name, ' ', users.family) AS name_user
				FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot, users
				WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND 
				      (main.id_users = users.id)  
				      $filterSql $dtRangeSql
				ORDER by date_create
				LIMIT :position_in, :total_col;
      ";

$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
$res = $pdo->prepare( $sq );
if ( !$res->execute( $param ) ) {

    header( "HTTP/1.1 400 Bad Request", true, 400 );
    print exit_error( false, 3, $res->errorInfo()[2] );
    exit();
}

while ( $row = $res->fetch() ) {
    $keyId = 'c' . $row['id'];
    $counter[ $keyId ] = $row;
}

$navigator = navigator(
    $url_search_action,
    $position_in,
    $total,
    $config['PAGE_COUNTER'],
    $get_prog
);
$navigationData = \Navigation\NavigationFilter::init( $position_in, $total, $get_prog )->
                    setColumPage( 34 )->setNavigatorPage( 3 )->doNavigation();
$result = [
    'success'        => true,
    'id_error'       => 0,
    'data'           => $counter,
    'navigator'      => $navigator,
    'navigationData' => $navigationData,
];
echo json_encode( $result );


	