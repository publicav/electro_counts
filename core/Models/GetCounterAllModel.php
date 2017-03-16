<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 16.03.2017
 * Time: 8:41
 */

namespace Models;


use Base\BaseModel;

class GetCounterAllModel extends BaseModel {

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [];
    }

    public function doGetCounterAll() {
        $sq = "SELECT  id, name FROM count ORDER BY substations;";
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