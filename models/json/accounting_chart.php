<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.02.2017
 * Time: 23:37
 */

use \Pdo\GroupCounterData;

try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \Filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'group'  => [ 'required', 'isPositive' ],
        'date_b' => [ 'isDate' ],
        'date_e' => [ 'isDate' ],
    ] );
    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
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

    $chartGroup = new \Base\GroupCounterChart( $dataGroup, $dateLow, $dateHigh );
    $chartGroup->calc();

    $result = [ 'success'    => true,
                'id_error'   => 0,
                'length'     => count( $chartGroup->getxAxis() ),
                'nameGroup'  => $chartGroup->getNameGroup(),
                'categories' => $chartGroup->getxAxis(),
                'calcData'   => $chartGroup->getOutputChartData(),
    ];
    echo json_encode( $result );

} catch ( Exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( Exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    echo $e->getMessage();
}
