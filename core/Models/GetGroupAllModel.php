<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 09.03.2017
 * Time: 20:58
 */

namespace Models;


use Base\BaseModel;

class GetGroupAllModel extends BaseModel {
    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [

        ];
    }

    public function doGetGroupAll() {
        $sq = "SELECT  id,sort,name FROM name_group_counters ORDER BY sort;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'data'     => $res->fetchAll(),
        ];
        return true;

    }

}