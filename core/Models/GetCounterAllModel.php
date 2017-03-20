<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 16.03.2017
 * Time: 8:41
 */

namespace Models;


use ArrayMath\Arr_udiff;
use Base\BaseModel;

class GetCounterAllModel extends BaseModel {
    public $id_group;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
            'id_group' => [ 'required', 'aboveZerroInt', ],
        ];
    }

    public function doGetCounterAll() {

        $sq = "SELECT  id, name FROM count ORDER BY substations;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute() ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $counterAll = $res->fetchAll();
        //        $idAll = array_column( $counterAll, 'id' );
        $param = [
            'id_group' => $this->id_group,
        ];
        $sq = "SELECT   id_counter AS 'id', coefficient  FROM group_counters WHERE id_group = :id_group;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $counterGroup = $res->fetchAll();

        if ( empty( $counterGroup ) ) $counterGroup = [];
        $result = Arr_udiff::init( $counterAll, $counterGroup )->doRun()->getResult();

        //        $result = array_udiff( $counterAll, $counterGroup,
        //            function ( $all, $count ) {
        //                var_dump( $all );
        //                var_dump( $count );
        //                $idAll = $all['id'];
        //                $idCount = $count['id'];
        //                return $idAll - $idCount;
        //            }
        //        );
        $this->result = [
            'success'       => true,
            'id_error'      => 0,
            'data'          => $counterAll,
            'group_counter' => $counterGroup,
            'diff'          => $result,
        ];
        return true;

    }
}