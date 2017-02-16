<?php
/**
 * Created by PhpStorm.
 * User: mama
 * Date: 16.02.2017
 * Time: 17:28
 */

namespace base;

use \pdo\Privelege;
Use \pdo\GetMenuLeft;

class LeftMenu {
    protected $_privelege;
    protected $_getMenuLeft;
    protected $_sqlData = null;

    public function __construct( Privelege $privelege, GetMenuLeft $getMenuLeft ) {
        $this->_privelege = $privelege;
        $this->_getMenuLeft = $getMenuLeft;
    }

    public function getDataForm() {
        $priv = $this->_privelege->getPriv();
        $menuLeftData = $this->_getMenuLeft->getMenuLeftData();
        $countPriv = count( $priv );
        $countLeftMenu = count( $menuLeftData );

        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            for ( $j = 0; $j < $countPriv; $j++ ) {
                if ( ( $menuLeftData[ $i ]['id_menu'] == $priv[ $j ]['id_menu'] ) AND ( $priv[ $j ]['visibly'] == 1 ) ) {
                    $menuLeftData[ $i ]['checked'] = 'checked="checked"';
                    break;
                }
            }
            $menuLeftFormPriv[] = $menuLeftData[ $i ];
        }
        return $menuLeftFormPriv;

    }

    public function setSqlData( array $dataCheck ) {
        $id_user = $this->_privelege->getId();
        $menuLeftData = $this->_getMenuLeft->getMenuLeftData();
        $countLeftMenu = count( $menuLeftData );

        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            $sqlData[] = [ 'id_users' => "'$id_user'",
                           'id_menu'  => "'{$menuLeftData[ $i ]['id_menu']}'",
                           'visibly'  => "'{$dataCheck[ $i ]}'",
            ];
        }
        $this->_sqlData = $sqlData;
    }

    /**
     * @return mixed
     */
    public function getSqlData() {
        return $this->_sqlData;
    }

    public function getSqlFields() {
        $countSqlData = count( $this->getSqlData() );
        if ( $countSqlData == 0 ) return null;
        return implode( ',', array_keys( $this->getSqlData()[0] ) );
    }

    public function getSqlFieldsReplace() {
        return 'id,' . $this->getSqlFields();
    }

    public function getSqlValues() {
        $sqlData = $this->getSqlData();
        $countSqlData = count( $sqlData );
        $privelege_var = '';
        for ( $i = 0; $i < $countSqlData; $i++ ) {
            $row = '(' . implode( ',', $sqlData[ $i ] ) . '),';
            $privelege_var .= $row;
        }
        $privelege_var = trim( $privelege_var, ',' );
        return $privelege_var;

    }

    public function getSqlValuesReplace() {
        $priv = $this->_privelege->getPriv();
        $sqlData = $this->getSqlData();
        $countPriv = count( $priv );
        $countSqlData = count( $sqlData );
        $privelege_var = '';
        for ( $i = 0; $i < $countPriv; $i++ ) {
            $row = '(' . "'{$priv[$i]['id']}'," . implode( ',', $sqlData[ $i ] ) . '),';
            $privelege_var .= $row;
        }
        for ( $j = $i; $i < $countSqlData; $i++ ) {
            $row = '(' . "NULL," . implode( ',', $sqlData[ $j ] ) . '),';
            $privelege_var .= $row;
        }

        $privelege_var = trim( $privelege_var, ',' );
        return $privelege_var;
    }
}