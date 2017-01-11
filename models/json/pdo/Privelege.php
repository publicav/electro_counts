<?php
// namespace json\pdo\GetUser;
class Privelege { 
    private  $sq, $param;
    private $res, $priv;
	private $i, $row;
	private $menu_left;
	private $visibly = 0;
    function __construct( $pdo, $id ) {

		$this->sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = :id )";
		$this->param = array ( 'id' => $id ); 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute( $this->param )) {
			$this->priv = $this->res->fetchAll(); 
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
    }
	function get_menu_left( $pdo ) {
		$this->sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);"; 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute()) {
			while ($this->row = $this->res->fetch()) {
				for( $this->i = 0; $this->i < SizeOf( $this->priv ); $this->i++ ) {
					if (( $this->row['id_menu'] == $this->priv[ $this->i ]['id_menu']) AND ($this->priv[ $this->i]['visibly'] == 1)) {
						$this->menu_left[] = $this->row; break;
					}    
				}
			}
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
		return $this->menu_left;
	}
	function GetVisiblyFilter( $Page_Name ) {
		for( $this->i = 0; $this->i < SizeOf( $this->menu_left ); $this->i++ ) {
			 if ($this->menu_left[$this->i]['id_a'] == $Page_Name) $this->visibly = 1;
		}
		return  $this->visibly;
	}
}
?>