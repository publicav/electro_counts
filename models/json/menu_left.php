<?php
try {
    include_once "Autoload.php";
    include_once "../open.php";

    $route = \Navigation\Route::init();
    $id_users = $route->getAuthorization();

    if ( $id_users > 0 ) {
        $menuLeft = new \Pdo\Privelege( $id_users );
        $menu_left_m = $menuLeft->getMenuLeft();
    }

    echo json_encode( $menu_left_m );
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
