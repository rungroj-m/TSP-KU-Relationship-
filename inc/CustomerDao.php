<?php
    class CustomerDao {
    	
    	private $host="localhost";
    	private $user = "benzsuankularb";
    	private $password="benzsk130";
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
	
	public function addCustomer( $firstName, $lastName, $username, $password ) {
	    $STH = $this->db->prepare("INSERT INTO `Customers`( `FirstName`, `LastName`, `UserName`, `Password` ) VALUES ( :firstName, :lastName, :userName, :password)" );
	    $STH->bindParam(':firstName', $firstName );
	    $STH->bindParam(':lastName', $lastName );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':password', md5( $password ) );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function authCustomer( $username, $password ) {
	    $STH = $this->db->prepare(  "SELECT `FirstName` , `LastName` , `UserName` FROM `Customers` WHERE `UserName` = :userName AND `Password` = :pass" );
	    $STH->bindParam(':userName', $username );
	    $STH->bindParam(':pass', md5( $password ) );
	    $STH->execute();
	    return $STH->fetch();
	}
	
    }
    
?>