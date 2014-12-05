<?php
    class WishList {
	
	public $id;
	public $closed;
	public $customer;
	public $lastUpdate;
	
	public static function GetWishListFromCustomer( $customer ) {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCurrentWishList( $customer->id );
	    return WishList::dataToWishList( $data );
	}
	
	public static function GetWishList( $id ) {
	    return WishList::dataToWishList( InventoryDao::getWishList( $id ) );
	}
	
	private static function dataToWishList( $data ){
	    $instance = new self();
	    $instance->id = $data['WishListId'];
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
	    $data = $dao->getWishListProducts($this->id);
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
		$data = $dao->getWishListProductsWithLimit( $this->id ,$limit,$pages );
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
	
	public function GetProductsCount() {
		return count($this->GetProducts());
	}
	
	public function ClearProducts() {
	    $products = $this->GetProducts();
	    foreach( $products as &$val ) {
		$this->RemoveProduct( $val['Product'], $val['Quantity'] );
	    }
	}
	
	public function AddProduct( $product, $amount ){
	    $dao = InventoryDao::GetInstance();
	    $dao->addToWishList( $this->customer->id, $product->id, $amount );
	}
	
	public function RemoveProduct( $product, $amount ) {
	    $dao = InventoryDao::GetInstance();
	    $dao->removeFromWishList( $this->customer->id, $product->id, $amount );
	}
	
	public function close() {
	    InventoryDao::GetInstance()->closeWishList( $this->id );
	}
	
	public function isWish($product){
		$all = $this->GetProducts();
		foreach( $all as &$detail ) {
		if($detail['Product'] == $product)
			return $detail['Quantity'];			
		}
		return 0;
	}
	
	
    }

?>