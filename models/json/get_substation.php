<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \Filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'data' => [ 'required', 'isPositive' ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $lot = $get_prog['data'];
    $substation = new \Pdo\Substation( $pdo, $lot );

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $substation->GetSubstation() ];

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

