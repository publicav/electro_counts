<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 25.01.2017
 * Time: 6:47
 */

namespace pdo;


class db {
    protected $_config = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '1234',
        'dbname' => 'electro_count',
        'charset' => "utf8",
        'optimization' => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ];
    protected static $_link = null;
    private $_db;
    public function __construct(){

        $this->_db = new PDO( 'mysql:host=' . $this->_config['host'] . ';dbname=' . $this->_config['dbname'] . ';charset=' . $this->_config['charset'],
                            $this->_config['user'],
                            $this->_config['pass'],
                            $this->_config['optimization']
        );
    }
    public static function getLink(){
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
        return self::$_link;
    }
}