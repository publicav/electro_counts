<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 28.03.2017
 * Time: 16:15
 */

namespace Models;


use Base\BaseModel;
use Pdo\Lots;

class LotsModel extends BaseModel {
    public $data;

    public $result;

    function getRules() {
        // TODO: Implement getRules() method.
        return [
        ];

    }

    public function doLots() {
        $result = Lots::lots()->getLots();
        $this->result = [
            'success'  => true,
            'id_error' => 0,
            'data'     => $result,
        ];

        return true;
    }
}