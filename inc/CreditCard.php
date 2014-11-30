<?php
    class CreditCard {
	
	public $cardNumber;
	public $cvv;
	public $name;
	public $expDate;
	public $isVertify = true;
	
	public function __construct(){
	}
	
	public static function CreateCreditCard( $name, $number, $cvv, $expYear, $expMonth ) {
	    $instance = new self();
	    $instance->cardNumber = $number;
	    $instance->cvv = $cvv;
	    $instance->name = $name;
	    $instance->expDate = new DateTime( "$expYear-$expMonth-01");
	    return $instance;
	}
	
	public static function GetCreditCard( $number ) {
	    return CreditCard::dataToCreditCard( PaymentDao::getCreditCardByNumber( $number ) );
	}
	
	private static function dataToCreditCard( $data ) {
	    $instance = new Self();
	    $instance->cardNumber = $data['Number'];
	    $instance->cvv = $data['Cvv'];
	    $instance->name = $data['Name'];
	    $instance->expDate = new TimeDate( $data['ExpDate'] );
	    return $instance;
	}
	
	public function vertify() {
	    $data = PaymentDao::GetInstance()->getCreditCard( $this->name, $this->cardNumber, $this->cvv, $this->expDate );
	    $this->isVertify = $data['Number'] == $this->cardNumber;
	    print_r( $data );
	    return $this->isVertify;
	}
	
	public function pay( $amount ) {
	    if ( $this->isVertify == false ) return null;
	    if( PaymentDao::requestMoney( $this->cardNumber, $amount ) ) {
	    	echo("in pay");
		return Payment::CreatePayment( $this, $amount );
	    }
	    return null;
	}
	
	public function getBalance() {
	    return PaymentDao::GetInstance()->getBalance( $this->cardNumber );
	}
    }

?>
