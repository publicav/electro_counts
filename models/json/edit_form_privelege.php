<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $route = navigation\Route::init();
    $id = $route->getAuthorization();
    if ( is_null( $id ) ) {
        throw new Exception( 'Вы не зарегистрированы' );
    }

    $filter = new \filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();

    $validator = new filter\Validator( $get_prog, [
        'id_user' => [ 'required', 'isPositive', ],
    ] );
    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new exception\InputException( 'Ошибка данных - ' . $firstError );
    }

    $id_user = (int)$get_prog['id_user'];

    $privelege = new pdo\Privelege( $id_user );
    $getMenuLeft = new pdo\GetMenuLeft();
    $leftMenu = new base\LeftMenu( $privelege, $getMenuLeft );
    $menuLeftPriv = $leftMenu->getDataForm();

    echo json_encode( $menuLeftPriv );

} catch ( exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 1, $e->getMessage() );
}
