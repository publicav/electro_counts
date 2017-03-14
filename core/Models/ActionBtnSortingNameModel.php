<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 14.03.2017
 * Time: 8:36
 */

namespace Models;


use Base\BaseModel;

class ActionBtnSortingNameModel extends BaseModel {
    public $sort;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'sort' => [ 'required', ],
        ];
    }

    public function doActionBtnSortingName() {
        $sort = explode( ',', $this->sort );

        $sq = "SELECT * FROM  name_group_counters AS main;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $nameGroupArr = $res->fetchAll();
        if ( empty( $nameGroupArr ) ) $nameGroupArr = [];
        $sqlVal = '';
        foreach ( $nameGroupArr as &$row ) {
            $index = array_search( $row['id'], $sort );
            if ( $index !== false ) {
                $row['sort'] = $index;
            }
            $sqlVal .= "('" . implode( "','", $row ) . "'),";
        }
        $sqlVal = trim( $sqlVal, ',' );

        $sq = "REPLACE INTO name_group_counters (id, name, visibly, sort) 
		           VALUES $sqlVal;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }


        $this->result = [
//            'sort'      => $sort,
//            'nameGroup' => $nameGroupArr,
            'sqlVal'    => $sq,
        ];
        return true;
    }
}