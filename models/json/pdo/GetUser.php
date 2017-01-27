<?php
namespace pdo;
class GetUser { 
    public $user;
    private  $sq;
    private  $res;
    private static $_link;
    private $_pdo;
    /**
     * GetUser constructor.
     * @param $id
     */
    function __construct( $id ) {
        $this->_pdo = \db::getLink()->getDb();
        $this->sq = "SELECT name, family FROM users WHERE (id= :id );";
        $param = [ 'id' => $id ];
        $this->res = $this->_pdo->prepare( $this->sq );
        if ( !$this->res->execute( $param ) ) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print  $this->res->errorInfo()[2];
            exit();
        }
        $user_a = $this->res->fetchAll();
        if ( !empty( $user_a ) ) $this->user = $user_a[0];
    }


    /**
     * @param $id
     * @return array $user
     */
    public static function GetUser( $id ) {
        if ( is_null( self::$_link ) ){
            self::$_link = new self( $id );
        }
        return self::$_link->user;

    }
}
