<?php
try {
    include_once "Autoload.php";
    include_once "../open.php";
    include_once "../config.php";

    $filter = new \Filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'username' => [ 'required', ],
        'password' => [ 'required', ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }

    $username = $get_prog['username'];
    $password = $get_prog['password'];
    $md5 = sha1( md5( md5( $password ) . $keys1 . $username ) );

    $sq = "SELECT id, users, name, family FROM users WHERE (users = :user) AND (password = :password)";
    //    $msg = 'зарегистрирован';

    $res = $pdo->prepare( $sq );
    $param = [ 'user' => $username, 'password' => $md5 ];
    if ( !$res->execute( $param ) ) {
        throw new \Exception( $pdo->errorInfo()[2] );
    }
    $regArray = $res->fetchAll();

    if ( empty( $regArray ) ) {
        throw new \Exception( 'Ошибка регистрации!' );
    }
    $registred = $regArray[0];
    $id = $registred['id'];
    \Base\Auth::login( $id );
    $result = [ 'success'  => true,
                'id_error' => 0,
                'id'       => $id,
                'users'    => $registred['users'],
                'name'     => $registred['name'],
                'family'   => $registred['family'],
                'message'  => $registred['users'],
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
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
}
