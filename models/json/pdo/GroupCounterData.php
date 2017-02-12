<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 30.01.2017
 * Time: 11:32
 */

namespace pdo;

use exception\BadRequestException;

class GroupCounterData {
    private $_idGroup;
    private $_nameGroup;
    private $_counterGroup;
    private $_CoeffPower;
    private $_idCells, $_nameCouter;
    private $_inSQL;
    protected $_pdo;
    protected $_data;
    protected $_sqlData;
    private static $_link;


    public function __construct( $numberGroup ) {
        $this->_pdo = \db::getLink()->getDb();
        $this->_idGroup = $numberGroup;
        $this->qNameGroup();
        $this->qIdCell();
        $this->qDataCell();
        $this->qCoeeffPower();
        $this->creteInputData();
    }

    public static function init( $numberGroup ) {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self( $numberGroup );
        }
        return self::$_link;

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
     * @return mixed
     */
    public function getCounterGroup() {
        return $this->_counterGroup;
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

    /**
     * @return mixed
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * @return mixed
     */
    public function getSqlData() {
        return $this->_sqlData;
    }


    /**
     * @param $id_counter
     * @param $n_counter
     * @return $coefficient
     */
    public function getCoeffPower( $id_counter, $n_counter ) {
        return $this->_data[ $id_counter ][ $n_counter - 1 ]['coeffPower'];
    }

    private function qNameGroup() {
        $sq = "SELECt name FROM name_group_counters WHERE id = :id";
        $param = [ 'id' => $this->_idGroup ];
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $nameGroup = $res->fetchAll();
        if ( empty( $nameGroup ) ) {
            throw new BadRequestException( 'Group not found!' );
        }
        $this->_nameGroup = $nameGroup[0]['name'];
    }

    private function qIdCell() {
        $param = [ 'id' => $this->_idGroup ];
        $sq = "SELECT id_counter AS id, coefficient FROM group_counters WHERE id_group = :id";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->_idCells = $res->fetchAll();
        if ( empty( $this->_idCells ) ) {
            throw new BadRequestException( 'Cells not found!' );
        }
    }

    private function qDataCell() {
        $this->buldingSQlIn();
        $sq = "SELECt id,  name FROM count WHERE id IN {$this->getInSQL()}";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $couterGroup = $res->fetchAll();
        if ( empty( $couterGroup ) ) {
            throw new BadRequestException( 'Counters in Group not found!' );
        }
        $this->_counterGroup = $couterGroup;
    }

    private function qCoeeffPower() {
        $sq = "SELECT id_counter, n_counter, koef FROM xchange WHERE id_counter IN {$this->getInSQL()}";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $coefPower = $res->fetchAll();
        if ( empty( $coefPower ) ) {
            throw new BadRequestException( 'Coefficients Power  not found!' );
        }
        $this->_CoeffPower = $coefPower;
    }

    public function queryGroup( $dateLow, $dateHigh ) {
        $dateLow .= ' 00:00:00';
        $dateHigh .= ' 23:59:59';
        $param = [ 'dateLow' => $dateLow, 'dateHigh' => $dateHigh ];
        $sq = "SELECT main.id_counter, main.value AS value, UNIX_TIMESTAMP(main.date_create)  AS date_second, 
                   main.date_create AS dt1, main.n_counter
			FROM counter_v AS main
            WHERE (main.id_counter IN  {$this->getInSQL()}) AND  main.date_create BETWEEN :dateLow AND :dateHigh
			ORDER by date_create;
			";
        //        (main.id_counter IN  {$this->getInSQL()}) AND
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $sqlData = $res->fetchAll();
//        var_dump($sqlData);
        $allowAll = array();
        $bellowAll = array();
        foreach ( $this->_counterGroup as $cell ) {
            $allow = $this->qAllow( $cell['id'], $dateHigh );
            $bellow = $this->qBellow( $cell['id'], $dateLow );
            //var_dump($cell);
            if ( !empty( $allow ) ) $allowAll = array_merge( $allowAll, $allow );
            if ( !empty( $bellow ) ) $bellowAll = array_merge( $bellowAll, $bellow );
        }
//        var_dump($bellowAll);
        if ( is_array( $sqlData ) ) {
            $this->_sqlData = array_merge( $bellowAll, $sqlData, $allowAll );

        } else {
            $this->_sqlData = array_merge( $bellowAll, $allowAll );
        }
        //        var_dump($this->_sqlData);
    }

    private function qAllow( $count, $dateHigh ) {
        $param = [ 'id_counter' => $count, 'dateHigh' => $dateHigh ];
        $sq = "SELECT main.id_counter, main.value AS value, UNIX_TIMESTAMP(main.date_create)  AS date_second, 
                   main.date_create AS dt1, main.n_counter
			FROM counter_v AS main
            WHERE (main.id_counter = :id_counter) AND  (main.date_create > :dateHigh)
			ORDER BY date_create
			LIMIT 3;
			";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        return $res->fetchAll();
    }

    private function qBellow( $count, $dateLow ) {
        $param = [ 'id_counter' => $count, 'dateLow' => $dateLow ];
        $sq = "SELECT main.id_counter, main.value AS value, UNIX_TIMESTAMP(main.date_create)  AS date_second, 
                   main.date_create AS dt1, main.n_counter
			FROM counter_v AS main
            WHERE (main.id_counter = :id_counter) AND  (main.date_create < :dateLow)
			ORDER BY date_create DESC 
			LIMIT 3;
			";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $bll = $res->fetchAll();
        if ( !empty( $bll ) ) $bll = array_reverse( $bll );
        return $bll;

    }

    private function creteInputData() {
        $this->_data = [];
        foreach ( $this->_idCells as $cell ) {
            $key = $cell['id'];
            $this->_data[ $key ] = [ 'coefficient' => $cell['coefficient'] ];
        }
        foreach ( $this->_counterGroup as $cell ) {
            $key = $cell['id'];
            $this->_data[ $key ] = array_merge( $this->_data[ $key ], [ 'name' => $cell['name'] ] );
        }
        foreach ( $this->_CoeffPower as $cell ) {
            $key = $cell['id_counter'];
            $n_counter = $cell['n_counter'];
            $coeffPower = [ $n_counter => [ 'coeffPower' => $cell['koef'] ] ];
            $this->_data[ $key ] = array_merge( $this->_data[ $key ], $coeffPower );
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