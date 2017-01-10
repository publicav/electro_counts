<?php
// namespace models\json\pdo\GetUser;
class GetUser { 
    public $user;
    private $id, $sq, $param;
    private $user_a;
    function __construct( $pdo, $id ) {
        $this->id = $id;
        $this->sq = "SELECT name, family FROM users WHERE (id= :id );"; 
        $param = array ('id' => $this->id ); 
        $res = $pdo->prepare( $this->sq );
        if ($res->execute( $param )) {
        $this->user_a = $res->fetchAll();
        } else {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $res->errorInfo()[2] );
            exit();
        }
        $this->user = $this->user_a[0];
    }   
}?>