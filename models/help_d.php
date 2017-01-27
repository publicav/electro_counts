<?php
$view = new base\View();
$view->setLayout( $route->getLayout('main') );
$view->setHeadUrl( pdo\GetNamePage::getConfAll( $route->getFileName(), $config['LANG'] ) );

if ( $sid != 0 ) {
    $menuLeft = new pdo\Privelege( $sid );
    $mainMenu =new base\mainMenu( $route->getMenuRegPath() );

    $view->setAuth( $sid );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->setLeftMenu( $menuLeft->getMenuLeft( $pdo ) );
    $view->render( $route->getViewPath(), '');
} else {
    $mainMenu =new base\mainMenu( $route->getMenuUnRegPath() );
    $view->setAuth( null );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getViewPath(), '');
}

