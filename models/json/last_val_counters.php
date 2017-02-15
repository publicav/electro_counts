<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );

    $filter = new \filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();

    $validator = new filter\Validator( $get_prog, [
        'counter' => [ 'required', ],
    ] );

    if ( !$validator->validateThis() ) {
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $counter = $get_prog['counter'];
    $sq = "SELECT n_counter FROM  count  WHERE (id = :id);";
    $param = [ 'id' => $counter ];

    $res = $pdo->prepare( $sq );
    if ( !$res->execute( $param ) ) {
        throw new \Exception( $pdo->errorInfo()[2] );
    }
    $N_counter = $res->fetchAll()[0];
    if ( empty( $N_counter ) ) {
        throw new \Exception( 'Не найден номер счётчика!' );
    }
    $sq = "SELECT main.value FROM  counter_v AS main 
        WHERE (main.n_counter = :n_counter) AND (main.id_counter = :id_counter)
        ORDER BY date_create DESC LIMIT 1;";

    $param = [ 'n_counter' => $N_counter['n_counter'], 'id_counter' => $counter ];
    $res = $pdo->prepare( $sq );
    if ( !$res->execute( $param ) ) {
        throw new \Exception( $pdo->errorInfo()[2] );
    }
    $value1 = $res->fetchAll();
    if ( !empty( $value1 ) ) $retVal = $value1[0]; else  $retVal = '';
    $result = [
        'success'  => true,
        'error'    => 'Ok',
        'id_error' => 0,
        'data'     => $retVal
    ];
    echo json_encode( $result );

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
