<?php
try {
    include_once "Autoload.php";
    include_once "../open.php";
    include_once "../config.php";

    mb_internal_encoding( 'UTF-8' );

    $filter = new \Filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();
    $validator = new \Filter\Validator( $get_prog, [
        'actions' => [ 'required', ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $action = $get_prog['actions'];

    if ( $action == 'add' ) {
        $validator = new filter\Validator( $get_prog, [
            'user_add'        => [ 'required', 'rangeLogin', 'uniqueLogin', ],
            'pass_add'        => [ 'required', 'confirmPassword', 'minPassword' ],
            'pass_repeat_add' => [ 'required', ],
            'family_add'      => [ 'required', ],
            'name_add'        => [ 'required', ],

        ] );
        if ( !$validator->validateThis() ) {
            foreach ( $validator->getErrors() as $field => $error ) {
                $firstError = $error;
            }
            throw new exception\InputException( 'Ошибка данных - ' . $firstError );
        }
        $md5 = sha1( md5( md5( $get_prog['pass_add'] ) . $keys1 . $get_prog['user_add'] ) );

        $sq = "INSERT INTO users (users, password, name, family,  ring) 
			VALUES (:users, :password, :name, :family, :ring);";

        $msg = 'Пользователь ' . $get_prog['name_add'] . ' добавлен';
        $param = array( 'users'  => $get_prog['user_add'], 'password' => $md5, 'name' => $get_prog['name_add'],
                        'family' => $get_prog['family_add'], 'ring' => $config['RING']
        );
    }

    if ( $action == 'edit' ) {
        $validator = new filter\Validator( $get_prog, [
            'user_edit'        => [ 'required', 'rangeLogin', 'uniqueLogin', ],
            'pass_edit'        => [ 'required', 'confirmPassword', 'minPassword' ],
            'pass_repeat_edit' => [ 'required', ],
            'family_edit'      => [ 'required', ],
            'name_edit'        => [ 'required', ],
        ] );
        if ( !$validator->validateThis() ) {
            foreach ( $validator->getErrors() as $field => $error ) {
                $firstError = $error;
            }
            throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
        }
        $md5 = sha1( md5( md5( $get_prog['pass_edit'] ) . $keys1 . $get_prog['user_edit'] ) );

        $sq = "UPDATE users  
			SET users = :users, password = :password, name = :name, family = :family, ring = :ring
			WHERE (id = :id);";

        $msg = 'Пользователь ' . $get_prog['name_edit'] . ' изменён';
        $param = array( 'users'  => $get_prog['user_edit'], 'password' => $md5, 'name' => $get_prog['name_edit'],
                        'family' => $get_prog['family_edit'], 'ring' => $config['RING'], 'id' => $get_prog['edit_user_id']
        );
    }

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

} catch ( Exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( Exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
}
