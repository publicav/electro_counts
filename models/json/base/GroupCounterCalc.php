<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 20:53
 */

namespace base;

use pdo\GroupCounterData;

class GroupCounterCalc {
    private $_dataGroup;
    private $_dateLow, $_dateHigh;
    private $_nameGroup;
    private $_inputSqlData;
    private $_sortData;
    private $_calcData;

    public function __construct( $numberGroup, $dateLow, $dateHigh ) {
        $this->_dateLow = $dateLow;
        $this->_dateHigh = $dateHigh;
        $this->_dataGroup = GroupCounterData::init( $numberGroup );
        $this->_dataGroup->queryGroup( $dateLow, $dateHigh );
        $this->_nameGroup = $this->_dataGroup->getNameGroup();
        $this->_inputSqlData = $this->_dataGroup->getSqlData();
        $this->_sortArray();
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
    public function getSortData() {
        return $this->_sortData;
    }

    private function _sortArray() {
        $sortData = [];
        for ( $i = 0; $i < count( $this->_inputSqlData ); $i++ ) {
            $row = $this->_inputSqlData[ $i ];
            $counter = $row['id_counter'];
            if ( !array_key_exists( $counter, $sortData ) ) $sortData[ $counter ] = array();
            unset( $row['id_counter'] );
            $sortData[ $counter ][] = $row;
        }
        $this->_sortData = $sortData;
        var_dump( $this->_sortData );
    }

}