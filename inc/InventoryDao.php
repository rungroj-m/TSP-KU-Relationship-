<?php

    class InventoryDao {
    	
    	private $host="localhost";
    	private $user = "tsp";
    	private $password="YzxfyM4A6ZrBP9xv";
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
	    $STH = $this->db->prepare("INSERT INTO `InventoryTransactions`( `DateTime`, `ProductId`, `Quantity`, `Deposition` ) VALUES ( NOW(), :pid, :quantity, 1)" );
	    $STH->bindParam(':pid', $pid );
	    $STH->bindParam(':quantity', $amount );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function releaseInventory( $pid, $amount ) {
	    //TODO CHECK AMOUNT
	    $STH = $this->db->prepare("INSERT INTO `InventoryTransactions`( `DateTime`, `ProductId`, `Quantity`, `Deposition` ) VALUES ( NOW(), :pid, :quantity, 0)" );
	    $STH->bindParam(':pid', $pid );
	    $STH->bindParam(':quantity', $amount );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function getStockInventory( $pid ) {
	    $STH = $this->db->prepare("SELECT T2.ProductId, ( T1.income - T2.outcome ) AS Quantity FROM
				      ( SELECT IT.ProductId, SUM( IT.Quantity ) AS income FROM `InventoryTransactions` IT WHERE IT.ProductId = :pid AND DEPOSITION = 1 GROUP BY IT.ProductId ) T1
				      LEFT JOIN
				      ( SELECT IT.ProductId, SUM( IT.Quantity ) AS outcome FROM `InventoryTransactions` IT WHERE IT.ProductId = :pid AND DEPOSITION = 0 GROUP BY IT.ProductId ) T2
				    ON T1.ProductId = T2.ProductId" );
	    $STH->bindParam(':pid', $pid );
	    $STH->execute();
	    return $STH->fetch()['Quantity'];
	}
	
	public function releaseAllInventory( $pid ) {
	    $amount = $this->getStockInventory( $pid );
	    $STH = $this->db->prepare("INSERT INTO `InventoryTransactions`( `DateTime`, `ProductId`, `Quantity`, `Deposition` ) VALUES ( NOW(), :pid, :amount, 0)" );
	    $STH->bindParam(':pid', $pid );
	    $STH->bindParam(':amount', $amount );
	    $STH->execute();
	    return $amount;
	}
	
	public function changeProduct ( $oldPid, $newPid ) {
	    $this->addInventory( $newPid, $this->releaseAllInventory( $oldPid ) ) ;
	}
	
	public function addToCart( $customerId, $pid, $amount ) {
	    $cartId = $this->getCurrentCartId( $customerId );
	    $transactionId = $this->releaseInventory( $pid, $amount );
	    $STH = $this->db->prepare("INSERT INTO `CartTransactions`( `CartId`, `InventoryTransactionId` ) VALUES ( :cartId, :transactionId )" );
	    $STH->bindParam(':cartId', $this->getCurrentCartId( $customerId ) );
	    $STH->bindParam(':transactionId', $transactionId );
	    $STH->execute();
	    return $transactionId;
	}
	
	public function removeFromCart( $customerId, $pid, $amount ) {
	    //TODO CHECK REMOVE
	    $cartId = $this->getCurrentCartId( $customerId );
	    $transactionId = $this->addInventory( $pid, $amount );
	    $STH = $this->db->prepare("INSERT INTO `CartTransactions`( `CartId`, `InventoryTransactionId` ) VALUES ( :cartId, :transactionId )" );
	    $STH->bindParam(':cartId', $cartId );
	    $STH->bindParam(':transactionId', $transactionId );
	    $STH->execute();
	    return $transactionId;
	}
	
	public function  getCurrentCartId ( $customerId ) {
	    return $this->getCurrentCart( $customerId )['CartId'];
	}
	
	public function getCurrentCart ( $customerId ) {
	    $STH = $this->db->prepare("SELECT * FROM `Carts` WHERE `CustomerId` = :customerId AND `Closed` = 0");
	    $STH->bindParam(':customerId', $customerId );
	    $STH->execute();
	    if( $STH->rowCount() == 0 ) {
		$this->createCart( $customerId );
		return $this->getCurrentCart( $customerId );
	    }
	    $cartData = $STH->fetch();
	    return $cartData;
	}
	
	public function createCart ( $customerId ) {
	    $STH = $this->db->prepare("INSERT INTO `Carts`(`CustomerId`, `LastUpdate`, `Closed`) VALUES ( :customerId, NOW(), 0 )");
	    $STH->bindParam(':customerId', $customerId );
	    $STH->execute();
	    return $this->db->lastInsertId();
	}
	
	public function updateCart( $cartId ) {
	    $STH = $this->db->prepare("UPDATE `Carts` SET `LastUpdate` = NOW() WHERE `CartId` = ?" );
	    $STH->execute( array( $cartId ));
	}
	
	public function closeCart( $cartId ) {
	    $STH = $this->db->prepare("UPDATE `Carts`
					SET `Closed` = 1
					WHERE `CartId` = ?");
	    $STH->execute( array( $cartId ));
	}
	
	public function getCartTransactions( $cartId ) {
	    $STH = $this->db->prepare("SELECT * FROM `CartTransactions` CT
				      JOIN `InventoryTransactions` IT
				      ON IT.TransactionId = CT.TransactionId
				      WHERE CT.CartId = :cartId");
	    $STH->bindParam(':cartId', $cartId );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function getCartProducts( $cartId ) {
	    $STH = $this->db->prepare("SELECT T1.ProductId, ( T1.income - COALESCE( T2.outcome , 0 ) ) as Quantity FROM
					    ( SELECT IT.ProductId, SUM( IT.Quantity ) as income FROM `CartTransactions` CT
					    JOIN `InventoryTransactions` IT
					    ON IT.TransactionId = CT.InventoryTransactionId
					    WHERE CT.CartId = :cartId AND IT.Deposition = 0
					    GROUP BY IT.ProductId) T1
					LEFT JOIN
					    ( SELECT IT.ProductId, SUM( IT.Quantity ) as outcome FROM `CartTransactions` CT
					    JOIN `InventoryTransactions` IT
					    ON IT.TransactionId = CT.InventoryTransactionId
					    WHERE CT.CartId = :cartId AND IT.Deposition = 1
					    GROUP BY IT.ProductId ) T2
				      ON T1.ProductId = T2.ProductId");
	    $STH->bindParam(':cartId', $cartId );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function releaseCart( $customerId ) {
	    $data = $this.getCartProducts();
	    foreach ( $data as &$val ) {
		$this->removeFromCart( $customerId, $val['ProductId'], $val['Quantity'] );
	    }
	    $this->closeCart( $this->getCurrentCartId( $customerId ) );
	}
	
	public function purchaseCart() {
	    //TODO
	}
	
	public static function ReleaseUnpurchaseCart() {
	    
	}
    }
    
?>