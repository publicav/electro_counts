<?php
// namespace date\rangeDateSql;
class NavigationCalc {
	private $nav;
	protected $monthFull = ["Январь", "Февраль",'Март','Апрель', 'Май','Июнь','Июль','Август','Cентябрь','Октябрь','Ноябрь','Декабрь'];	
	protected $month = ["Янв", " Фев",'Мрт','Апр', 'Май','Июн','Июл','Авг','Сен','Окт','Нбр','Дек'];	

	function __construct(  ) {

	}
	public function getNavigator() {
   // if ($total>$c_page) $tek_page = "<span class='pagecurrent'>$pg</span>";
   
   // $sp="<span class='pagelink'>";
	
		$this->nav = '<div class="navigator">
						<p>';
		foreach($this->month as $colum) $this->nav .= '<span class="pagelink"><a href="" title="' . $colum  . '">' . $colum . '</a></span>';
		$this->nav .= '</p>
					 </div>';
	
		return $this->nav;
		
	}
}

?>