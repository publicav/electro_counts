<?php
$view = new base\View();
$view->setLayout( $route->getLayout('main') );
$view->setHeadUrl( pdo\GetNamePage::getConfAll( $route->getFileName(), $config['LANG'] ) );
if ( $sid != 0 ) {
    $menuLeft = new pdo\Privelege( $sid );
    $view->setAuth( $sid );
    $view->setMainMenu( base\mainMenu::getMenu( $route->getMenuRegPath() ) );
	$view->setLeftMenu( $menuLeft->getMenuLeft() );
	$view->render( $route->getViewPath(), '');
} else {
    $view->setAuth( null );
    $view->setMainMenu( base\mainMenu::getMenu( $route->getMenuUnRegPath() ) );
    $view->render( $route->getBlankViewPath(), '');
}

