<?php
namespace pdo;

class GetNamePage { 
    private  $sq, $param;
    private $res, $conf_h, $head;
    private $_pdo;

    /**
     * GetNamePage constructor.
     * @param $pdo
     * @param $pageName
     * @param $langvige
     * @throws \Exception
     */
    function __construct($pageName, $langvige ) {
        $db = \db::getLink();
        $this->_pdo = $db->getDb();

		$this->sq = "SELECT m.title, m.meta_k, m.meta_d FROM adm_main_struct AS m WHERE (m.name = :page_name) AND (id_lang = :id_lang);";
		$this->param = ['page_name' => $pageName, 'id_lang' => $langvige ];
		$this->res = $this->_pdo->prepare( $this->sq );
		if (!$this->res->execute( $this->param )) {
		    throw new \Exception('Bad Request','400');
//			header("HTTP/1.1 400 Bad Request", true, 400);
//			print exit_error( false, 3, $this->res->errorInfo()[2] );
//			exit();
		}
        $this->conf_h = $this->res->fetchAll();
    }

    /**
     * @param $head
     * @return mixed
     */
    public function get_head($head ) {
		$this->head = $head;
		for($i = 0; $i < SizeOf( $this->conf_h ); $i++) {
			foreach ($this->conf_h[ $i ] as $key => $value) {
				$this->head = str_replace(':' . $key . ':', $value , $this->head );
			}	
		}
		return $this->head;
	}
	public function getTitle(){
        return $this->conf_h[0]['title'];
    }
    public function getMetaK(){
        return $this->conf_h[0]['meta_k'];
    }
    public function getMetaD(){
        return $this->conf_h[0]['meta_d'];
    }

    /**
     * @return array['title','meta_k','meta_d']
     */
    public function getConfAll()
    {
        return $this->conf_h[0];
    }

}
