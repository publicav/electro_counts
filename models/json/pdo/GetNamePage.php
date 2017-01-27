<?php
namespace pdo;

class GetNamePage { 
    private  $sq, $param;
    private $res, $_conf_h;
    private $_pdo;
    protected static $_link = null;


    function __construct($pageName, $langvige ) {
        $this->_pdo =  \db::getLink()->getDb();
		$this->sq = "SELECT m.title, m.meta_k, m.meta_d FROM adm_main_struct AS m WHERE (m.name = :page_name) AND (id_lang = :id_lang);";
		$this->param = [ 'page_name' => $pageName, 'id_lang' => $langvige ];
		$this->res = $this->_pdo->prepare( $this->sq );
		if (!$this->res->execute( $this->param )) {
		    throw new \Exception('Bad Request - ' . $this->res->errorInfo()[2], '400');
		}
        $conf_h = $this->res->fetchAll();
		$this->_conf_h = $conf_h[0];
//		var_dump($this->_conf_h, $pageName);
    }

    /**
     * @param $pageName
     * @param $langvige
     * @return array
     */
    public static function getConfAll($pageName, $langvige){
        if ( is_null( self::$_link ) ) self::$_link = new self( $pageName, $langvige );
        return self::$_link->_conf_h;
    }

}
