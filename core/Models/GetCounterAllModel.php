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
        $sq = "SELECT   id_counter AS 'id', coefficient AS coeff, c.name  
               FROM group_counters, count AS c
               WHERE id_group = :id_group AND c.id = id_counter;";
        $res = $this->_pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $this->_pdo->errorInfo()[2] );
        }
        $counterGroup = $res->fetchAll();

        if ( empty( $counterGroup ) ) $counterGroup = [];
        $result = Arr_udiff::init( $counterAll, $counterGroup )->doRun()->getResult();
        $lengthCountGroup = count( $counterGroup );
        $counter_plus = [];
        $counter_minus = [];
        for ( $i = 0; $i < $lengthCountGroup; $i++ ) {
            if ( $counterGroup[ $i ]['coeff'] == 1 ) {
                $counter_plus[] = $counterGroup[ $i ];
            } else {
                $counter_minus[] = $counterGroup[ $i ];
            }

        }

        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'data'     => [
                'counter_free'  => $result,
                'counter_plus'  => $counter_plus,
                'counter_minus' => $counter_minus,
            ],
        ];
        return true;

    }
}