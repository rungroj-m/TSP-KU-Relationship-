<?php
    class Promotion {
	
	public static $PERCENT_TYPE = 1;
	
	public $id;
	public $admin;
	public $startDate;
	public $endDate;
	public $value;
	public $type;
	public $title;
	public $description;
	
	public static function Total( $total ) {
	    return $total * (100 - PaymentDao::GetInstance()->getCurrentPromotionPercent()) / 100.0;
	}
	
	public static function CreatePercentPromotion( $percent, $startDate, $endDate, $admin, $title, $description ) {
	    $instance = new self();
	    $instance->id = PaymentDao::GetInstance()->addPromotion( Promotion::$PERCENT_TYPE, $percent, $startDate, $endDate, $admin->id, $title, $description );
	    $instacne->startDate = $startDate;
	    $instacne->endDate = $endDate;
	    $instacne->admin = $admin;
	    $instancs->title = $title;
	    $instance->description = $description;
	    return $instance;
	}
	
	public function delete() {
	    PaymentDao::GetInstance()->deletePromotion( $this->id );
	}
	
	public static function GetCurrentPromotions() {
	    $data = PaymentDao::GetInstance()->getCurrentPromotion();
	    $result = array();
	    foreach( $data as &$val ) {
		array_push( $result, Promotion::DataToPromo( $val ) );
	    }
	    return $result;
	}
	
	public static function GetAllPromotions() {
	    $data = PaymentDao::GetInstance()->getAllPromotion();
	    $result = array();
	    foreach( $data as &$val ) {
		array_push( $result, Promotion::DataToPromo( $val ) );
	    }
	    return $result;
	}
	
	public static function GetPromotionsByDateTime( $start, $end, $limit, $page) {
	    $data = PaymentDao::GetInstance()->getPromotionByDate( $start, $end, $limit, $page);
	    $result = array();
	    foreach( $data as &$val ) {
		array_push( $result, Promotion::DataToPromo( $val ) );
	    }
	    return $result;
	}
	
	public static function GetFurtherPromotions() {
	    $data = PaymentDao::GetInstance()->getFurtherPromotion();
	    $result = array();
	    foreach( $data as &$val ) {
		array_push( $result, Promotion::DataToPromo( $val ) );
	    }
	    return $result;
	}
	
	private static function DataToPromo( $data ) {
	    $instance = new self();
	    $instance->id = $data['PromotionId'];
	    $instance->admin = Admin::GetAdmin( $data['AdminId'] );
	    $instance->startDate = new DateTime( $data['StartDate'] );
	    $instance->endDate = new DateTime( $data['EndDate'] );
	    $instance->value = $data['Value'];
	    $instance->type = $data['Type'];
	    $instance->title = $data['Title'];
	    $instance->description = $data['Description'];
	    return $instance; 
	}
	
	public static function checkOverlapPromotion($date) {
		echo PaymentDao::GetInstance()->checkOverlapPromotion($date);
	}
    }

?>
