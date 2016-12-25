<?php
namespace date\PeriodDay;
class PeriodDay {
    private $dt1, $dt2;
    public $interval;
    public $day = [];
    public $round = 3; 
    
	function __construct( $dt1, $dt2, $diffMinuteVal, $name_counter ) {
		$this->datetime1 = new \DateTime( $dt1 );
        $this->datetime2 = new \DateTime( $dt2 );
        $this->dt1 = $this->datetime1->format('d');  

        $this->datetime2->add(new \DateInterval('P1D'));

		while ($this->datetime2->format('d') != $this->dt1) {
			$this->datetime2->add(new \DateInterval('P1D'));			
			$this->day[] = array(
                'name_counter' => $name_counter, 
                'date' => $this->datetime2->format('d-m-Y'), 
                'rare' =>  round( ($diffMinuteVal * 1400), $this->round)
            );
		}
	}   
}

?>