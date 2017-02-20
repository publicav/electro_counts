<?php
include_once "Autoload.php";
include_once( "../open.php" );
include_once( "../config.php" );

$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
$url = $path_parts['filename'];
$url_search_action = $url . '.php';

$filter = new \Filter\FilterInput( $_GET );
$get_prog = $filter->getInputAll();

$select = 1;
$position_in = $filter->getInt( 'st' );
unset( $get_prog['st'] );
$id_lot = $filter->getInt( 'id_lot' );
if ( $id_lot > 0 ) {
    $select = 2;
}
$id_sub = $filter->getInt( 'id_sub' );
if ( $id_sub > 0 ) {
    $select = 3;
}
$id_counter = $filter->getInt( 'id_counter' );
if ( $id_counter > 0 ) {
    $select = 4;
}
$date_b = $filter->getDate( 'date_b' );
$date_e = $filter->getDate( 'date_e' );
$dtRangeSql = \Date\RangeTimeSql::init( $date_b, $date_e )->doRange( 'date_create' )->getSQL();
$paramNrange = [];
$param =[];

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
$total = \Pdo\RowCount::init( $sqlNumberRecords,$paramNrange )->doRowCount()->getRowCount();

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

$counter = [];
while ( $row = $res->fetch() ) {
    $keyId = 'c' . $row['id'];
    $counter[ $keyId ] = $row;
}

$navigationData = \Navigation\NavigationFilterData::init( $position_in, $total, $get_prog )->
                setColumPage( 34 )->setNavigatorPage( 5 )->doNavigation();
$result = [
    'success'        => true,
    'id_error'       => 0,
    'data'           => $counter,
    'navigationData' => $navigationData,
];
echo json_encode( $result );


	