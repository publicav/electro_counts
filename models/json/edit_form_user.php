<?php
try {
    include_once  '../../vendor/autoload.php';
//    include_once "Autoload.php";
    include_once "../open.php";

    $filter = new \Filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new \Filter\Validator( $get_prog, [
        'id' => [ 'required', 'isPositive' ],

    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $id = $get_prog['id'];
    $sq = "SELECT id, users, password, name, family FROM users WHERE  ring > 0 AND id = :id;";

    $param = [ 'id' => $id ];
    $res = $pdo->prepare( $sq );
    if ( !$res->execute( $param ) ) {
        throw new \Exception( $pdo->errorInfo()[2] );
    }
    while ( $row = $res->fetch() ) $user = $row;
    if ( empty( $user ) ) {
        throw new \Exception( 'Ошибка загрузки формы' );
    }
    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $user,
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


	