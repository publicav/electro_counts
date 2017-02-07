<?php
namespace pdo;
class Lots {
    const lotsFilter = [ 'id' => '0', 'name' => 'Все участки' ];
    private $_lots;
    private $_lotsFilter;
    private $_filter = false;

    private static $_link;

    function __construct() {
        $pdo = \db::getLink()->getDb();
        $sq = "SELECT l.id, l.name FROM  lots AS l;";
        $res = $pdo->prepare( $sq );
        if ( !$res->execute() ) {
            header( "HTTP/1.1 400 Bad Request", true, 400 );
            print exit_error( false, 3, $res->errorInfo()[2] );
            exit();
        }
        $this->_lots = $res->fetchAll();
    }

    /**
     * @return array $lots
     */
    public static function GetLots() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        return self::$_link->_lots;
    }

    /**
     * @return array
     */
    public static function GetLotsFilter() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        return array_merge( [ self::lotsFilter ], self::$_link->_lots );

    }

    /**
     * @return Lots
     */
    public static function lotsFilter() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        self::$_link->_filter = true;
        self::$_link->_lotsFilter = array_merge( [ self::lotsFilter ], self::$_link->_lots );
        return self::$_link;
    }

    /**
     * @return Lots
     */
    public static function lots() {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self();
        }
        self::$_link->_filter = false;
        return self::$_link;
    }

    /**
     *
     */
    public function render() {
        if ( $this->_filter ) $lots = $this->_lotsFilter; else $lots = $this->_lots;
        $lotsHTML = '';
        $countLots = count( $lots );
        for ( $i = 0; $i < $countLots; $i++ ) {
            $lotsHTML .= "<option value=\"{$lots[$i]['id']}\">{$lots[$i]['name']}</option>";
        }
        echo $lotsHTML;

    }

}
