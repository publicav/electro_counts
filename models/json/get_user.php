<?php
try {
    include_once "Autoload.php";
    include_once "../open.php";

    $GetAllUsers = new \pdo\GetAllUsers();

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $GetAllUsers->getUserAll(),
    ];
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


	