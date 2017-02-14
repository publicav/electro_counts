<?php
namespace filter;
class FilterInput {
    private $resultArr;

    public function __construct( $inputArr ) {
        foreach ( $inputArr as $key => $value ) {
            $key = filter_var( $key, FILTER_SANITIZE_STRING );
            $value = filter_var( $value, FILTER_SANITIZE_STRING );
            $this->resultArr[ $key ] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getInputAll() {
        return $this->resultArr;
    }

    /**
     * @param $key
     * @return null
     */
    public function __get( $key ) {
        if ( isset( $this->resultArr[ $key ] ) ) {
            return $this->resultArr[ $key ];
        }
        return null;
    }

    public function getInt( $key ) {
        if ( isset( $this->resultArr[ $key ] ) ) {
            return intval( $this->resultArr[ $key ] );
        }
        return null;
    }

    public function getDate( $key ) {
        if ( isset( $this->resultArr[ $key ] ) ) {
            return  $this->resultArr[ $key ] ;
        }
        return null;
    }

}
