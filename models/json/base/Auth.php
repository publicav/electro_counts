<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.01.2017
 * Time: 12:32
 */

namespace base;


class Auth{
    public function isGuest(){
        if(empty( $_SESSION['user'] )){
            return true;
        }
        return false;
    }
    public static function login( $id ){
        $_SESSION['user']['id'] = $id;
    }
    public static function logout(){
//        session_start();
        session_unset();
        session_destroy(); // разрушаем сессию
    }

}