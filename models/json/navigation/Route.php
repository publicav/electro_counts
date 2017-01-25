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
    public function __construct(){
        if( !file_exists(__DIR__  . "/../../../config/route.conf.php") ) {
            throw new \Exception('Route file  not found! ' . __DIR__  . "/../../config/route.conf.php");
        }
        $this->_config = require_once __DIR__  . "/../../../config/route.conf.php";
        $this->_pathinfo = pathinfo( $_SERVER['SCRIPT_FILENAME'] );
        $this->_filename = $this->_pathinfo['filename'];
    }

    public static function init(){
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
        return self::$_link;
    }
    public function getModelPath(){
        $pathModels = $this->_config['model'] .  '/' . $this->_filename . $this->_config['modelFileLatest'] . '.' .
                      $this->_config['modelExtension'];
        if( !file_exists( $pathModels ) ) {
            throw new Exception('File not found!' . $pathModels, '404');
        }

        return $pathModels;
    }
    public function getViewPath(){
        $pathViews = $this->_config['view'] .  '/' . $this->_filename . $this->_config['viewFileLatest'] . '.' .
                     $this->_config['viewExtension'];
        if( !file_exists( $pathViews ) ) {
            throw new Exception('File not found!' . $pathViews, '404');
        }

        return $pathViews;
    }
    public function getBlankViewPath(){
        $pathBlankViews = $this->_config['view'] .  '/' . $this->_config['viewblank'] . $this->_config['viewFileLatest'] . '.' .
            $this->_config['viewExtension'];
            if( !file_exists( $pathBlankViews ) ) {
                throw new Exception('File not found!' . $pathBlankViews, '404');
            }

        return $pathBlankViews;
    }
    public function getFileName(){
        return $this->_filename;
    }
    public function getFullFileName(){
        return $this->_filename . $this->_config['modelExtension'];
    }
    public function getHeadPath(){
        return $this->_config['view'] .  '/' . $this->_config['headFile'];
    }

}