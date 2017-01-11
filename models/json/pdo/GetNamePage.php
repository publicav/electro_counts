<?php
// namespace json\pdo\GetUser;
class GetNamePage { 
    private  $sq, $param;
    private $res, $conf_h, $head;
	private $i, $key, $value;
    function __construct( $pdo, $pageName, $langvige ) {

		$this->sq = "SELECT m.title, m.meta_k, m.meta_d FROM adm_main_struct AS m WHERE (m.name = :page_name) AND (id_lang = :id_lang);";
		$this->param = array ('page_name' => $pageName, 'id_lang' => $langvige ); 
		$this->res = $pdo->prepare( $this->sq );
		if ($this->res->execute( $this->param )) {
			$this->conf_h = $this->res->fetchAll(); 
		} else {
			header("HTTP/1.1 400 Bad Request", true, 400);
			print exit_error( false, 3, $res->errorInfo()[2] );
			exit();
		}
    }
	function get_head( $head ) {
		$this->head = $head;
		for($this->i = 0; $this->i < SizeOf( $this->conf_h ); $this->i++) {
			foreach ($this->conf_h[ $this->i ] as $this->key => $this->value) {
				$this->head = str_replace(':' . $this->key . ':', $this->value , $this->head );
			}	
		}
		return $this->head;
	}
}
?>