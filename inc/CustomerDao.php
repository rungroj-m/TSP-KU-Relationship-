<?php
    class CustomerDao {
    	
    	/*private $host="knotsupavit.in.th";
    	private $user = "knotsupavi_tsp";
    	private $password="1!Qqqqqq";
    	private $database="knotsupavi_tsp";
    	*/
	
	private $host="localhost";
    	private $user = "tsp";
    	private $password="tsp";
    	private $database="ecomerce";
    	
	protected $db;
	public function __construct(){
	    $this->db = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password);
	}
	
	public static function GetInstance() {
	    static $dao;
	    if( $dao == NULL ) {
		$dao = new CustomerDao();
	    }
	    return $dao;
	}
	
	public function addCustomer( $firstName, $lastName, $username, $password, $address, $isBlocked ) {
	    $STH = $this->db->prepare("INSERT INTO `Customers`( `FirstName`, `LastName`, `UserName`, `Password`, `Address`, `Blocked`  ) VALUES ( :firstName, :lastName, :userName, :password, :address, :blocked)" );
	    $STH->bindParam(':firstName', $firstName );
	    $STH->bindParam(':lastName', $lastName );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':password', md5( $password ) );
	    $STH->bindParam(':address', $address );
	    $STH->bindParam(':blocked', $isBlocked );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function updateCustomer( $id, $firstName, $lastName, $username, $address, $isBlocked ) {
	    $STH = $this->db->prepare( "UPDATE `Customers` SET `FirstName` = :fn, `LastName` = :ln, `UserName` = :un, `Address` = :ad, `Blocked` = :bk WHERE `CustomerId` = $id" );
	    $STH->bindParam(':fn', $firstName );
	    $STH->bindParam(':ln', $lastName );
	    $STH->bindParam(':un', $username );
	    $STH->bindParam(':ad', $address );
	    $STH->bindParam(':bk', $isBlocked );
	    $STH->execute();
	}
	
	public function authCustomer( $username, $password ) {
	    $STH = $this->db->prepare(  "SELECT `CustomerId` FROM `Customers` WHERE `UserName` = :userName AND `Password` = :pass" );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':pass', md5( $password ) );
	    $STH->execute();
	    if ( $STH->rowCount() == 0 ) return null;
	    return $STH->fetch()['CustomerId'];
	}
	
	public function updatePassword( $customerId, $pass ) {
	     $STH = $this->db->prepare( "UPDATE `Customers` SET `Password` = :pw WHERE `CustomerId` = $customerId" );
	     $STH->bindParam(':pw', md5( $password ) );
	     $STH->execute();
	}
	
	public function getCustomer( $customerId ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `Customers` WHERE `CustomerId` = :cusId" );
	    $STH->bindParam(':cusId', $customerId );
	    $STH->execute();
	    return $STH->fetch();
	}
	
	public function getAdmin( $adminId ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `Admins` WHERE `AdminId` = :cusId" );
	    $STH->bindParam(':cusId', $adminId );
	    $STH->execute();
	    return $STH->fetch();
	}
	
	public function addAdmin( $firstName, $lastName, $username, $password, $level ) {
	    $STH = $this->db->prepare("INSERT INTO `Admins`( `FirstName`, `LastName`, `UserName`, `Password`, `Level` ) VALUES ( :firstName, :lastName, :userName, :password, :level)" );
	    $STH->bindParam(':firstName', $firstName );
	    $STH->bindParam(':lastName', $lastName );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':password', md5( $password ) );
	    $STH->bindParam(':level', $level );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function authAdmin( $username, $password ) {
	    $STH = $this->db->prepare(  "SELECT `AdminId` FROM `Admins` WHERE `UserName` = :userName AND `Password` = :pass" );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':pass', md5( $password ) );
	    $STH->execute();
	    if ( $STH->rowCount() == 0 ) return null;
	    return $STH->fetch()['AdminId'];
	}
	
	public function getAllCustomers(){
		$STH = $this->db->prepare(  "SELECT * FROM `Customers`" );
		$STH->execute();
		return $STH->fetchAll();		
	}
	
	public function getAllBlockedCustomers(){
		$STH = $this->db->prepare(  "SELECT * FROM `Customers` WHERE `Blocked`=1" );
		$STH->execute();
		return $STH->fetchAll();
	}
	
	
	public function getAllAdmins(){
		$STH = $this->db->prepare(  "SELECT * FROM `Admins`" );
		$STH->execute();
		return $STH->fetchAll();
		
	}
	
    }
    
?>