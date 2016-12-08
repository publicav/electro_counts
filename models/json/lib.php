<?php
class divisionDay {
    public $minuteBefore = 0 ;
    public $minuteAfter = 0;
    private $dt1, $dt2;
    private $interval;
  
    function __construct( $dt1 ) {
        $this->dt2 = date("Y-m-d", strtotime( $dt1 )) . ' 00:00:00';
		$this->datetime1 = new DateTime( $dt1 );
        $this->datetime2 = new DateTime( $this->dt2 );
        $this->interval = $this->datetime1->diff( $this->datetime2 );

        $this->minuteBefore = $this->interval->h * 60 +  $this->interval->i;
        $this->minuteAfter =  1440 -  $this->minuteBefore;
    }   
}

class periodDay {
    private $dt1, $dt2;
    public $interval;
    public $day = [];
    public $round = 3; 
	private  $j = 1;
    
	function __construct( $dt1, $dt2, $diffMinuteVal, $name_counter ) {
		$this->datetime1 = new DateTime( $dt1 );
        $this->datetime2 = new DateTime( $dt2 );
        $this->interval = $this->datetime1->diff( $this->datetime2 );
        $this->dt1 = $this->datetime1->format('d');  
             
		while ( $this->j == 1) {
			$this->datetime2->add(new DateInterval('P1D'));			
			if ( $this->datetime2->format('d') == $this->dt1 ) break;
			$this->day[] = array('name_counter' => $name_counter, 'date' => $this->datetime2->format('d-m-Y'), 'rare' =>  round( ($diffMinuteVal * 1400), $this->round) );
		}
	}   
}

?>