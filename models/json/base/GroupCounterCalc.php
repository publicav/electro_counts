<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 20:53
 */

namespace base;

use pdo\GroupCounterData;
use date\DivisionDay;

class GroupCounterCalc {
    private $_dataGroup;
    private $_dateLow, $_dateHigh;
    private $_nameGroup;
    private $_inputSqlData;
    private $_sortData;
    private $_cnIndex;
    private $_calcData;

    public function __construct( $numberGroup, $dateLow, $dateHigh ) {
        $this->_dateLow = $dateLow;
        $this->_dateHigh = $dateHigh;
        $this->_dataGroup = GroupCounterData::init( $numberGroup );
        $this->_dataGroup->queryGroup( $dateLow, $dateHigh );
        $this->_nameGroup = $this->_dataGroup->getNameGroup();
        $this->_inputSqlData = $this->_dataGroup->getSqlData();
        $this->_sortArray();
        $this->_bustDays();
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
        //        var_dump( $this->_sortData );
    }

    private function _bustDays() {
        $dtHigh = new \DateTime( $this->_dateHigh );
        $dtCurrent = new \DateTime( $this->_dateLow );
        while ( $dtCurrent <= $dtHigh ) {
            $timeStamp = $dtCurrent->getTimestamp();
            $this->_bisectionCounters( $timeStamp );
            $this->_calc();
            //            var_dump( $cnIndex );
            $dtCurrent->add( new \DateInterval( 'P1D' ) );
        }
    }

    private function _bisectionCounters( $timeStamp ) {
        foreach ( $this->_sortData as $key => $sortDataCount ) {
            $retIndex[ $key ] = $this->_bisection( $timeStamp, $sortDataCount );
            //            var_dump( $retIndex, date( 'Y-m-d h:i:s', $timeStamp ),
            //                $sortDataCount[ $retIndex['index1'] ], $sortDataCount[ $retIndex['index2'] ] );
        }
        $this->_cnIndex = $retIndex;
    }

    private function _bisection( $timeStamp, $counter ) {
        $index = count( $counter ) - 1;
        //        var_dump( $counter[ $index ] );
        if ( $index <= 2 ) {
            $retIndex = [ 'error' => 1, 'index1' => null, 'index' => null, 'index2' => null ];
            return $retIndex;
        }
        if ( $timeStamp >= $counter[ $index ]['date_second'] ) {
            $retIndex = [ 'error' => 0, 'index1' => $index - 1, 'index' => 0, 'index2' => $index ];
            return $retIndex;
        }
        if ( $timeStamp <= $counter[0]['date_second'] ) {
            $retIndex = [ 'error' => 0, 'index1' => 0, 'index' => 0, 'index2' => 1 ];
            return $retIndex;
        }
        $index = (int)( $index / 2 );
        $position = $index;
        $count = 0;
        while ( 1 ) {
            $timeInd = $counter[ $position ]['date_second'];
            $timeInd1 = $counter[ $position - 1 ]['date_second'];
            //            var_dump( $position, $timeStamp / 100 / 1000, $timeInd / 100 / 1000 );
            if ( ( $timeStamp <= $timeInd ) and ( $timeStamp >= $timeInd1 ) ) {
                break;
            }
            $index = (int)( $index / 2 );
            if ( $timeStamp <= $timeInd ) {
                $position = $position - $index;
            } else {
                $position = $position + $index;
            }
            if ( $count >= 11 ) break;
            $count++;
        }
        return [ 'error' => 0, 'indexLow' => $position - 1, 'index' => $position, 'indexHigh' => $position + 1 ];
    }

    protected function _calc() {
        //        $indexLow = $
        foreach ( $this->_sortData as $key => $sortDataCount ) {
            $indexArr = $this->_cnIndex[ $key ];
            $indexLow = $indexArr['indexLow'];
            $indexHigh = $indexArr['indexHigh'];
            $index = $indexArr['index'];

            $DivisionDay = new DivisionDay( $sortDataCount[ $index ]['dt1'] );

            var_dump( $DivisionDay );
        }
    }
}