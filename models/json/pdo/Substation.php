<?php
class Substation { 
    private  $sq, $param;
    private $res, $substation;
	private $i, $row;
	private $menu_left;
	private $visibly = 0;
	private $substationFilter;
    function __construct( $pdo, $lot ) {
		$this->sq = "SELECT s.id, s.name FROM  substation AS s WHERE ( s.lots = :lot );";
		$this->param = array ( 'lot' => $lot ); 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute( $this->param )) {
			$this->substation = $this->res->fetchAll(); 
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
    }
	function GetSubstation() {
		return $this->substation;
	}
	function GetSubstationFilter() {
		$substationFilter[] = array('id' => '0','name' => 'Все подстанции');
		return  array_merge( $substationFilter, $this->substation);
	}
}
?>