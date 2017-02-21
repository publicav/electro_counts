<?php
try {
    include_once  '../../vendor/autoload.php';
//    include_once "Autoload.php";
    include_once( "../open.php" );

    $route = \Navigation\Route::init();
    $id_users = $route->getAuthorization();

    if ( is_null( $id_users ) ) {
        throw new \Exception\InputException( 'Пользователь не авторизирован' );
    }


    $filter = new \Filter\FilterInput( $_POST );
    $get_prog = $filter->getInputAll();


    $validator = new \Filter\Validator( $get_prog, [
        'lot'         => [ 'required', 'isPositive', ],
        'substation'  => [ 'required', 'isPositive', ],
        'counter'     => [ 'required', 'isPositive', ],
        'counter_val' => [ 'required', 'notEmpty', ],
        'date_begin'  => [ 'required', 'DateDMY', ],
        'time_begin'  => [ 'required', 'TimeSet', ],
        'actions'     => [ 'required', ],

    ] );
    if ( !$validator->validateThis() ) {
        $firstError = '';
        foreach ( $validator->getErrors() as $field => $error ) {
            $firstError = $error;
        }
        throw new \Exception\InputException( 'Ошибка данных - ' . $firstError );
    }
    $get_prog['counter_val'] = str_replace( ',', '.', $get_prog['counter_val'] );
    $get_prog['counter_val'] = floatval( $get_prog['counter_val'] );

    $lot = $get_prog['lot'];
    $substation = $get_prog['substation'];
    $counter = $get_prog['counter'];
    $date = $get_prog['date_begin'];
    $time = $get_prog['time_begin'];
    $dt = new\DateTime( $date );
    $date = $dt->format( 'Y-m-d' );
    $validatorDepender = new \Filter\ValidDependentFilters( $lot, $substation, $counter );
    if ( !$validatorDepender->valide() ) {
        throw new \Exception\InputException( 'Неправильные параметры фильтров' );
    }
    $countData = $validatorDepender->getCountData();
    $N_counter = $countData['n_counter'];

    $name_count = $countData['name'];
    $name_substation = $validatorDepender->getSubstationData()['name'];
    $name_lot = $validatorDepender->getLotData()['name'];

    $date_create = $date . ' ' . $time;

    $param = [ 'id'          => NULL,
               'n_counter'   => $N_counter,
               'id_counter'  => $counter,
               'id_users'    => $id_users,
               'value'       => $get_prog['counter_val'],
               'date_create' => $date_create
    ];
    $id_add = 0;
    if ( $get_prog['actions'] == 'add' ) {
        $sq = "SELECT id FROM  counter_v  
			WHERE (n_counter = :n_counter) AND (id_counter = :id_counter) AND (date_create = :date_create);";
        $paramDublicate = [
            'n_counter'   => $N_counter,
            'id_counter'  => $get_prog['counter'],
            'date_create' => $date_create
        ];
        $dublicate = new \Filter\ValidDublicate( $pdo, $sq, $paramDublicate );
        if ( $dublicate->valide() ) {
            throw new \Exception\InputException( 'Error, Дублирующая запись' );
        }

        $sq = "REPLACE INTO counter_v (id, n_counter, id_counter, id_users, value,  date_create) 
		   VALUES (:id, :n_counter , :id_counter, :id_users, :value, :date_create);";
        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
        $id_add = $pdo->lastInsertId();
    }
    if ( $get_prog['actions'] == 'edit' ) {
        $sq = "REPLACE INTO counter_v (id, n_counter, id_counter, id_users, value,  date_create) 
		   VALUES (:id, :n_counter , :id_counter, :id_users, :value, :date_create);";

        $param['id'] = $get_prog['edit_id'];
        $res = $pdo->prepare( $sq );
        if ( !$res->execute( $param ) ) {
            throw new \Exception( $pdo->errorInfo()[2] );
        }
        $id_add = $get_prog['edit_id'];
    }
    $data = [ "id"              => $id_add,
              "lot"             => $get_prog['lot'],
              "substation"      => $get_prog['substation'],
              "counter"         => $get_prog['counter'],
              "name_lot"        => $name_lot,
              "name_substation" => $name_substation,
              "name_counter"    => $name_count,
              "date"            => $get_prog['date_begin'],
              "time"            => $get_prog['time_begin'],
              "id_users"        => $id_users,
              "value"           => $get_prog['counter_val'] ];

    $type['success'] = true;
    $type['id_error'] = 0;
    $type['error'] = '';
    $type['data'] = $data;
    echo json_encode( $type );

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
