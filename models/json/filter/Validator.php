<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 30.01.2017
 * Time: 7:31
 */

namespace filter;


class Validator {
    protected $_errors = [];
    protected $_rules = [];
    protected $_fields = [];
    protected $_data = [];

    public function __construct( $data, $rules ) {
        $this->_data = $data;
        $this->_rules = $rules;

        $this->_fields = array_keys( $rules );
    }

    /**
     * @return array
     */
    public function getFields() {
        return $this->_fields;
    }

    protected function required( $field ) {
        if ( empty( $this->_data[ $field ] ) ) {
            $this->addError( $field, 'field must be set' );
        }

    }

    protected function isPositive( $field ) {
        $positive = (int)$this->_data[ $field ];
        if ( $positive <= 0 ) {
            $this->addError( $field, 'Number is not positive!' );
        }

    }

    public function addError( $field, $error ) {
        $this->_errors[ $field ] = $error;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->_errors;
    }

    public function getError( $key ) {
        if ( array_key_exists( $key, $this->_errors ) ) return $this->_errors[ $key ];
    }

    public function validateThis() {
        foreach ( $this->_rules as $field => $rules ) {
            foreach ( $rules as $rule ) {
                if ( method_exists( $this, $rule ) ) {
                    if ( is_null( $this->getError( $field ) ) ) {
                        $this->$rule( $field );
                    }
                } else {
                    throw new \Exception( 'Error metod not found!' );
                }
            }
        }
        if ( !empty( $this->_errors ) ) {
            return false;
        }
        return true;

    }

}