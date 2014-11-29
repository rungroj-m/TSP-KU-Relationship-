<?php
    class Cart {
	
	public $cartId;
	public $closed;
	public $customer;
	public $lastUpdate;
	
	public static function GetCartFromCustomer( $customer ) {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCurrentCart( $customer->id );
	    return Cart::dataToCart( $data );
	}
	
	public static function GetCart( $cartId ) {
	    return Cart::dataToCart( InventoryDao::getCart( $cartId ) );
	}
	
	private static function dataToCart( $data ){
	    $instance = new self();
	    $instance->cartId = $data['CartId'];
	    $instance->closed = $data['Closed'];
	    $instance->customer = Customer::GetCustomer( $data['CustomerId'] );
	    $instance->lastUpdate = $data['LastUpdate']; //Not sure;
	    return $instance;
	}
	
	public function purchase( $creditCard ) {
	    if( $creditCard->isVertify == false ) throw new Exception("Credit Card Didn't Vertify");
	    $payment = $creditCard->pay( $this->GetTotalPrice() );
	    if( $payment == null ) throw new Exception( "Cannot Request Money From this Credit Card." );
	    $this->close();
	    return Sale::CreateSale( $payment, $this );
	}
	
	public function GetTotalPrice() {
	    $products = $this->GetProducts();
	    $total = 0;
	    foreach( $products as &$product ) {
		$total = $total + ( $product['Product']->price * $product['Quantity'] );
	    }
	    return Promotion::Total( $total );
	}
	
	public function GetProducts() {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCartProducts( $dao->getCurrentCartId( $this->customer->id ) );
	    $result = array();
	    foreach( $data as &$val ) {
		$detail = array();
		if( $val['Quantity'] == 0 ) continue;
		$detail['Product'] = Product::GetProduct( $val['ProductId'] );
		$detail['Quantity'] = $val['Quantity'];
		array_push( $result, $detail );
	    }
	    return $result;
	}
	
	public function ClearProducts() {
	    $products = $this->GetProducts();
	    foreach( $products as &$val ) {
		$this->RemoveProduct( $val['Product'], $val['Quantity'] );
	    }
	}
	
	public function AddProduct( $product, $amount ){
	    $dao = InventoryDao::GetInstance();
	    $dao->addToCart( $this->customer->id, $product->id, $amount );
	}
	
	public function RemoveProduct( $product, $amount ) {
	    $dao = InventoryDao::GetInstance();
	    $dao->removeFromCart( $this->customer->id, $product->id, $amount );
	}
	
	public function close() {
	    InventoryDao::GetInstance()->closeCart( $this->cartId );
	}
	
    }

?>