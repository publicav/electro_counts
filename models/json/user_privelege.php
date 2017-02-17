<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'id_user' => [ 'required', 'isPositive', ],
        'data'    => [ 'required', ],

    ] );

    $dataCheck = explode( ",", $get_prog['data'] );
    $id_user = $get_prog['id_user'];

    $privelegeData = new \Pdo\Privelege( $id_user );
    $getMenuLeftData = new \Pdo\GetMenuLeft();
    $leftMenu = new \Base\LeftMenu( $privelegeData, $getMenuLeftData );
    $leftMenu->setSqlData( $dataCheck );
    $leftMenu->savePrivelegeForm();

    $result = [
        'id_error' => 0,
        'success'  => true,
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
