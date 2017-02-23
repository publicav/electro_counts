<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.02.2017
 * Time: 18:43
 */

namespace Models;

use Base\BaseModel;
use \Base\Registry;

class ActionFormUserModel extends BaseModel {
    public $actions;
    public $user_edit;
    public $pass_edit;
    public $pass_repeat_edit;
    public $family_edit;
    public $name_edit;

    public $result;

    public function getRules() {
        // TODO: Implement getRules() method.
        return [
            'actions'          => [ 'required', ],
            'user_edit'        => [ 'required', 'rangeLogin', 'uniqueLogin', ],
            'pass_edit'        => [ 'required', 'confirmPassword', 'minPassword' ],
            'pass_repeat_edit' => [ 'required', ],
            'family_edit'      => [ 'required', ],
            'name_edit'        => [ 'required', ],
        ];
    }

    public function doActionFormUser() {
        $md5 = sha1( md5( md5( $this->pass_edit ) . $config['md5'] . $this->user_edit) );

        $sq = "UPDATE users  
			SET users = :users, password = :password, name = :name, family = :family, ring = :ring
			WHERE (id = :id);";

        $msg = 'Пользователь ' . $get_prog['name_edit'] . ' изменён';
        $param = [
            'users'    => $this->user_edit,
            'password' => $md5,
            'name'     => $get_prog['name_edit'],
            'family'   => $get_prog['family_edit'],
            'ring'     => 1,
            'id'       => $get_prog['edit_user_id']
        ];
        $user_edit;
        $pass_edit;
        $pass_repeat_edit;
        $family_edit;
        $name_edit;

        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }

        $result = [
            'success'  => true,
            'id_error' => 0,
            'message'  => ' ' . $msg,
        ];
        echo json_encode( $result );


        return true;


    }

}