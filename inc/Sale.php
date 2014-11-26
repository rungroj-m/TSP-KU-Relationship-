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
    }

?>
