<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 30.01.2017
 * Time: 11:32
 */

namespace pdo;


class CalcGroup {
    private $_idGroup;
    private $_nameGroup;
    private $_idCell;
    protected $_pdo;
    public function __construct( $numberGroup ) {
        $this->_pdo = \db::getLink()->getDb();
        $this->_idGroup = $numberGroup;
        $this->qNameGroup();
        $this->qIdCell();
    }

    /**
     * @return mixed
     */
    public function getIdGroup(){
        return $this->_idGroup;
    }

    /**
     * @return mixed
     */
    public function getNameGroup(){
        return $this->_nameGroup;
    }

    /**
     * @return array
     */
    public function getIdCell(){
        return $this->_idCell;
    }
    private function qNameGroup(){
        $sq = "SELECt name FROM name_group_counters WHERE id = :id";
        $param = ['id' => $this->_idGroup];
        $res = $this->_pdo->prepare( $sq );
        if(!$res->execute( $param )){
            header("HTTP/1.1 400 Bad Request", true, 400);
            echo exception\JsonError::exitError(false, 3, $this->_pdo->errorInfo());
            exit();
        }
        $this->_nameGroup = $res->fetchAll()[0]['name'];
    }
    private function qIdCell(){
        $param = ['id' => $this->_idGroup];
        $sq = "SELECT id_counter, coefficient FROM group_counters WHERE id_group = :id";
        $res = $this->_pdo->prepare( $sq );
        if(!$res->execute( $param )){
            header("HTTP/1.1 400 Bad Request", true, 400);
            echo exception\JsonError::exitError(false, 1, $pdo->errorInfo());
            exit();
        }
        $this->_idCell = $res->fetchAll();

    }
    private function buldingArrayIn(){

    }

}