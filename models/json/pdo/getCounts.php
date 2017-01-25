<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.01.2017
 * Time: 14:17
 */

 namespace pdo;


class getCounts {

    private  $sq;
    private $res, $counts_count;
    private $name_counter;

    /**
     * getCounts constructor.
     * @param $pdo
     * @param $param
     */
    function __construct($pdo, $param ) {

        $this->sq = "SELECT c.id, c.n_counter, c.name FROM  count AS c WHERE (c.id = :id);";
        $this->res = $pdo->prepare( $this->sq );
        if (!$this->res->execute( $param )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        }
        $this->counts_count = $this->res->fetchAll();
        if (empty( $this->counts_count )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        } else {
            for ( $i = 0; $i < count( $this->counts_count ); $i++) {
                $this->name_counter[] = $this->counts_count[$i]['name'];
                unset ( $this->counts_count[$i]['name'] );
            }
        }

    }

    /**
     * @return array
     */
    public function getCountAll() {
        return $this->counts_count;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCountId($id ) {
        return $this->counts_count[ $id ];
    }

    /**
     * @param $id
     * @return String
     */
    public function getName ( $id ){
        return $this->name_counter[ $id ];
    }

}