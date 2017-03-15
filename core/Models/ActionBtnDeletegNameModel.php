<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 15.03.2017
 * Time: 23:48
 */

namespace Models;


use Base\BaseModel;

class ActionBtnDeletegNameModel extends BaseModel {
    public $del_group;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'del_group' => [ 'required', 'GroupCounterEmpty', 'GroupCounterExists' ],
        ];
    }

    public function doActionBtnDeletegName() {
        $id = $this->del_group;
        $param = [ 'id' => $id ];
        $sq = "DELETE LOW_PRIORITY FROM name_group_counters WHERE id = :id;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'data'     => 'Ok',
        ];
        return true;
    }

}