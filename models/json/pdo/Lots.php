<?php
namespace pdo;
class Lots { 
    private  $sq;
    private $res, $lots;
	private $_pdo;
	private static $_link;

    function __construct() {
        $this->_pdo = \db::getLink()->getDb();
		$this->sq = "SELECT l.id, l.name FROM  lots AS l;";
		$this->res = $this->_pdo->prepare( $this->sq );
		if ( !$this->res->execute() ) {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
        $this->lots = $this->res->fetchAll();
    }

    /**
     * @return array $lots
     */
    public static function  GetLots() {
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
        return self::$_link->lots;
	}

    /**
     * @return array
     */
    public static function GetLotsFilter() {
        if ( is_null( self::$_link ) ){
            self::$_link = new self();
        }
		$lotsFilter[] = [ 'id' => '0', 'name' => 'Все участки' ];
		return  array_merge( $lotsFilter, self::$_link->lots );
//		var_dump(self::$_link->lots);
	}

}
