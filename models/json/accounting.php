<?php
try {
    include_once  '../../vendor/autoload.php';
    include_once( "../open.php" );
    include_once( "../config.php" );


    $path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );
    $url = $path_parts['filename'];
    $url_search_action = $url . '.php';


    $filter = new \Filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();


    $id_counter = $filter->getInt( 'id_counter' );
    $date_b = $filter->getDate( 'date_b' );

    $rangeDate = \Date\RangeMonthSql::init( $date_b, '' )->DoRangeDate();
    $dt1 = $rangeDate->getDateFirst();
    $dt2 = $rangeDate->getDateLast();

    $navig = [
        'id_counter' => $id_counter,
    ];
    $navigationcalc = new \Navigation\NavigationCalc( 'calc_count.php', $dt1, $navig );
    $navigationcalc->classHTML = [ 'navigator', 'pagelink', 'pagecurrent' ];
    $navigator = $navigationcalc->getNavigator();


    $dtPresent = new \DateTime();

    $dtLow = new DateTime( $config['DATE_BEGIN'] );
    $dtHigh = new \DateTime( $dt2 );

    $dtPresent->add( new \DateInterval( 'P1M' ) );

    if ( ( $id_counter <= 0 ) or ( ( $dtHigh > $dtPresent ) or ( $dtHigh < $dtLow ) ) ) {

        $type['success'] = true;
        $type['id_error'] = 0;
        $type['data'] = [];
        $type['navigator'] = $navigator;
        echo json_encode( $type );
        exit();
    }
    $dataCounter = \Pdo\CounterData::init( $id_counter );
    $dataCounter->queryGroup( $dt1, $dt2 );

    $getCount = new \Pdo\GetCounts( [ 'id' => $id_counter ] );
    $name_counter = $getCount->getName();

    $calcGroup = new \Base\GroupCounterCalc( $dataCounter, $dt1, $dt2 );
    $calcGroup->calc();


    $result = [ 'success'   => true,
                'id_error'  => 0,
                'nameGroup' => $calcGroup->getNameGroup(),
                'title'     => $name_counter,
                'Data'      => $calcGroup->getCalcData(),
                'navigator' => $navigator,
    ];
    echo json_encode( $result );

} catch ( Exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( Exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
}
