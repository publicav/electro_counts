<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 20:53
 */

namespace base;

use date\DivisionDay;
use pdo\GroupCounterData;

class GroupCounterCalc {
    const MAX_ITERACION = 11;
    const MINUTE_DAY = 1440;
    private $_dataGroup;
    private $_dateLow, $_dateHigh;
    private $_nameGroup;
    private $_inputSqlData;
    private $_sortData;
    private $_cnIndex;
    private $_calcData;
    private $_legend;

    public function __construct( $numberGroup, $dateLow, $dateHigh ) {
        $this->_dateLow = $dateLow;
        $this->_dateHigh = $dateHigh;
        $this->_dataGroup = GroupCounterData::init( $numberGroup );
        $this->_dataGroup->queryGroup( $dateLow, $dateHigh );
        $this->_nameGroup = $this->_dataGroup->getNameGroup();
        $this->_inputSqlData = $this->_dataGroup->getSqlData();
        $this->_legend = $this->_dataGroup->getData();
        //        var_dump( $this->_dataGroup->getData() );
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

    /**
     * @return mixed
     */
    public function getLegend() {
        return $this->_legend;
    }

    /**
     * @return mixed
     */
    public function getCalcData() {
        return $this->_calcData;
    }

    private function _sortArray() {
        $sortData = [];
        $countInputData = count( $this->_inputSqlData );
        for ( $i = 0; $i < $countInputData; $i++ ) {
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
        $dtCurrent = new \DateTime( $this->_dateLow . ' 00:00:00' );
        while ( $dtCurrent <= $dtHigh ) {
            $timeStamp = $dtCurrent->getTimestamp();
            $this->_bisectionCounters( $timeStamp );

            $_calc = $this->_calc( $timeStamp );
            $_calc['date'] = $dtCurrent->format( 'd-m-Y' );
            $this->_calcData[] = $_calc;
            //                        var_dump( $_calc );7
            $dtCurrent->add( new \DateInterval( 'P1D' ) );
        }
        //                var_dump( $this->_calcData );
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
            return [ 'position' => 1, 'index1' => null, 'index' => null, 'index2' => null ];
        }
        if ( $timeStamp >= $counter[ $index ]['date_second'] ) {
            return [ 'position' => 2, 'index1' => $index - 1, 'index' => 0, 'index2' => $index ];
        }
        if ( $timeStamp <= $counter[0]['date_second'] ) {
            return [ 'position' => 3, 'index1' => 0, 'index' => 0, 'index2' => 1 ];
        }
        $index = (int)( $index / 2 );
        $position = $index;
        $count = 0;
        while ( 1 ) {
            $timeInd = $counter[ $position ]['date_second'];
            $timeInd1 = $counter[ $position - 1 ]['date_second'];

            if ( ( $timeStamp <= $timeInd ) and ( $timeStamp >= $timeInd1 ) ) {
                break;
            }
            $index = (int)( $index / 2 );
            if ( $timeStamp <= $timeInd ) {
                $position = $position - $index;
            } else {
                $position = $position + $index;
            }
            if ( $count >= self::MAX_ITERACION ) break;
            $count++;
        }
        return [ 'position' => 0, 'indexLow' => $position - 1, 'index' => $position, 'indexHigh' => $position + 1 ];
    }

    protected function _calc( $timeStamp ) {
        $keys = array_keys( $this->_sortData );
        $powerAll = 0;
        foreach ( $keys as $key ) {
            $indexArr = $this->_cnIndex[ $key ];
            switch ( $indexArr['position'] ) {
                case 0:
                    $_power = $this->_powerDay( $timeStamp, $indexArr, $key );
                    break;
                case 1:
                    $_power = 0;
                    break;
                case 2:
                    $_power = 0;
                    break;
                case 3:
                    $_power = 0;
                    break;
                default:
                    $_power = 0;
            }
            $power[ $key ] = $_power * $this->_legend[ $key ]['coefficient'];
            $powerAll = $powerAll + $power[ $key ];
            //            var_dump( $this->_legend[ $key ]['coefficient'] );
        }
        $power['sumDay'] = $powerAll;
        return $power;
    }

    protected function _powerDay( $timeStamp, $indexArr, $key ) {

        $indexLow = $indexArr['indexLow'];
        $countLow = $this->_sortData[ $key ][ $indexLow ];
        $indexHigh = $indexArr['indexHigh'];
        $countHigh = $this->_sortData[ $key ][ $indexHigh ];
        $index = $indexArr['index'];
        $countCurrent = $this->_sortData[ $key ][ $index ];
        $coeff1 = $this->_dataGroup->getCoeffPower( $key, $countCurrent['n_counter'] );

        //todo-me добавить  coeff2 если будет переход на другой счетчик. Пока переход на другой счетчик не релизован

        $DivisionDay = new DivisionDay( $countCurrent['dt1'] );

        if ( $DivisionDay->is_day( $timeStamp ) ) {
            $diffTime1 = round( ( $countCurrent['date_second'] - $countLow['date_second'] ) / 60 );
            $diffTime2 = round( ( $countHigh['date_second'] - $countCurrent['date_second'] ) / 60 );

            $diffValue1 = ( $countCurrent['value'] - $countLow['value'] ) * $coeff1;
            $diffValue2 = ( $countHigh['value'] - $countCurrent['value'] ) * $coeff1;

            $diffPower1 = $diffValue1 / $diffTime1;
            $diffPower2 = $diffValue2 / $diffTime2;

            $power = $diffPower1 * $DivisionDay->getBefore() + $diffPower2 * $DivisionDay->getAfter();

            //            var_dump( $countLow, $countCurrent, $countHigh );
            //            var_dump( $diffTime1, $diffTime2 );
            //            var_dump( $diffValue1, $diffValue2 );
            //            var_dump( $diffPower1, $diffPower2 );
            //            var_dump($power);

        } else {
            $diffTime1 = round( ( $countCurrent['date_second'] - $countLow['date_second'] ) / 60 );
            $diffValue1 = ( $countCurrent['value'] - $countLow['value'] ) * $coeff1;
            $diffPower1 = $diffValue1 / $diffTime1;
            $power = $diffPower1 * self::MINUTE_DAY;

        }
        return $power;

    }
}