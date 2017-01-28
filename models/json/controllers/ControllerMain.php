<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:16
 */

namespace controllers;


use base\Conroller;
use pdo\GetNamePage;
use pdo\Privelege;
use base\mainMenu;

class ControllerMain extends Conroller {
    public function actionIndex(){
        // TODO: Implement actionIndex() method.
        $this->_view->setHeadUrl( GetNamePage::getConfAll( $this->_route->getFileName(), 1 ) );
        $menuLeft = new Privelege( $this->_route->getAuthorization() );
        $this->_view->setAuth( $this->_route->getAuthorization() );
        $this->_view->setMainMenu( mainMenu::getMenu( $this->_route->getMenuRegPath() ) );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
//        $this->_view->render( $this->_route->getViewPath(), '');
    }

    public function actionBlank(){
        $this->_view->setAuth( null );
        $this->_view->setMainMenu( mainMenu::getMenu( $this->_route->getMenuUnRegPath() ) );
        $this->_view->render( $this->_route->getBlankViewPath(), '');
    }
    public function actionHelp(){
        $this->_view->setAuth( null );
        $this->_view->setMainMenu( mainMenu::getMenu( $this->_route->getMenuUnRegPath() ) );
        $this->_view->render( $this->_route->getViewPath(), '');
    }
}