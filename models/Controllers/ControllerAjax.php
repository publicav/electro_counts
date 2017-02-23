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
use Models\UserAllModel;
use Models\LoadFormUserModel;

class ControllerAjax {
    public $result;

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
                if ( $model->doSubstationFilter() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );
    }

    /**
     * Возвращает массив значений подстанций для формы
     * @throws InputException
     */
    public function ajaxSubstation() {
        $model = new SubstModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                if ( $model->doSubstation() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );
    }

    /**
     * Возвращает массив значений Счётчиков для фильтра
     * @throws InputException
     */
    public function ajaxCounterFilter() {
        $model = new CounterFilterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                if ( $model->doCounterFilter() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );
    }

    /**
     * Возвращает массив значений Счётчиков для формы
     * @throws InputException
     */
    public function ajaxCounter() {
        $model = new CounterModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                if ( $model->doCounter() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );
    }

    /**
     * Возвращает всех пользоватлей проекта
     * @throws InputException
     */
    public function ajaxGetUserAll() {
        $model = new UserAllModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                if ( $model->doUserAll() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );
    }

    /**
     *
     * @throws InputException
     */
    public function ajaxLoadFormUser() {
        $model = new LoadFormUserModel();
        if ( Request::isGet() ) {
            if ( $model->load( Request::getGet() ) and ( $model->validate() ) ) {
                if ( $model->doLoadFormUser() )
                    $data = $model->getResult();
                else throw new \Exception( 'Ошибка загрузки формы' );
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'data'     => $data
            ];
        }
        echo json_encode( $this->result );

    }

}