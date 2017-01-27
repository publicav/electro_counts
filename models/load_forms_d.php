<?php
$currentPage = new pdo\GetNamePage( $route->getFileName(), $config['LANG'] );
$view = new base\View();
$view->setLayout( $route->getLayout('main') );
$view->setHeadUrl( $currentPage->getConfAll() );

if ( $sid != 0 ) {
    $menuLeft = new pdo\Privelege($sid);
    $mainMenu =new base\mainMenu( $route->getMenuRegPath() );

    $view->setMainMenu( $mainMenu->getMenu() );
    $view->setLeftMenu( $menuLeft->getMenuLeft() );
    $view->setAuth( $sid );
    $view->setUser( pdo\GetUser::GetUser(  $sid  ) );
    $view->setJs( ['js/user.js']);
    $view->render( $route->getViewPath(), '');
} else {
    $mainMenu =new base\mainMenu( $route->getMenuUnRegPath() );
    $view->setAuth( null );
    $view->setMainMenu( $mainMenu->getMenu() );
    $view->render( $route->getBlankViewPath(), '');
}
