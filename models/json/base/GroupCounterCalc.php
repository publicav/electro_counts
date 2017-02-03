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
            $this->_bisectionCounter( $timeStamp );
            //            var_dump( $timeStamp );
            $dtCurrent->add( new \DateInterval( 'P1D' ) );
        }
    }

    private function _bisectionCounter( $timeStamp ) {
        foreach ( $this->_sortData as $key => $sortDataCount ) {
            //            var_dump( $key );
            $this->_bisection( $timeStamp, $sortDataCount );
            $test = [ 1, 2, 3, 4, 5 ];
            var_dump( (int)( count( $test ) / 2 ) );
        }
    }

    private function _bisection( $timeStamp, $counter ) {
        $index = count( $counter );
        //        var_dump($counter[ $index - 1 ]['date_second']  );
        if ( $index <= 2 ) {
            $retIndex = [ 'error' => 1, 'index1' => null, 'index2' => null ];
            return $retIndex;
        }
        if ( $timeStamp >= $counter[ $index - 1 ]['date_second'] ) {
            $retIndex = [ 'error' => 0, 'index1' => $index - 2, 'index2' => $index - 1 ];
            return $retIndex;
        }
        if ( $timeStamp <= $counter[0]['date_second'] ) {
            $retIndex = [ 'error' => 0, 'index1' => 0, 'index2' => 1 ];
            return $retIndex;
        }
        $index = ( ( $index - 1 ) / 2 );
        var_dump( $index );
        //        while ( 1 ) {
        //            if ( ( $timeStamp <= $counter[ $index ] ) and ( $timeStamp >= $counter[ $index - 1 ] ) ) {
        //                break;
        //            }
        //
        //        }

    }

}