<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 30.01.2017
 * Time: 11:32
 */

namespace pdo;

use exception\JsonError;
use exception\BadRequestException;


class CalcGroup {
    private $_idGroup;
    private $_nameGroup;
    private $_idCells, $_nameCouter;
    private $_inSQL;
    protected $_pdo;


    public function __construct( $numberGroup ) {
        $this->_pdo = \db::getLink()->getDb();
        $this->_idGroup = $numberGroup;
        $this->qNameGroup();
        $this->qIdCell();
        $this->buldingSQlIn();
        $this->qNameCell();
    }

    /**
     * @return mixed
     */
    public function getIdGroup() {
        return $this->_idGroup;
    }

    /**
     * @return mixed
     */
    public function getNameGroup() {
        return $this->_nameGroup;
    }

    /**
     * @return array
     */
    public function getIdCell() {
        return $this->_idCells;
    }

    /**
     * @return mixed
     */
    public function getInSQL() {
        return $this->_inSQL;
    }

    /**
     * @return mixed
     */
    public function getNameCouter() {
        return $this->_nameCouter;
    }

    private function qNameGroup() {
        $sq = "SELECt name FROM name_group_counters WHERE id = :id";
        $param = [ 'id' => $this->_idGroup ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo() );
        }
        $nameGroup = $res->fetchAll();
        if ( empty( $nameGroup ) ) {
            throw new BadRequestException( 'Group not found!' );
        }
        $this->_nameGroup = $nameGroup[0]['name'];
    }

    private function qNameCell() {
        $sq = "SELECt name FROM count WHERE id IN {$this->getInSQL()}";
        //        $param = [ 'id' => $this->_idGroup ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo() );
        }
        $nameCouter = $res->fetchAll();
        if ( empty( $nameCouter ) ) {
            throw new BadRequestException( 'Group not found!' );
        }
        $this->_nameCouter = $nameCouter;

    }

    private function qIdCell() {
        $param = [ 'id' => $this->_idGroup ];
        $sq = "SELECT id_counter AS id, coefficient FROM group_counters WHERE id_group = :id";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo() );
        }
        $this->_idCells = $res->fetchAll();
        if ( empty( $this->_idCells ) ) {
            throw new BadRequestException( 'Cells not found!' );
        }

    }

    private function buldingSQlIn() {
        $in_sql = '(';
        foreach ( $this->_idCells as $cell ) {
            $in_sql .= $cell['id'] . ',';
        }
        $in_sql = trim( $in_sql, ',' );
        $in_sql .= ')';
        $this->_inSQL = $in_sql;
    }


}