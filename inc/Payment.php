<?php
    class Payment {
	
	public $id;
	public $creditCard;
	public $amount;
	public $timeDate;
	
	public static function CreatePayment( $creditCard, $amount ) {
	    $instance = new self();
	    $time = new DateTime( 'now' );
	    $instance->id = PaymentDao::GetInstance()->createPayment( $creditCard->cardNumber, $amount , $time );
	    $instance->amount = $amount;
	    $instance->creditCard = $creditCard;
	    $instance->timeDate = $time;
	    return $instance;
	}
	
	public static function GetPayment( $paymentId ) {
	    return Payment::dataToPayment( PaymentDao::GetInstance()->getPayment( $paymentId ) );
	}
	
	public static function dataToPayment( $data ) {
	    $instance = new self();
	    $instance->id = $data['PaymentId'];
	    $instance->creditCard = CreditCard::GetCreditCard( $data['CreditCardNumber'] );
	    $instance->amount = $data['Amount'];
	    $instacne->timeDate = new TimeDate( $data['TimeDate'] );
	    return $instance;
	}
    }

?>
