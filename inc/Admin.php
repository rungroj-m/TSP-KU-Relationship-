<?php
    class Admin {
    	
    	public $id;
    	public $firstName;
    	public $lastName;
    	public $username;
	public $level;
	
	public static function Authenticate( $username, $password ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getAdmin( $dao->authAdmin( $username, $password ) );
	    return Admin::dataToAdmin( $data );
	}
	
	private static function dataToAdmin( $data ){
	    $result = new self();
	    $result->id = $data['AdminId'];
	    $result->firstName = $data['FirstName'];
	    $result->lastName = $data['LastName'];
	    $result->username = $data['UserName'];
	    $result->level = $data['Level'];
	    return $result;
	}
	
	public static function CreateAdmin( $firstName, $lastName, $username, $password, $level ) {
	    $dao = CustomerDao::GetInstance();
	    $cusId = $dao->addAdmin( $firstName, $lastName, $username, $password, $level );
	    
	    $result = new self();
	    $result->id = $cusId;
	    $result->firstName = $firstName;
	    $result->lastName = $lastName;
	    $result->username = $username;
	    $result->level = $level;
	    return $result;
	}
	
	public static function GetAdmin( $adminId ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getAdmin( $customerId );
	    return Admin::dataToCustomer( $data );
    	}
	
	public function addPercentPromotion( $percent, $startDate, $endDate ) {
	    return Promotion::CreatePercentPromotion( $percent, $startDate, $endDate , $this );
	}
	
	public function getSales() {
	    if ( $level == 0 ) {
		Sale::getAll();
	    }
	    return null;
	}
	
    }
?>