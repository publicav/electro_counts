<?php
try {
    include_once  '../../vendor/autoload.php';
//    include_once "Autoload.php";
    include_once( "../open.php" );

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

    $sq = "SELECT main.id AS id, lot.id AS lot_id, sub.id AS sub_id, cnt.id AS counter_id, cnt.name AS counter, 
                DATE_FORMAT(main.date_create, '%d-%m-%Y' ) AS date1, DATE_FORMAT(main.date_create, '%H:%i' ) AS time1 ,main.value AS value,
                sub.name AS substation, lot.name AS lot
        FROM counter_v AS main, count AS cnt, substation AS sub, lots AS lot
        WHERE (main.id_counter = cnt.id) AND (cnt.substations = sub.id) AND (sub.lots = lot.id) AND (main.id = :id)
        ";

    $param = array( 'id' => $id );
    $res = $pdo->prepare( $sq );
    if ( !$res->execute( $param ) ) {
        throw new \Exception( $pdo->errorInfo()[2] );
    }
    while ( $row = $res->fetch() ) $editCounter = $row;
    if ( empty( $editCounter ) ) {
        throw new \Exception( 'Ошибка загрузки формы' );
    }

    $result = [ 'success'  => true,
                'id_error' => 0,
                'data'     => $editCounter,
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

	