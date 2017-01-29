<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.01.2017
 * Time: 18:36
 */

namespace navigation;


class Route{
    protected static $_link = null;
    protected $_config;
    protected $_pathinfo, $_filename;
    private $container = array();
    protected $_authorization = null;
    protected $_conroller;
    protected $_action;

    /**
     * Route constructor.
     * @throws \Exception
     */
    public function __construct(){
        if( !file_exists(__DIR__  . "/../../../config/route.conf.php") ) {
            throw new \Exception('Route file  not found! -  ' . __DIR__  . "/../../config/route.conf.php");
        }
        $this->_config = require_once __DIR__  . "/../../../config/route.conf.php";
        $this->_pathinfo = pathinfo( $_SERVER['SCRIPT_FILENAME'] );
        $this->_filename = $this->_pathinfo['filename'];
        $this->_conroller = $this->_filename;
    }

    /**
     * @return Route|null
     */
    public static function init(){
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
        return self::$_link;
    }

    /**
     * @return string
     */
    public function getModelPath(){
        $pathModels = $this->_config['model'] .  '/' . $this->_filename . $this->_config['modelFileLatest'] . '.' .
                      $this->_config['modelExtension'];
        if( !file_exists( $pathModels ) ) {
            throw new Exception('File not found! - ' . $pathModels, '404');
        }

        return $pathModels;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getViewPath(){
        $pathViews = $this->_config['view'] .  '/' . $this->_filename . $this->_config['viewFileLatest'] . '.' .
                     $this->_config['viewExtension'];
        if( !file_exists( $pathViews ) ) {
            throw new \Exception('File not found! - ' . $pathViews, '404');
        }

        return $pathViews;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getBlankViewPath(){
        $pathBlankViews = $this->_config['view'] .  '/' . $this->_config['viewBlank'] . $this->_config['viewFileLatest'] . '.' .
            $this->_config['viewExtension'];
            if( !file_exists( $pathBlankViews ) ) {
                throw new \Exception('File not found! - ' . $pathBlankViews, '404');
            }

        return $pathBlankViews;
    }

    /**
     * @return mixed
     */
    public function getFileName(){
        return $this->_filename;
    }

    /**
     * @return string
     */
    public function getFullFileName(){
        return $this->_filename . $this->_config['modelExtension'];
    }

    /**
     * @return string
     */
    public function getHeadPath(){
        return $this->_config['view'] .  '/' . $this->_config['headFile'];
    }

    /**
     * @return string
     */
    public function getMenuRegPath(){
         $pathMenu = $this->_config['menuPath'] .  '/' . $this->_config['menuFileReg']  . '.' .
            $this->_config['menuRegExtension'];
         return $pathMenu;
    }

    /**
     * @return string
     */
    public function getMenuUnRegPath(){
        $pathMenu = $this->_config['menuPath'] .  '/' . $this->_config['menuFileUnReg']  . '.' .
            $this->_config['menuUnRegExtension'];
        return $pathMenu;
    }

    public function getLayout( $name ){
        $pathLayot = $this->_config['layout'] .  '/' . $name . '.' . $this->_config['layoutExtension'];
        if( !file_exists( $pathLayot ) ) {
            throw new \Exception('File not found! - ' . $pathLayot, '404');
        }

        return $pathLayot;
    }
    public function getJson( $name ){
        $pathLayot = $this->_config['json'] .  '/' . $name . '.' . $this->_config['jsonExtension'];
        if( !file_exists( $pathLayot ) ) {
            throw new \Exception('File not found! - ' . $pathLayot, '404');
        }

        return $pathLayot;
    }
    public function __set($name, $value) {
        // TODO: Implement __set() method.
        if( !isset( $this->container[$name] ) ) {
            $this->container[$name] = $value;
        } else {
            trigger_error('Variable '. $name .' already defined', E_USER_WARNING);
        }
    }
    public function __get($name) {
        // TODO: Implement __get() method.
        return $this->container[$name];
    }

    /**
     * @param mixed $authorization
     */
    public function setAuthorization($authorization){
        $this->_authorization = $authorization;
    }

    /**
     * @return mixed
     */
    public function getAuthorization(){
        return $this->_authorization;
    }

    public function getController(){
        $controler = $this->_config['controllers'];
//        if ( !is_null( $this->_authorization ) ) {
//            return $controler[ $this->_conroller ]['controllerName'];
//        }
        return $controler[ $this->_conroller ]['controllerName'];
    }

    /**
     * @return mixed
     */
    public function getAction(){
        $actions = $this->_config['controllers'][ $this->_conroller ]['actions'];
        if ( !is_null( $this->_authorization ) ) {
            return $actions['auth'];
        }
        return $actions['nonAuth'];
    }

}