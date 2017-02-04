<?php
namespace date;

class DivisionDay {
    public $minuteBefore = 0;
    public $minuteAfter = 0;

    /**
     * DivisionDay constructor.
     * @param $dt1
     */
    function __construct( $dt1 ) {
        $dt_tek = new \DateTime( $dt1 );
        $datetime1 = new \DateTime( $dt1 );
        $datetime2 = new \DateTime( $dt_tek->format( 'Y-m-d' ) );
        $interval = $datetime1->diff( $datetime2 );

        $this->minuteBefore = $interval->h * 60 + $interval->i;
        $this->minuteAfter = 1440 - $this->minuteBefore;
    }

    /**
     * @return int
     */
    public function getAfter() {
        return $this->minuteAfter;
    }

    /**
     * @return int
     */
    public function getBefore() {
        return $this->minuteBefore;
    }
}
