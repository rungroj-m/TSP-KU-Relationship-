<?php
    class Sale {
	public $id;
	public $payment;
	public $cart;
	
	public static function CreateSale( $payment, $cart ) {
	    $instance = new self();
	    $instance->id = PaymentDao::GetInstance()->CreateSale( $payment, $cart );
	    $instance->payment = $payment;
	    $instance->cart = $cart;
	    return $instance;
	}
	
	public function GetCustomer() {
	    return $cart->customer;
	}
	
	public static function GetAll() {
	    $datas = PaymentDao::GetInstance()->GetAllSale();
	    $result = array();
	    foreach( $datas as &$val ) {
		array_push( $result, Sale::dataToSale( $val ) );
	    }
	    return $result;
	}
	
	private static function dataToSale( $data ) {
	    $instance = new self();
	    $instance->cart = Cart::GetCart( $data['CartId'] );
	    $instance->payment = Payment::GetPayment( $data['Payment'] );
	    $instance->id = $data['SaleId'];
	    return $instance;
	}
    }

?>
