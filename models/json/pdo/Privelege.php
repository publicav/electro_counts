<?php
namespace pdo;
class Privelege { 
    private  $sq, $param;
    private $res, $priv;
	private $menu_left;
	private $visibly = 0;
	private $_pdo;


    function __construct( $id ) {
        $this->_pdo = \db::getLink()->getDb();
		$this->sq = "SELECT id_menu, visibly FROM tables_priv WHERE (id_users = :id )";
		$this->param = [ 'id' => $id ];
		$this->res = $this->_pdo->prepare( $this->sq );
		if ( !$this->res->execute( $this->param ) ) {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $this->res->errorInfo()[2] );
			exit();
		}
        $this->priv = $this->res->fetchAll();
    }

    /**
     * @return array LeftMenu
     */
    function getMenuLeft() {
		$this->sq = "SELECT m.id_a AS id_a, m.id_menu AS id_menu,  m.name AS name, m.url AS url FROM menu_left AS m WHERE (visibility = 1);"; 
		$this->res = $this->_pdo->prepare( $this->sq );
		if ( !$this->res->execute() ) {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print  $this->res->errorInfo()[2];
			exit();
		}
        while ($row = $this->res->fetch()) {
            for( $i = 0; $i < SizeOf( $this->priv ); $i++ ) {
                if (( $row['id_menu'] == $this->priv[ $i ]['id_menu']) AND ($this->priv[ $i ]['visibly'] == 1)) {
                    $this->menu_left[] = $row; break;
                }
            }
        }

		return $this->menu_left;
	}

    /**
     * @param string $Page_Name
     * @return int $visibly
     */
    function GetVisiblyFilter( $Page_Name ) {
		for( $i = 0; $i < SizeOf( $this->menu_left ); $i++ ) {
			 if ($this->menu_left[$i]['id_a'] == $Page_Name) $this->visibly = 1;
		}
		return  $this->visibly;
	}
}
