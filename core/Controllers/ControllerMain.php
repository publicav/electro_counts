<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:16
 */

namespace Controllers;


use Base\Conroller;
use Pdo\Privelege;

class ControllerMain extends Conroller {

    public function actionIndex() {
        // TODO: Implement actionIndex() method.
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionBlank() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $this->_view->render( $this->_route->getBlankViewPath(), '' );
    }

    public function actionHelp() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionView_count() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/ui/minified/jquery.ui.datepicker-ru.min.js',
            'js/jquery.maskedinput.min.js',
            'js/filters.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionLoad_forms() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/user.js'
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionEdit_count() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/ui/minified/jquery.ui.datepicker-ru.min.js',
            'js/jquery.maskedinput.min.js',
            'js/select2/js/select2.min.js',
            'js/filters.js',
            'js/edit_counts.js'
        ] );
        $this->_view->setCss( [
            'js/select2/css/select2.min.css',
        ] );

        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionCalc_count() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/filters-calc.js',
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionAddGroup() {
        // TODO: Implement actionIndex() method.
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/add-group-counts.js',
        ] );
        $this->_view->setCss( [
            'css/add-group-counts.css',
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionDelGroup() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/select2/js/select2.min.js',
            //            'js/bootstrap-select/js/bootstrap-select.min.js',
            'js/del-group-counts.js',

        ] );
        $this->_view->setCss( [
            'js/select2/css/select2.min.css',
            //            'js/bootstrap-select/css/bootstrap-select.min.css',
            'css/del-group-counts.css',
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

    public function actionEditGroup() {
        $this->_view->setFileMainMenu( $this->_route->getMainMenu() );
        $menuLeft = new Privelege( $this->_auth );
        $this->_view->setLeftMenu( $menuLeft->getMenuLeft() );
        $this->_view->setJs( [
            'js/select2/js/select2.min.js',
            //            'js/bootstrap-select/js/bootstrap-select.min.js',
            'js/edit-group-counts.js',

        ] );
        $this->_view->setCss( [
            'js/select2/css/select2.min.css',
            //            'js/bootstrap-select/css/bootstrap-select.min.css',
            'css/edit-group-counts.css',
        ] );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

}