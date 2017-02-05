<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:16
 */

namespace controllers;


use base\Conroller;
use pdo\Privelege;

class ControllerMain extends Conroller {
    public function actionIndex() {
        // TODO: Implement actionIndex() method.
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionBlank() {
        $this->_view->render( $this->_route->getBlankViewPath(), '' );
    }

    public function actionHelp() {
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionView_count() {
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/jquery.maskedinput.min.js',
            'js/filters.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionLoad_forms() {
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/user.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionEdit_count() {
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/jquery.maskedinput.min.js',
            'js/filters.js',
            'js/edit_counts.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionCalc_count() {
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/filters-calc.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }


}