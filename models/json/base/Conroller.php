<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 2:10
 */

namespace base;

use navigation\Route;

abstract class  Conroller{
    public $_view;
    public $_route;
    function __construct() {
        $this->_route = $route = Route::init();
        $this->_view = new View();
        $this->_view->setLayout( $this->_route->getLayout('main') );
    }

    abstract public function actionIndex( $sid );
}