<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.01.2017
 * Time: 18:36
 */

namespace Navigation;

use \Base\Url;

class Route {
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
    public function __construct() {
        if ( !file_exists( __DIR__ . "/../../../config/route.conf.php" ) ) {
            throw new \Exception( 'Route file  not found! -  ' . __DIR__ . "/../../config/route.conf.php" );
        }
        $this->_config = require_once __DIR__ . "/../../../config/route.conf.php";
        $this->_pathinfo = pathinfo( $_SERVER['SCRIPT_FILENAME'] );
        //                $this->_filename = $this->_pathinfo['filename'];
        //                var_dump($this->_filename);
        //                exit();
        //                        $this->_conroller = $this->_filename;
        $controller = Url::getSegment( 0 );
        $this->_conroller = $controller;
        if ( isset( $_SESSION['user']['id'] ) ) $id = $_SESSION['user']['id']; else $id = null;
        $this->_authorization = $id;
    }

    /**
     * @return Route|null
     */
    public static function init() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        return self::$_link;
    }

    /**
     * @return string
     */
    public function getModelPath() {
        $conf = $this->_config;
        $pathModels = "{$conf['model']}/{$this->_filename}{$conf['modelFileLatest']}.{$conf['modelExtension']}";
        if ( !file_exists( $pathModels ) ) {
            throw new Exception( 'File not found! - ' . $pathModels, '404' );
        }

        return $pathModels;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getViewPath() {
        $conf = $this->_config;
        $pathViews = "{$conf['view']}/{$this->_filename}{$conf['viewFileLatest']}.{$conf['viewExtension']}";
        if ( !file_exists( $pathViews ) ) {
            throw new \Exception( 'File not found! - ' . $pathViews, '404' );
        }

        return $pathViews;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function getBlankViewPath() {
        $conf = $this->_config;
        $pathBlankViews = "{$conf['view']}/{$conf['viewBlank']}{$conf['viewFileLatest']}.{$conf['viewExtension']}";
        if ( !file_exists( $pathBlankViews ) ) {
            throw new \Exception( 'File not found! - ' . $pathBlankViews, '404' );
        }

        return $pathBlankViews;
    }

    /**
     * @return mixed
     */
    public function getFileName() {
        return $this->_filename;
    }

    /**
     * @return string
     */
    public function getFullFileName() {
        return $this->_filename . $this->_config['modelExtension'];
    }

    /**
     * @return string
     */
    public function getHeadPath() {
        return $this->_config['view'] . '/' . $this->_config['headFile'];
    }

    /**
     * @return string
     */
    protected function getMenuRegPath() {
        $conf = $this->_config;
        $pathMenu = "{$conf['menuPath']}/{$conf['menuFileReg']}.{$conf['menuRegExtension']}";
        return $pathMenu;
    }

    /**
     * @return string
     */
    protected function getMenuUnRegPath() {
        $conf = $this->_config;
        $pathMenu = "{$conf['menuPath']}/{$conf['menuFileUnReg']}.{$conf['menuUnRegExtension']}";
        return $pathMenu;
    }

    public function getMainMenu() {
        if ( !is_null( $this->_authorization ) ) {
            return $this->getMenuRegPath();
        }
        return $this->getMenuUnRegPath();
    }


    public function getLayout( $name ) {
        $conf = $this->_config;
        //        $pathLayot = $this->_config['layout'] . '/' . $name . '.' . $this->_config['layoutExtension'];
        $pathLayot = "{$conf['layout']}/$name.{$conf['layoutExtension']}";
        if ( !file_exists( $pathLayot ) ) {
            throw new \Exception( 'File not found! - ' . $pathLayot, '404' );
        }

        return $pathLayot;
    }

    public function getJson( $name ) {
        $conf = $this->_config;
        $pathLayot = "{$conf['json']}/$name.{$conf['jsonExtension']}";
        if ( !file_exists( $pathLayot ) ) {
            throw new \Exception( 'File not found! - ' . $pathLayot, '404' );
        }

        return $pathLayot;
    }

    public function __set( $name, $value ) {
        // TODO: Implement __set() method.
        if ( !isset( $this->container[ $name ] ) ) {
            $this->container[ $name ] = $value;
        } else {
            trigger_error( 'Variable ' . $name . ' already defined', E_USER_WARNING );
        }
    }

    public function __get( $name ) {
        // TODO: Implement __get() method.
        return $this->container[ $name ];
    }

    /**
     * @param mixed $authorization
     */
    public function setAuthorization( $authorization ) {
        $this->_authorization = $authorization;
    }

    /**
     * @return mixed
     */
    public function getAuthorization() {
        return $this->_authorization;
    }

    public function getController() {
        $controler = $this->_config['controllers'];
        if ( !array_key_exists( $this->_conroller, $controler ) ) {
//            var_dump( 'tttttt', $this->_conroller );
            $this->_conroller = 'index';
            $this->_filename = 'index';

        } else {
            $this->_filename = $this->_conroller;
        }
        //        var_dump( $this->getViewPath() );
        return $controler[ $this->_conroller ]['controllerName'];
    }

    /**
     * @return mixed
     */
    public function getAction() {
        $actions = $this->_config['controllers'][ $this->_conroller ]['actions'];
        if ( !is_null( $this->_authorization ) ) {
            return $actions['auth'];
        }
        return $actions['nonAuth'];
    }

    public function getLangv() {
        return $this->_config['LANG'];
    }

}