<?php
$currentPage = new pdo\GetNamePage( $pdo, $route->getFileName(), $config['LANG'] );
$view = new base\View();
$view->setLayout( $route->getLayout('main') );
$view->setTitle( $currentPage->getTitle() );
$view->setMetaD( $currentPage->getMetaD() );
$view->setMetaK( $currentPage->getMetaK() );


if ( $sid != 0 ) {
	$menuLeft = new pdo\Privelege( $pdo, $sid);
	$user = new pdo\GetUser( $pdo, $sid );
	$mainMenu =new base\mainMenu($route->getJson('menu_registration'));

	$view->setLeftMenu( $menuLeft->getMenuLeft( $pdo ) );
	$view->setAuth( $sid );
	$view->setUser( $user->GetUser() );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getViewPath(), '');
} else {
    $mainMenu =new base\mainMenu($route->getJson('menu'));

    $view->setAuth( null );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getBlankViewPath(), '');
}

