<?php
try {
    include_once "Autoload.php";
    include_once "../open.php";

    $GetAllUsers = new \Pdo\GetAllUsers();

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $GetAllUsers->getUserAll(),
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


	