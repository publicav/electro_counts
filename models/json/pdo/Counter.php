<?php
namespace pdo;
class Counter {

    private  $sq, $param;
    private $res, $counter;
	private $i, $row;
	private $menu_left;
	private $visibly = 0;
	private $counterFilter;
    function __construct( $pdo, $substation ) {

		$this->sq = "SELECT c.id, c.name FROM  count AS c WHERE ( c.substations = :substation );";
		$this->param = array ( 'substation' => $substation ); 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute( $this->param )) {
			$this->counter = $this->res->fetchAll(); 
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
    }
	function GetCounter() {
		return $this->counter;
	}
	function GetCounterFilter() {
		$counterFilter[] = array('id' => '0','name' => 'Все ячейки');
		return  array_merge( $counterFilter, $this->counter);
	}
}
?>