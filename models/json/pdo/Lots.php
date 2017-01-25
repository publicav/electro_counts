<?php
namespace pdo;
class Lots { 
    private  $sq, $param;
    private $res, $lots;
	private $i, $row;
	private $menu_left;
	private $visibly = 0;
	private $lotsFilter;

    /**
     * Lots constructor.
     * @param $pdo
     */
    function __construct($pdo ) {

		$this->sq = "SELECT l.id, l.name FROM  lots AS l;";
		// $this->param = array ( 'id' => $id ); 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute()) {
			$this->lots = $this->res->fetchAll(); 
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
    }

    /**
     * @return mixed
     */
    function GetLots() {
		return $this->lots;
	}

    /**
     * @return array
     */
    function GetLotsFilter() {
		$lotsFilter[] = array('id' => '0','name' => 'Все участки');
		return  array_merge( $lotsFilter, $this->lots );
	}
}
?>