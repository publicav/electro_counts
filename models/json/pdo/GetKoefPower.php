<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.01.2017
 * Time: 18:42
 */

namespace pdo;


class GetKoefPower
{
    private  $sq, $param;
    private $res, $koefPower;
    private $visibly = 0;
    private $name_counter;

    function __construct($pdo, $param ) {

        $this->sq = "SELECT x.koef, x.n_counter  FROM	xchange AS x WHERE (x.id_counter = :id) AND (x.n_counter = :n_counter);";
        $this->res = $pdo->prepare( $this->sq );
        if (!$this->res->execute( $param )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        }

        while ($row = $this->res->fetch()) $this->koefPower[$row['n_counter']] = $row['koef'];

        if (empty( $this->koefPower )) {
            header("HTTP/1.1 400 Bad Request", true, 400);
            print exit_error( false, 3, $this->res->errorInfo()[2] );
            exit();
        }

    }
    public function getKoefPowerAll(){
        return $this->koefPower;
    }

}