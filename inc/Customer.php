<?php
    class Customer {
    	
    	public $id;
    	public $firstName;
    	public $lastName;
    	public $username;
	public $isBlocked;
	public $Address;
    	
	public static function Authenticate( $username, $password ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getCustomer( $dao->authCustomer( $username, $password ) );
	    
	    return Customer::dataToCustomer( $data );
	}
	
	private static function dataToCustomer( $data ){
	    $result = new self();
	    $result->id = $data['CustomerId'];
	    $result->firstName = $data['FirstName'];
	    $result->lastName = $data['LastName'];
	    $result->username = $data['UserName'];
	    $result->Address = $data['Address'];
	    $result->isBlocked = $data['Blocked'];
	    return $result;
	}
	
	public static function CreateCustomer( $firstName, $lastName, $username, $password ,$address ) {
	    $dao = CustomerDao::GetInstance();
	    $cusId = $dao->addCustomer( $firstName, $lastName, $username, $password, $address, 0 );
	    
	    $result = new self();
	    $result->id = $cusId;
	    $result->firstName = $firstName;
	    $result->lastName = $lastName;
	    $result->username = $username;
	    $result->isBlocked = 0;
	    $result->Address = $address;
	    return $result;
	}
	
	public function updateCustomer() {
	    CustomerDao::GetInstance()->updateCustomer( $this->id, $this->firstName, $this->lastName, $this->username, $this->Address, $this->isBlocked );
	}
	
	public function updatePassword( $pass ) {
	    CustomerDao::GetInstance()->updatePassword( $this->id, $pass );
	}
	
	public static function GetCustomer( $customerId ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getCustomer( $customerId );
	    return Customer::dataToCustomer( $data );
    	}
	
	public function getCart() {
	    return Cart::GetCartFromCustomer( $this );
	}
	
	public function getWishList (){
	    return WishList::GetWishListFromCustomer( $this );
	}
	
	public static function getAllCustomers(){
		$dao = CustomerDao::GetInstance();
		$datas =  $dao->getAllCustomers();
		$return = array();
		foreach($datas as &$data) {
			$customer = Customer::dataToCustomer( $data ) ; 
			array_push($return, $customer);
		}
		return $return;
	}
	
	public static function getAllBlockedCustomers(){
		$dao = CustomerDao::GetInstance();
		$datas =  $dao->getAllBlockedCustomers();
		$return = array();
		foreach($datas as &$data) {
			$customer = Customer::dataToCustomer( $data ) ;
			array_push($return, $customer);
		}
		return $return;
	}
	
    }
    
    /*require_once( "Product.php" );
    require_once( "ProductDao.php");
    require_once( "CustomerDao.php" );
    require_once( "WishList.php" );
    require_once( "Sale.php" );
    require_once( "PaymentDao.php" );
    require_once( "Payment.php" );
    require_once( "Product.php" );
    require_once( "ProductDao.php" );
    require_once( "Cart.php" );
    require_once( "CreditCard.php" );
    require_once( "InventoryDao.php" );
    
    
    print_r( Cart::GetCart( 4 )->GetProducts() );
    //Customer::GetCustomer( 0 )->getWishList()->AddProduct( Product::GetProduct( 20 ), 1 );*/
    
?>