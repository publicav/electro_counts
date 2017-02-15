<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new filter\Validator( $get_prog, [
        'data' => [ 'required', 'isPositive' ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $lot = $get_prog['data'];
    $substation = new pdo\Substation( $pdo, $lot );

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $substation->GetSubstation() ];

    echo json_encode( $result );

} catch ( exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    echo $e->getMessage();
}

