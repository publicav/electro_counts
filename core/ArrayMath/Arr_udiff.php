<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 20.03.2017
 * Time: 23:21
 */

namespace ArrayMath;


class Arr_udiff {
    protected $_arr1;
    protected $_arr2;
    protected $_result;
    protected static $_link;

    /**
     * Arr_udiff constructor.
     * @param array $arr1
     * @param array $arr2
     */
    public function __construct( array $arr1, array $arr2 ) {
        $this->_arr1 = $arr1;
        $this->_arr2 = $arr2;
    }

    public static function init( array $arr1, array $arr2 ) {
        if ( is_null( self::$_link ) ) {
            self::$_link = new self( $arr1, $arr2 );
        }
        return self::$_link;
    }

    public function doRun() {
        $arr1Id = array_column( $this->_arr2, 'id' );
        $arr1 = $this->_arr1;
        $lengthArr1 = count( $arr1 );

        for ( $j = 0; $j < $lengthArr1; $j++ ) {
            $findValueArr1 = $arr1[ $j ]['id'];
            $index = array_search( $findValueArr1, $arr1Id );
            if ( $index === false ) {
                $result[] = $arr1[ $j ];
            }
        }
        $this->_result = $result;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult() {
        return $this->_result;
    }

}