<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2017
 * Time: 18:25
 */

namespace base;


class View{
    protected $_baseDir = __DIR__ . '';
    protected $_title, $_MetaK, $_MetaD;
    protected $_layout;
    protected $_mainMenu, $_leftMenu;
    protected $_auth =null;
    protected $_user;
    public function render($tplName, $data){
//           var_dump($this->_baseDir);
//           var_dump($tplName);
//           var_dump($this->_layout);

        include $this->_layout;
    }
    public function setLayout( $pathLauout ){
        $this->_layout = $pathLauout;
    }

    /**
     * @param mixed $title
     */
    public function setTitle( $title ){
        $this->_title = $title;
    }

    /**
     * @param mixed $mainMenu
     */
    public function setMainMenu( $mainMenu ) {
        $this->_mainMenu = $mainMenu;
    }

    /**
     * @param mixed $MetaK
     */
    public function setMetaK( $MetaK ){
        $this->_MetaK = $MetaK;
    }

    /**
     * @param mixed $MetaD
     */
    public function setMetaD( $MetaD ){
        $this->_MetaD = $MetaD;
    }

    /**
     * @param $confArray
     */
    public function setHeadUrl($confArray ){
        $this->_title = $confArray['title'];
        $this->_MetaK = $confArray['meta_k'];
        $this->_MetaD = $confArray['meta_d'];
//        var_dump($this->_mainMenu, $this->_MetaK,$this->_MetaD);
    }


    /**
     * @param mixed $auth
     */
    public function setAuth( $auth ) {
        $this->_auth = $auth;
    }

    /**
     * @param mixed $user
     */
    public function setUser( $user ){
        $this->_user = $user;
    }

    /**
     * @param mixed $leftMenu
     */
    public function setLeftMenu( $leftMenu ){
        $this->_leftMenu = $leftMenu;
    }

}