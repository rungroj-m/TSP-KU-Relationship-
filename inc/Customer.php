<?php
    class Customer {
    	
    	public $id;
    	public $firstName;
    	public $lastName;
    	public $username;
    	
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
	    return $result;
	}
	
	public static function CreateCustomer( $firstName, $lastName, $username, $password ) {
	    $dao = CustomerDao::GetInstance();
	    $cusId = $dao->addCustomer( $firstName, $lastName, $username, $password );
	    
	    $result = new self();
	    $result->id = $cusId;
	    $result->firstName = $firstName;
	    $result->lastName = $lastName;
	    $result->username = $username;
	    return $result;
	}
	
	public static function GetCustomer( $customerId ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getCustomer( $customerId );
	    return Customer::dataToCustomer( $data );
    	}
	
	public function getCart() {
	    return Cart::GetCartFromCustomer( $this );
	}
    }
?>