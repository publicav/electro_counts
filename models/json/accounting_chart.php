<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.02.2017
 * Time: 23:37
 */

use pdo\GroupCounterData;

try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new filter\Validator( $get_prog, [
        'group'  => [ 'required', 'isPositive' ],
        'date_b' => [ 'isDate' ],
        'date_e' => [ 'isDate' ],
    ] );
    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $error ) {
            throw new exception\InputException( 'Input error - ' . $error ); //$validator->getErrors()
        }
    }
    $dt = new \DateTime();
    if ( empty( $get_prog['date_b'] ) ) {
        $get_prog['date_b'] = $dt->format( 'Y-m-01' );
        $get_prog['date_e'] = $dt->format( 'Y-m-d' );

    } elseif ( empty( $get_prog['date_e'] ) ) {
        $get_prog['date_e'] = $dt->format( 'Y-m-d' );
    }

    $dateLow = $get_prog['date_b'];
    $dateHigh = $get_prog['date_e'];
    $numberGroup = $get_prog['group'];
    $dataGroup = GroupCounterData::init( $numberGroup );
    $dataGroup->queryGroup( $dateLow, $dateHigh );

    $chartGroup = new base\GroupCounterChart( $dataGroup, $dateLow, $dateHigh );
    $chartGroup->init();
    $legend = $chartGroup->getLegend();
    $calcData = $chartGroup->getCalcData();
    $categories = $calcData['date'];
    $count = 0;
    foreach ( $legend as $key => $value ) {
        $chartData[] = [ 'name' => $value['name'], 'data' => $calcData[ $count ] ];
        $count++;
    }

    //    var_dump( $title );
    //    options.series = [ {
    //        name: 'ssds',
    //            data: [ 1, 2, 3, 4 ]
    //        }, {
    //        name: 'ertt',
    //            data: [ 1, 2, 3, 4 ]
    //        }, {
    //        name: '3353',
    //            data: [ 1, 2, 3, 4 ]
    //        },{
    //        name: '3333353',
    //            data: [ 1, 2, 3, 4 ]
    //        }  ];
    //

    $type['success'] = true;
    $type['id_error'] = 0;
    $type['nameGroup'] = 'Группа - ' . $chartGroup->getNameGroup();
    $type['categories'] = $categories;
    $type['calcData'] = $chartData;
    echo json_encode( $type );
    //    var_dump( $type );
} catch ( exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    echo $e->getMessage();
}
