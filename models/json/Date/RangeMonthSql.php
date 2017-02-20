<?php
namespace Date;

class RangeMonthSql {
    protected $_dt1;
    protected $_dt2;
    protected $dtLow;
    protected $dtHigh;
    protected $_sql;

    /**
     * rangeDateSql constructor.
     * @param $dt1
     * @param $dt2
     */
    function __construct( $dt1, $dt2 ) {
        $this->_dt1 = $dt1;
        $this->_dt2 = $dt2;
    }

    public static function init( $dt1, $dt2 ) {
        return new self( $dt1, $dt2 );
    }

    public function doMonth( $fieldSqlName ) {

        if ( \DateTime::createFromFormat( 'Y-m-d', $this->_dt1 ) ) {
            $dtFirst = new \DateTime( $this->_dt1 );
        } else {
            $dtFirst = new \DateTime();
        }

        $dtLast = new \DateTime();
        $year = $dtFirst->format( 'Y' );
        $month = $dtFirst->format( 'm' );

        $numberDay = cal_days_in_month( CAL_GREGORIAN, $month, $year );
        $dtFirst->setDate( $year, $month, 1 );
        $dtLast->setDate( $year, $month, $numberDay );
        //        var_dump( $dtFirst, $dtLast, $numberDay );

        $dtFirst->sub( new \DateInterval( 'P1D' ) );
        $dtLast->add( new \DateInterval( 'P1D' ) );

        $this->dtLow = $dtFirst;
        $this->dtHigh = $dtLast;
        $this->_sql = " AND $fieldSqlName  BETWEEN  '{$this->getDateLow()}' AND '{$this->getDateHigh()}'";
        return $this;
    }


    public function getDateLow() {
        return $this->dtLow->format( 'Y-m-d' ) . ' 00:00:00';
    }

    public function getDateHigh() {
        return $this->dtHigh->format( 'Y-m-d' ) . ' 23:59:59';
    }


    public function getSQL() {
        return $this->_sql;
    }
}

