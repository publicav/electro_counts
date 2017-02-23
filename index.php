<?php
try {
    //    include_once "models/json/Autoload.php";
    include_once 'vendor/autoload.php';
    include_once( "models/open.php" );
    include_once( "models/config.php" );
//    include_once( "models/funclib.php" );

    $route = \Navigation\Route::init();
    $conroler = $route->getController();
    $action = $route->getAction();
    $contoller = new $conroler();
    $contoller->$action();

} catch ( Exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( Exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    echo $e->getMessage();
}


