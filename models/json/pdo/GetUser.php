<?php
namespace pdo;
class GetUser { 
    public $user;
    private $id, $sq, $param;
    private $user_a, $res;

    /**
     * GetUser constructor.
     * @param $pdo
     * @param $id
     */
    function __construct($pdo, $id ) {
        $this->id = $id;
        $this->sq = "SELECT name, family FROM users WHERE (id= :id );"; 
        $param = array ('id' => $this->id ); 
        $this->res = $pdo->prepare( $this->sq );
        if ($this->res->execute( $param )) {
			$this->user_a = $this->res->fetchAll();
        } else {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print  $this->res->errorInfo()[2];
            exit();
        }
        if ( !empty( $this->user_a ) ) $this->user = $this->user_a[0];
    }

    /**
     * @return array
     */
    function GetUser() {
		return $this->user;
	}
}
