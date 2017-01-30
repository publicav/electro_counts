<?php
try {
    include_once "Autoload.php";
    include_once( "../open.php" );
    include_once( "../config.php" );
    include_once( "../funclib.php" );


    //$path_parts = pathinfo( $_SERVER["HTTP_REFERER"] );

    //$url = $path_parts['filename'];
    //$url_search_action = $url . '.php';

    $counter = array();

    $filter = new \filter\FilterInput( $_GET );
    $get_prog = $filter->getInputAll();

    $validator = new filter\Validator( $get_prog, [ 'group' => [ 'required', 'isPositive' ] ] );
    if ( !$validator->validateThis() ) {
        throw new exception\InputException('Input error'); //$validator->getErrors()
    }

    $calcGroup = new \pdo\CalcGroup( $filter->getInt( 'group' ) );
    $nameGroup = $calcGroup->getNameGroup();
    $inSql = $calcGroup->getInSQL();
    $nameCounts = $calcGroup->getNameCouter();


    echo 'Группа - ', $nameGroup, '<br/>';
    echo 'Sql иньекция для in - ', $inSql, '<br/>';
var_dump($nameCounts);

    $type['success'] = true;
    $type['id_error'] = 0;
    $type['input'] = $get_prog;
    $type['data'] = $counter;
    //$type['navigator'] = $navigator;
    //$type['url'] = $url_search_action;
//    var_dump($type);
    //echo json_encode($type);

}catch ( exception\BadRequestException $e ){
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo exception\JsonError::exitError( false, 4,  $e->getMessage() );
} catch ( exception\InputException $e ){
    header("HTTP/1.1 400 Bad Request", true, 400);
    echo exception\JsonError::exitError(false, 1, $e->getMessage());
} catch ( Exception $e ){
    echo $e->getMessage();
}
	