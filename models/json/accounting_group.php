<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );
    //    include_once( "../config.php" );
    //    include_once( "../funclib.php" );


    //$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );

    //$url = $path_parts['filename'];
    //$url_search_action = $url . '.php';

    $counter = [];

    $filter = new \filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    if ( !isset( $get_prog['date_b'] ) ) {
        $get_prog['date_b'] = '2016-12-01';
        $get_prog['date_e'] = '2016-12-31';

    }

    if ( !isset( $get_prog['date_e'] ) ) {
        $get_prog['date_e'] = $get_prog['date_b'];
    }
//var_dump($get_prog);
    $validator = new filter\Validator( $get_prog, [ 'group' => [ 'required', 'isPositive' ] ] );
    if ( !$validator->validateThis() ) {
        throw new exception\InputException( 'Input error' ); //$validator->getErrors()
    }

    //    $calcGroup = pdo\CalcGroup::init( $filter->getInt( 'group' ) );
    //    $nameGroup = $calcGroup->getNameGroup();
    //    $calcGroup->queryGroup('2016-12-01', '2016-12-31');
    //    $sqlData = $calcGroup->getSqlData();

    $calcGroup = new base\GroupCounterCalc( $filter->getInt( 'group' ),  $get_prog['date_b'],  $get_prog['date_e'] );
    //    $calcGroup = new base\GroupCounterCalc( 2, '2016-12-01', '2016-12-31' );

    //     {sTitle: '1 Ввод'},
    //    {sTitle: '2 Ввод'},
    //    {sTitle: '3 Ввод'},
    $legend = $calcGroup->getLegend();
    $title[] = [ 'sTitle' => 'Время' ];
    foreach ( $legend as $key => $value ) {
        $title[] = [ 'sTitle' => $value['name'] ];
    }
    $title[] = [ 'sTitle' => 'Сумма' ];

    //    var_dump( $calcGroup->getSortData() );
    //    echo 'Группа - ', $calcGroup->getNameGroup(), '<br/>';
    //    var_dump( $calcGroup->getData() );
    //var_dump($calcGroup->getCoeffPower(22, 2));
    //echo 'getIdCell', '<br/>';
    //    var_dump($calcGroup->getIdCell());
    //echo 'getCounterGroup', '<br/>';
    //var_dump($calcGroup->getCounterGroup());
    //echo 'getCoeffPower', '<br/>';
    //var_dump($nameCounts);


    $type['success'] = true;
    $type['id_error'] = 0;
    $type['nameGroup'] = 'Группа - ' . $calcGroup->getNameGroup();
    $type['title'] = $title;
    $type['calcData'] = $calcGroup->getCalcData();
    //    $type['input'] = $get_prog;
    $type['data'] = $counter;
    //    var_dump( $type );
    echo json_encode( $type );


    foreach ( $type['calcData'] as $key => $counter ) {

        foreach ( $counter as $key1 => $power ) {

            if ( is_integer( $key1 ) ) {
                $xAxis[ $key1 ][] = $power;

            }
            $tableRow[ $key1 ] = $power;

        }
        //        var_dump( $tableRow );
    }
    //    $dateJson = json_encode( $date1 );
    //
    //    $xpos22 = json_encode( $xAxis[22] );
    //    $xpos23 = json_encode( $xAxis[23] );
    //    $xpos24 = json_encode( $xAxis[24] );

} catch ( exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    echo $e->getMessage();
}
	