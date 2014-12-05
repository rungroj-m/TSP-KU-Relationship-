<?php
    class Sale {
	public $id;
	public $payment;
	public $cart;
	public $customerDetail;
	
	public static function CreateSale( $payment, $cart, $customerDetail ) {
	    $instance = new self();
	    $instance->id = PaymentDao::GetInstance()->CreateSale( $payment, $cart, $customerDetail );
	    $instance->payment = $payment;
	    $instance->cart = $cart;
	    $instance->customerDetail = $customerDetail;
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
	
	public static function GetAllWithLimit( $limit, $page ) {
		$datas = PaymentDao::GetInstance()->GetAllSaleWithLimit( $limit, $page );
		$result = array();
		foreach( $datas as &$val ) {
			array_push( $result, Sale::dataToSale( $val ) );
		}
		return $result;
	}
	
	private static function dataToSale( $data ) {
	    $instance = new self();
	    $instance->cart = Cart::GetCart( $data['CartId'] );
	    $instance->payment = Payment::GetPayment( $data['PaymentId'] );
	    $instance->id = $data['SaleId'];
	    $instance->customerDetail = $data['CustomerDetail'];
	    return $instance;
	}
    }

?>
