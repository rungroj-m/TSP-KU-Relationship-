<?php

	

    class PaymentDao {
    	
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
		$dao = new PaymentDao();
	    }
	    return $dao;
	}
	
	public function createCreditCard( $name, $number, $cvv, $expDate ) {
	    $STH = $this->db->prepare(  "INSERT INTO `CreditCards`(`Number`, `Cvv`,`Name`,`ExpDate`) VALUES ( :number, :cvv, :name, :expDate)" );
	    $STH->bindParam(':number', $number );
	    $STH->bindParam(':cvv', $cvv );
	    $STH->bindParam(':name', $name );
	    $STH->bindParam(':expDate', $expDate->format('Y-m-d H:i:s') );
	    $STH->execute();
	}
	
	public function CreateSale( $payment, $cart ) {
	    $STH = $this->db->prepare(  "INSERT INTO `Sales`(`CartId`, `PaymentId` ) VALUES ( :cartId, :paymentId)" );
	    $STH->bindParam(':cartId', $cart->cartId );
	    $STH->bindParam(':paymentId', $payment->id );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function GetAllSale() {
	    $STH = $this->db->prepare(  "SELECT * FROM `Sales`" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function getCreditCard( $name, $number, $cvv, $expDate ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `CreditCards` WHERE `Name` = :name AND `Number` = :number AND `Cvv` = :cvv AND `ExpDate` = :expDate" );
	    $STH->bindParam(':name', $name );
	    $STH->bindParam(':number', $number );
	    $STH->bindParam(':cvv', $cvv );
	    $STH->bindParam(':expDate', $expDate->format('Y-m-d') );
	    $STH->execute();
	    return $STH->fetch();
	}
	
	public function getCreditCardByNumber( $number ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `CreditCards` WHERE `Number` = :number " );
	    $STH->bindParam(':number', $number );
	    $STH->execute();
	    return $STH->fetch();
	}
	
	public function setBalance( $creditCardNumber , $balance ) {
	    $STH = $this->db->prepare(  "UPDATE `CreditCards` SET `Balance` = $balance WHERE `Number` = $creditCardNumber" );
	    $STH->execute();
	}
    
	public function getBalance( $creditCardNumber ) {
	    $STH = $this->db->prepare(  "SELECT `Balance` FROM `CreditCards` WHERE `Number` = $creditCardNumber" );
	    $STH->execute();
	    return $STH->fetch()['Balance'];
	}
	
	public function requestMoney( $creditCardNumber, $amount ) {
	    $balance = $this->getBalance( $creditCardNumber );
	    if( $balance >= $amount ) {
		PaymentDao::GetInstance()->setBalance( $creditCardNumber, $balance - $amount );
		return true;
	    }
	    return false;
	}
	
	public function createPayment( $creditCardNumber, $amount, $dateTime ) {
	    $STH = $this->db->prepare(  "INSERT INTO `Payments`(`DateTime`, `CreditCardNumber`,`Amount`) VALUES ( :dt, :ccn, :amount)" );
	    $STH->bindParam(':ccn', $creditCardNumber );
	    $STH->bindParam(':amount', $amount );
	    $STH->bindParam(':dt', $dateTime->format('Y-m-d H:i:s') );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function getPayment( $paymentId ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `Payments` WHERE `PaymentId` = $paymentId" );
	    $STH->execute();
	    return $STH->fetch();
	}
	
	public function addPromotion( $type, $percent, $startDate, $endDate, $adminId ) {
	    $STH = $this->db->prepare(  "INSERT INTO `Promotions`(`Type`, `Value`, `StartDate`, `EndDate`, `AdminId`) VALUES ( :type, :val, :std, :ed, :adminId )" );
	    $STH->bindParam(':type', $type );
	    $STH->bindParam(':val', $percent );
	    $STH->bindParam(':std', $startDate->format('Y-m-d H:i:s') );
	    $STH->bindParam(':ed', $endDate->format('Y-m-d H:i:s') );
	    $STH->bindParam(':adminId', $adminId );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function deletePromotion( $promotionId ) {
	    $STH = $this->db->prepare(  "DELETE FROM `Promotions` WHERE `PromotionId` = $promotionId" );
	    $STH->execute();
	}
	
	public function getAllPromotion() {
	    $STH = $this->db->prepare(  "SELECT * FROM `Promotions`" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function getFurtherPromotion() {
	    $STH = $this->db->prepare(  "SELECT * FROM `Promotions` WHERE `EndDate` >= NOW()" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function getCurrentPromotion() {
	    $STH = $this->db->prepare(  "SELECT * FROM `Promotions` WHERE `StartDate` <= NOW() AND `EndDate` >= NOW()" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
    }
    
?>
