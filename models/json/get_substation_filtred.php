<?php
try {
    include_once  '../../vendor/autoload.php';
//    include_once "Autoload.php";
    include_once "../open.php";

    $filter = new \Filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'data' => [ 'required',  ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $lot = $get_prog['data'];
    $substationFilter = new \Pdo\Substation( $pdo, $lot );

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $substationFilter->GetSubstationFilter() ];

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



