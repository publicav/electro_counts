<?php
namespace pdo;
class Substation { 
    private  $sq, $param;
    private $res, $substation;
	private $i, $row;
	private $menu_left;
	private $visibly = 0;
	private $substationFilter;

    /**
     * Substation constructor.
     * @param $pdo
     * @param $lot
     */
    function __construct($pdo, $lot ) {
		$this->sq = "SELECT s.id, s.name FROM  substation AS s WHERE ( s.lots = :lot );";
		$this->param = [ 'lot' => $lot ];
		$this->res = $pdo->prepare( $this->sq );
		if ( !$this->res->execute( $this->param )) {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
        $substation = $this->res->fetchAll();
        $this->substation = $substation;
//        var_dump($this->substation);

    }

    /**
     * @return mixed
     */
    function GetSubstation() {
		return $this->substation;
	}

    /**
     * @return array
     */
    function GetSubstationFilter() {
		$substationFilter[] = array('id' => '0','name' => 'Все подстанции');
		return  array_merge( $substationFilter, $this->substation);
	}
}
