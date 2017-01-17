<?php
// namespace date\rangeDateSql;
class rangeDateSql {
    private $dt1, $dt2;
    public $interval;
    private $year, $month, $day;	
    
	function __construct( $dt1, $dt2 ) {
		// if ($dt1 == '') $date_e = $date_b;
		// if ($dt2 == '') $date_b = $date_e;

		$this->dt1 = new \DateTime( $dt1 );
        $this->dt2 = new \DateTime( $dt2 );
		$this->year = $this->dt1->format('Y');
		$this->month = $this->dt1->format('m');
		$this->day = $this->dt1->format('d');

		$this->numberDay = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
		$this->dt1->setDate($this->year, $this->month, 1);
		$this->dt2->setDate($this->year, $this->month, $this->numberDay);
		
        $this->dt1->sub(new \DateInterval('P1D'));
        $this->dt2->add(new \DateInterval('P1D'));
		
		// while ($this->datetime2->format('d') != $this->dt1) {
			// $this->day[] = array(
                // 'name_counter' => $name_counter, 
                // 'date' => $this->datetime2->format('d-m-Y'), 
                // 'rare' =>  round( ($diffMinuteVal * 1400), $this->round)
            // );
			// $this->datetime2->add(new \DateInterval('P1D'));			
		// }
	}
	public function getDate1() {
		return $this->dt1->format('Y-m-d');
	}
	public function getDate2() {
		return $this->dt2->format('Y-m-d');
	}
	public function getNumberDay() {
		return $this->numberDay;
	}
	public function getSQL( $fieldSqlName ) {
		return  " ($fieldSqlName >= '" . $this->getDate1() . "') AND ($fieldSqlName <= '" . $this->getDate2() . "')";
	}
	
	
}

?>