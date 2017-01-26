<?php
namespace date;
class DivisionDay { 
    public $minuteBefore = 0 ;
    public $minuteAfter = 0;
    private $dt1, $dt2;
    private $interval;

    /**
     * DivisionDay constructor.
     * @param $dt1
     */
    function __construct($dt1 ) {
        $this->dt2 = date("Y-m-d", strtotime( $dt1 )) . ' 00:00:00';
		$this->datetime1 = new \DateTime( $dt1 );
        $this->datetime2 = new \DateTime( $this->dt2 );
        $this->interval = $this->datetime1->diff( $this->datetime2 );

        $this->minuteBefore = $this->interval->h * 60 +  $this->interval->i;
        $this->minuteAfter =  1440 -  $this->minuteBefore;
    }   
}
