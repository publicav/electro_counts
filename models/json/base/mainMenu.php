<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2017
 * Time: 19:30
 */

namespace base;


class mainMenu{
    protected $_menu;
    protected $_menuArray;
    public function __construct( $pathJson ){
        $this->openFile( $pathJson );
        $this->_menuArray = $this->stdToArray();

    }

    /**
     * @param $file
     * @throws \Exception
     */
    protected  function openFile($file ){
        if (!file_exists( $file )) {
            throw new \Exception('File not found! - ' . $file, '404');
        }
        $json = file_get_contents( $file );
        $this->_menu = json_decode( $json );

    }
    protected function stdToArray(){
        $rc = (array)$this->_menu;
        foreach($rc as $key => &$field){
            if(is_object($field))$field = $this->stdToArray($field);
        }
        return $rc;
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        return $this->_menuArray['menu'];
    }




}