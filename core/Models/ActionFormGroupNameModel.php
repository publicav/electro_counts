<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 14.03.2017
 * Time: 6:57
 */

namespace Models;


use Base\BaseModel;

class ActionFormGroupNameModel extends BaseModel {
    public $name_group;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'name_group' => [ 'required', ],
        ];
    }

    public function doActionFormGroupName() {
        $param = [ 'id'      => NULL,
                   'name'    => $this->name_group,
                   'visibly' => 1,
                   'sort'    => 10000,
        ];

        $sq = "REPLACE INTO name_group_counters (id, name, visibly, sort) 
		           VALUES (:id, :name , :visibly, :sort);";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $data =[
            'success'  => true,
            'id_error' => 0,
            'data'     => ''
        ];
        $this->result = $data;
        return true;

    }
}