<?php
$currentPage = new pdo\GetNamePage( $pdo, $route->getFileName(), $config['LANG'] );
$view = new base\View();
$view->setLayout( $route->getLayout('main') );
$view->setHeadUrl( $currentPage->getConfAll() );

if ( $sid != 0 ) {
    $menuLeft = new pdo\Privelege( $pdo, $sid);
    $mainMenu =new base\mainMenu( $route->getMenuRegPath() );
	$user = new pdo\GetUser( $pdo, $sid );


	$view->setLeftMenu( $menuLeft->getMenuLeft() );
	$view->setAuth( $sid );
	$view->setUser( $user->GetUser() );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getViewPath(), '');
} else {
    $mainMenu =new base\mainMenu( $route->getMenuUnRegPath() );

    $view->setAuth( null );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getBlankViewPath(), '');
}

