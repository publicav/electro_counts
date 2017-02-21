<?php
try {
    include_once  '../../vendor/autoload.php';
//    include_once "Autoload.php";
    include_once( "../open.php" );

    $route = \Navigation\Route::init();
    $id = $route->getAuthorization();
    if ( is_null( $id ) ) {
        throw new \Exception( 'Вы не зарегистрированы' );
    }

    $filter = new \Filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'id_user' => [ 'required', 'isPositive', ],
    ] );
    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }

    $id_user = (int)$get_prog['id_user'];

    $privelege = new \Pdo\Privelege( $id_user );
    $getMenuLeft = new \Pdo\GetMenuLeft();
    $leftMenu = new \Base\LeftMenu( $privelege, $getMenuLeft );
    $menuLeftPriv = $leftMenu->getDataForm();

    echo json_encode( $menuLeftPriv );

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
