<?php
mb_internal_encoding('UTF-8');
try {
    include_once "models/json/AutoloadBase.php";
    include_once("models/open.php");
    include_once("models/config.php");
    include_once("models/funclib.php");

    $route = navigation\Route::init();
    $Full_Page_Name = $route->getFileName();
    $head = include_h($route->getHeadPath());

    if ($sid == 0) {
        $menu_json = include_h( $route->getMenuUnRegPath() );
        include_once $route->getModelPath();
        include_once $route->getBlankViewPath();
    } else {
        $menu_json = include_h( $route->getMenuRegPath() );
        include_once $route->getModelPath();
        include_once $route->getViewPath();
    }
//    var_dump($route->getModelPath(), $route->getViewPath(), $route->getBlankViewPath());

}catch(\Exception $e){
    die( $e->getMessage() );
}
?>