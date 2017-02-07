<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.02.2017
 * Time: 21:36
 */

namespace controllers;


use base\Conroller;

class ControllerView extends Conroller{
    public function actionIndex() {
        // TODO: Implement actionIndex() method.

    }
    public function actionBlank() {
        // TODO: Implement actionBlank() method.
        $this->_view->setLayout( $this->_route->getLayout('view_v') );
        $this->_view->render( $this->_route->getViewPath(), '' );
    }

}