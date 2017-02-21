<?php
try {
//    include_once "models/json/Autoload.php";
	include_once  'vendor/autoload.php';
    include_once( "models/open.php" );
    include_once( "models/config.php" );
    include_once( "models/funclib.php" );

    $route = \Navigation\Route::init();
    $conroler = $route->getController();
    $action = $route->getAction();

    $contoller = new $conroler();
//    var_dump($conroler,$action);
        $contoller->$action();
//        var_dump(\Base\Url::getAllSegments());

} catch ( Exception $e ) {
    die( $e->getMessage() );
}
