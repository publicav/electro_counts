<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 18:22
 */

namespace Controllers;

use \Base\Request;
use \Models\SubstFilterModel;

class ControllerAjax {
    public function ajaxBlank() {
        $result = [ 'ajax' => 'done' ];
        echo json_encode( $result );
    }

    public function ajaxSubstationFilter() {
        $model = new SubstFilterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                $model->doSubstationFilter();
            }

            $result = [ 'success'  => true,
                        'id_error' => 0,
                        'data'     => $model->getResult() ];

        }
        echo json_encode( $result );
    }


}