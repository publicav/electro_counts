<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 22.02.2017
 * Time: 18:22
 */

namespace Controllers;

use Base\Request;
use Exception\InputException;
use Models\CounterFilterModel;
use Models\CounterModel;
use Models\SubstFilterModel;
use Models\SubstModel;

class ControllerAjax {

    public function ajaxBlank() {
        $result = [ 'ajax' => 'done' ];
        echo json_encode( $result );
    }

    /**
     * Возвращает массив значений подстанций для фильтра
     * @throws InputException
     */
    public function ajaxSubstationFilter() {
        $model = new SubstFilterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                $data = $model->doSubstationFilter()->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $result = [ 'success'  => true,
                        'id_error' => 0,
                        'data'     => $data
            ];
        }
        echo json_encode( $result );
    }

    /**
     * Возвращает массив значений подстанций для формы
     * @throws InputException
     */
    public function ajaxSubstation() {
        $model = new SubstModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                $data = $model->doSubstation()->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $result = [ 'success'  => true,
                        'id_error' => 0,
                        'data'     => $data
            ];
        }
        echo json_encode( $result );
    }

    /**
     * Возвращает массив значений Счётчиков для фильтра
     * @throws InputException
     */
    public function ajaxCounterFilter() {
        $model = new CounterFilterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                $data = $model->doCounterFilter()->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $result = [ 'success'  => true,
                        'id_error' => 0,
                        'data'     => $data
            ];
        }
        echo json_encode( $result );
    }

    /**
     * Возвращает массив значений Счётчиков для формы
     * @throws InputException
     */
    public function ajaxCounter() {
        $model = new CounterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                $data = $model->doCounter()->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $result = [ 'success'  => true,
                        'id_error' => 0,
                        'data'     => $data
            ];
        }
        echo json_encode( $result );
    }

}