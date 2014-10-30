<?php

    class InventoryDao {
    	
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
		$dao = new InventoryDao();
	    }
	    return $dao;
	}
	
	public function addInventory( $pid, $amount ) {
	    
	}
	
	public function removeInventory( $pid, $amount ) {
	    
	}
	
	public function removeAllInventory( $pid ) {
	    
	}
	
	public function changeProduct ( $oldPid, $newPid ) {
	    
	}
	
	public function addToCart( $customerId, $pid, $amount ) {
	    
	}
	
	public function  getCurrentCart ( $customerId ) {
	    
	}
	
	public function removeFromCart( $customerId, $pid, $amount ) {
	
	}
	
	public function removeAllFromCart( $customerId ) {
	    
	}
	
	public function purchaseCart() { //TODO
	    
	}
    }
    
?>