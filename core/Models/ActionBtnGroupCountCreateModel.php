<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.03.2017
 * Time: 6:56
 */

namespace Models;


use Base\BaseModel;
use Exception\InputException;

class ActionBtnGroupCountCreateModel extends BaseModel {
    public $id_group;
    public $group_plus;
    public $group_minus;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id_group'    => [ 'required', 'isPositive', ],
            'group_plus'  => [ 'required', ],
            'group_minus' => [ 'required', ],

        ];
    }

    public function doActionBtnGroupCountCreate() {
        $sortPlus = null;
        $sortMinus = null;
        $id_group = $this->id_group;

        if ( !empty( $this->group_plus ) ) {
            $sortPlus = explode( ',', $this->group_plus );
        }
        if ( !empty( $this->group_minus ) ) {
            $sortMinus = explode( ',', $this->group_minus );
        }
        $lengthPlus = count( $sortPlus );
        $lengthMinus = count( $sortMinus );

        $sqlVal = '';
        for ( $i = 0; $i < $lengthPlus; $i++ ) {
            $sqlVal .= "(NULL, '$id_group', '{$sortPlus[$i]}','1'),";
        }
        for ( $i = 0; $i < $lengthMinus; $i++ ) {
            $sqlVal .= "(NULL, '$id_group', '{$sortMinus[$i]}','-1'),";
        }
        $sqlVal = trim( $sqlVal, ',' );

        $param = [ 'id_group' => $id_group ];
        $sq = "DELETE LOW_PRIORITY FROM group_counters WHERE id_group = :id_group;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        if ( ( is_null( $sortPlus ) ) and ( is_null( $sortMinus ) ) ) {
            throw new InputException('Группа счётчиков пустая');
        }

        $sq = "REPLACE INTO group_counters (id, id_group, id_counter, coefficient)
		           VALUES $sqlVal;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }

        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'data'     => '',
            'minus'    => $lengthMinus,
            'plus'     => $sq,
        ];

        return true;

    }

}