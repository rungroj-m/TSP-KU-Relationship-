<?php
    class Cart {
	
	public $cartId;
	public $closed;
	public $customer;
	public $lastUpdate;
	public $fee;
	
	public static function GetCartFromCustomer( $customer ) {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCurrentCart( $customer->id );
	    return Cart::dataToCart( $data );
	}
	
	public static function GetCart( $cartId ) {
	    return Cart::dataToCart( InventoryDao::GetInstance()->getCart( $cartId ) );
	}
	
	private static function dataToCart( $data ){
	    $instance = new self();
	    $instance->cartId = $data['CartId'];
	    $instance->closed = $data['Closed'];
	    $instance->customer = Customer::GetCustomer( $data['CustomerId'] );
	    $instance->lastUpdate = $data['LastUpdate']; //Not sure;
	    return $instance;
	}
	
	public function purchase( $creditCard, $customerDetail ) {
		if($creditCard->vertify() == 0) return null;
	    $payment = $creditCard->pay( $this->GetTotalPrice() );
	    if( $payment == null ) return null;
	    $this->close();
	    return Sale::CreateSale( $payment, $this, $customerDetail );
	}
	
	public function GetTotalPrice() {
	    $products = $this->GetProducts();
	    $total = 0;
	    foreach( $products as &$product ) {
		$total = $total + ( $product['Product']->price * $product['Quantity'] );
	    }
	    return Promotion::Total( $total ) + $this->fee;
	}
	
	public function setFee($fee){
		$this->fee = $fee;
	}
	
	public function GetProducts() {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCartProducts( $this->cartId );
	    $data = $dao->getCartProducts( $this->cartId );
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
	
	public function GetProductsWithLimit( $limit, $pages ) {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCartProductsWithLimit( $this->cartId, $limit, $pages );
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
