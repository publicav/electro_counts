<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.01.2017
 * Time: 14:17
 */

// namespace select;


class getCounts {

    private  $sq, $param;
    private $res, $counts_count;
    private $visibly = 0;
    private $name_counter, $colum;
    function __construct( $pdo, $param ) {

        $this->sq = "SELECT c.id, c.n_counter, c.name FROM  count AS c WHERE (c.id = :id);";
        $this->param = $param;
        $this->res = $pdo->prepare( $this->sq );
        if (!$this->res->execute( $this->param )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        }
        $this->counts_count = $this->res->fetchAll();
        if (empty( $counts_count )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        } else {
            foreach ( $this->name_counter as $this->colum) {
                $this->name_counter[] = $this->colum['name'];
                unset( $this->colum['name'] );

            }
        }

    }
    public function getCountAll() {
        return $this->counts_count;
    }
    public function getCountId( $id ) {
        return $this->counts_count[ $id ];
    }
    public function getName ( $id ){
        return $this->name_counter[ $id ];
    }

}