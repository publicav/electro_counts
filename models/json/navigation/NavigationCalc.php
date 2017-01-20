<?php
// namespace date\rangeDateSql;
class NavigationCalc {
	const DATE_B = 'date_b=';
	const SEPAR_DATE = '-';
	protected $month = [['Январь',  'Янв', '01'],
						['Февраль', 'Фев', '02'],
						['Март',	'Мрт', '03'],
						['Апрель', 	'Апр', '04'],
						['Май',		'Май', '05'],
						['Июнь',	'Июн', '06'],
						['Июль',	'Июн', '07'],
						['Август',	'Авг', '08'],
						['Cентябрь','Сен', '09'],
						['Октябрь',	'Окт', '10'],
						['Ноябрь',	'Нбр', '11'],
						['Декабрь',	'Дек', '12']
						];	
	protected $fileAction, $dt, $param = '';
	private $nav;
	protected $url, $colum, $link;
	protected $dtPrevYear, $dtNextYear;
	protected $key, $value;

	
	function __construct( $fileAction, $dt, $param ) {
		$this->setFileAction( $fileAction );
 		$this->setParam( $param );		
		$this->dt = new \DateTime( $dt );
        $this->dtPrevYear =  new \DateTime( $dt );
        $this->dtNextYear =   new \DateTime( $dt );
		
        $this->dtPrevYear->sub(new \DateInterval('P1Y'));
        $this->dtNextYear->add(new \DateInterval('P1Y'));
	}
	public function getNavigator() {
   // if ($total>$c_page) $tek_page = "<span class='pagecurrent'>$pg</span>";
		$this->setUrl( $this->getDTPrevYear(), '01', '01');
		$this->setLink( $this->getUrl(), $this->getDTPrevYear(), $this->getDTPrevYear() );

		$this->nav = '<div class="navigator">
						<p>
							<span class="pagelink">' . $this->getLink() . '</span>';
		foreach( $this->month as $this->colum ) {
			$this->setUrl( $this->getDTYear(), $this->getMonthNumber(), $this->getDTDay());
			$this->setLink( $this->getUrl(), $this->getTitleMonthFull(), $this->getMonthShort() );
			$this->nav .= '<span class="pagelink">' . $this->getLink() . '</span>';

		}	
		$this->setUrl( $this->getDTNextYear(), '01', '01');
		$this->setLink( $this->getUrl(), $this->getDTNextYear(), $this->getDTNextYear() );
		$this->nav .= '
							<span class="pagelink">' . $this->getLink() . '</span>
						</p>
					 </div>';
		return $this->nav;
	}
	protected function getDTPrevYear(){
		return $this->dtPrevYear->format('Y');
	}
	protected function getDTNextYear(){
		return $this->dtNextYear->format('Y');
	}
	protected function getDTYear(){
		return $this->dt->format('Y');
	}
	protected function getDTDay(){
		return $this->dt->format('d');
	}
	protected function getFileAction(){
		return $this->fileAction;
	}
	protected function setFileAction( $fileAction ){
		$this->fileAction = $fileAction;
	}
	
	protected function setParam( $param ){
		foreach ( $param as $this->key => $this->value ) {
			$this->param .= '&' . $this->key . '=' . $this->value;
		}
	}
	protected function getParam(){
		return $this->param;
	}
	protected function setUrl ( $year, $motht, $day){
		$this->url  =  './' . $this->getFileAction() . '?';
		$this->url .=  self::DATE_B . $year . self::SEPAR_DATE . $motht . self::SEPAR_DATE . $day;  
		$this->url .=  $this-> getParam();
		
	}
	protected function getUrl(){
		return $this->url;
	}
	private function getTitleMonthFull(){
		return $this->colum[0];
	}
	private function getMonthShort(){
		return $this->colum[1];
	}
	private function getMonthNumber(){
		return $this->colum[2];
	}
	protected function setLink($url, $title, $text){
		$this->link = '<a href="' . $url . '" title="' . $title  . '">' .$text . '</a>';
	}
	protected function getLink(){
		return $this->link;
	}
}

?>