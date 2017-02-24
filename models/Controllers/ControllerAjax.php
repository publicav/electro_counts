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
use Models\ActionFormPrivelegeModel;
use Models\ActionFormUserAddModel;
use Models\ActionFormUserModel;
use Models\CounterFilterModel;
use Models\CounterModel;
use Models\LoadFormPrivelegeModel;
use Models\LoadFormUserModel;
use Models\LoadFormValueModel;
use Models\SubstFilterModel;
use Models\SubstModel;
use Models\UserAllModel;


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
     * Загрузка данных в форму user
     * @throws InputException
     */
    public function ajaxLoadFormUser() {
        $model = new LoadFormUserModel();
        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
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

    /**
     * Загрузка данных в форму привелегии
     * @throws InputException
     */
    public function ajaxLoadFormPrivelege() {
        $model = new LoadFormPrivelegeModel();
        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
                if ( $model->doLoadFormPrivelege() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
        }
        echo json_encode( $data );

    }

    /**
     * Загрузка данных в форму user
     * @throws InputException
     */
    public function ajaxLoadFormValueCounter() {
        $model = new LoadFormValueModel();
        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
                if ( $model->doLoadFormValue() )
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

    /**
     * Запись данных в форму user редактирование
     * @throws InputException
     */
    public function ajaxActionFormUser() {
        $model = new ActionFormUserModel();

        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
                if ( $model->doActionFormUser() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'message'  => ' ' . $data,
            ];

        }
        echo json_encode( $this->result );

    }


    /**
     * Запись данных в форму привелегии
     * @throws InputException
     */
    public function ajaxActionFormPrivelege() {
        $model = new ActionFormPrivelegeModel();
        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
                if ( $model->doActionFormPrivelege() )
                    $this->result = [
                        'id_error' => 0,
                        'success'  => true,
                    ];
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
        }
        echo json_encode( $this->result );

    }

    /**
     * Запись данных в форму user добавление
     * @throws InputException
     */
    public function ajaxActionFormUserAdd() {
        $model = new ActionFormUserAddModel();

        if ( Request::isPost() ) {
            if ( $model->load( Request::getPost() ) and ( $model->validate() ) ) {
                if ( $model->doActionFormUserAdd() )
                    $data = $model->getResult();
            } else {
                throw new InputException( 'Ошибка данных - ' . $model->getFirstError()['error'][1] );
            }
            $this->result = [
                'success'  => true,
                'id_error' => 0,
                'message'  => ' ' . $data,
            ];

        }
        echo json_encode( $this->result );

    }

}