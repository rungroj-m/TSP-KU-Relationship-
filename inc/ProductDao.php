<?php

	

    class ProductDao {
    	
    	private $host="localhost";
    	private $user = "tsp";
    	private $password="2BEJR9dhAA4xwExy";
    	private $database="ecomerce";
    	
	protected $db;
	public function __construct(){
	    $this->db = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password);
	}
	
	public static function GetInstance() {
	    static $dao;
	    if( $dao == NULL ) {
		$dao = new ProductDao();
	    }
	    return $dao;
	}
	
	private function addProductWithDescription( $categoryId, $brandId, $description, $modelCode, $productName ) {
	    
	}
	
	function addProductDescription( $CategoryId, $BrandId, $ProductName, $ModelCode, $Description, $AdditionTags, $CreateDate ) {
	    $STH = $this->db->prepare("insert into `ProductDescriptions`( `CategoryId`, `BrandId`, `ProductName`, `ModelCode`, `Description`, `CreateDate` ) values ( ?,?,?,?,?,? );");
	    $STH->execute( array( $CategoryId, $BrandId, $ProductName, $ModelCode, $Description, $CreateDate ) );
	    $id = $this->db->lastInsertId();
	
	    $tagIdArray = $this->addTags( array( $this->getCategoryById( $CategoryId ), $this->getBrandById( $BrandId ), $ProductName, $ModelCode ) );
	    $this->addProductDescriptionTagId( $id, $tagIdArray );
	    $addtionTagIdArray = $this->addTags( $AdditionTags );
	    $this->addAdditionProductDescriptionTagId( $id, $addtionTagIdArray );
	    return $id;
	}
	
	function addProduct( $ProductDescriptionId, $Price, $CreateDate, $Status ) {
	    $STH = $this->db->prepare("insert into `Products`( `ProductDescriptionId`, `Price`, `CreateDate`, `Status` ) values ( ?, ?, ?, ? );");
	    $STH->execute( array( $ProductDescriptionId, $Price, $CreateDate, $Status ) );
	    return $this->db->lastInsertId();
	}
	
	function addCategory( $categoryName ) {
	    $STH = $this->db->prepare("INSERT IGNORE INTO `Categories` SET `Name` = :name");
	    $STH->bindParam(':name', $categoryName );
	    $STH->execute();
	    $STH = $this->db->prepare("SELECT `CategoryId` FROM `Categories` WHERE `Name` = :name");
	    $STH->bindParam(':name', $categoryName );
	    $STH->execute();
	    $result = $STH->fetch();//->BrandId;
	    return $result['CategoryId'];
	}
	
	function addBrand( $brandName ) {
	    $STH = $this->db->prepare("INSERT IGNORE INTO `Brands` SET `Name` = :name");
	    $STH->bindParam(':name', $brandName );
	    $STH->execute();
	    $STH = $this->db->prepare("SELECT `BrandId` FROM `Brands` WHERE `Name` = :name");
	    $STH->bindParam(':name', $brandName );
	    $STH->execute();
	    $result = $STH->fetch();//->BrandId;
	    return $result['BrandId'];
	}
	
	function getCategoryById( $categoryId ) {
	    $STH = $this->db->prepare("SELECT `Name` FROM `Categories` WHERE `CategoryId` = :id");
	    $STH->bindParam(':id', $categoryId );
	    $STH->execute();
	    $result = $STH->fetch();//->BrandId;
	    return $result['Name'];
	}
	
	function getBrandById( $brandId ) {
	    $STH = $this->db->prepare("SELECT `Name` FROM `Brands` WHERE `BrandId` = :id");
	    $STH->bindParam(':id', $brandId );
	    $STH->execute();
	    $result = $STH->fetch();//->BrandId;
	    return $result['Name'];
	}
	
	function getProductById( $pid ) {
	    $STH = $this->db->prepare("SELECT * FROM `Products` WHERE `ProductId` = :id");
	    $STH->bindParam(':id', $pid );
	    $STH->execute();
	    $result = $STH->fetch();
	    return $result;
	}
	
	function getProductDescriptionById( $pdid ) {
	    $STH = $this->db->prepare("SELECT * FROM `ProductDescriptions` WHERE `ProductDescriptionId` = :id");
	    $STH->bindParam(':id', $pdid );
	    $STH->execute();
	    $result = $STH->fetch();
	    return $result;
	}
	
	function getEnabledProductByProductDescriptionId ( $pdid ) {
	    $STH = $this->db->prepare("SELECT `ProductId` FROM `Products` WHERE `ProductDescriptionId` = :id AND `status` = true");
	    $STH->bindParam(':id', $pdid );
	    $STH->execute();
	    $result = $STH->fetch();
	    return $result[0];
	}
	
	function disableProductFromProductDescriptionID( $productDescriptionId ) {
	    $STH = $this->db->prepare("SELECT `ProductId` FROM `Products` WHERE `Status` = 1");
	    $STH->execute();
	    $result = $STH->fetch();
	    $this->removeProductTagId ( $result['ProductId'] );
	    
	    $STH = $this->db->prepare("update `Products` set `Status`=0 where `ProductDescriptionId`=:id and `Status`=1");
	    $STH->bindParam(':id', $productDescriptionId);
	    $STH->execute();
	}
	
	function getProductDescriptionIdByCategoryId( $categoryId ) {
	    $STH = $this->db->prepare( "SELECT ProductDescriptionId FROM ProductDescriptions WHERE CategoryId = $categoryId" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	private function addProductTagId( $productId, $tagIdArray ) {
	    $query = "insert into `ProductTags` (Key) values ";
	    foreach ( $tagIdArray as &$value ) {
		$query .= "( $productId , $value ),";
	    }
	    $query = substr($query, 0, -1);
	    $STH = $this->db->prepare( $query );
	    $STH->execute();
	}
	
	private function addTags( $keyArray ) {
	    $array = array();
	    foreach ($keyArray as &$value) {
		array_push( $array, $this->addTag( $value ) );
	    }
	    return $array;
	}
	
	private function getTags( $keyArray ) {
	    $array = array();
	    foreach ($keyArray as &$value) {
		array_push( $array, $this->getTag( $value ) );
	    }
	    return $array;
	}
    
	private function addTag( $key ) {
	    $STH = $this->db->prepare("INSERT IGNORE INTO `Tags` SET `Key` = :key");
	    $STH->bindParam(':key', $key);
	    $STH->execute();
	    return $this->getTag( $key );
	}
	
	private function getTag( $key ) {
	    $STH = $this->db->prepare("SELECT `TagId` FROM `Tags` WHERE `Key` = :key");
	    $STH->bindParam(':key', $key );
	    $STH->execute();
	    $result = $STH->fetch();
	    return $result['TagId'];
	}
	
	public function findProductDescriptionByTags( $tagArray ) {
	    $tagIds = $this->getTags( $tagArray );
	    $array = $this->findProductDescriptionByTagIds( $tagIds );
	    $returnArray = array();
	    foreach ( $array as &$value ) {
		array_push( $returnArray, ProductDescription::GetProductDescription( $value['ProductDescriptionId'] ) );
	    }
	    return $returnArray;
	}
	
	private function findProductDescriptionByTagIds( $tagArray ) {
	    $tagCount = count( $tagArray );
	    $orQuery = "";
	    foreach ( $tagArray as &$value ) {
		$orQuery .= " PDT.TagId = $value OR";
	    }
	    $orQuery = substr($orQuery, 0, -2);
	    $query = "SELECT PD.ProductDescriptionId, PD.CategoryId, C.Name, PD.BrandId, B.Name, PD.ProductName, PD.ModelCode, PD.Description, PD.CreateDate 
		    FROM (SELECT TCD.ProductDescriptionId
			FROM (SELECT PDT.ProductDescriptionId, Count( PDT.TagId ) as TC
				FROM ProductDescriptionTags PDT
				WHERE$orQuery
				GROUP BY PDT.ProductDescriptionId) as TCD
			WHERE TCD.TC = $tagCount) as PD2
		    JOIN (Categories C
			JOIN (Brands B
			    JOIN ProductDescriptions PD
			    ON B.BrandId = PD.BrandId)
			ON C.CategoryId = PD.CategoryId)
		    ON PD2.ProductDescriptionId = PD.ProductDescriptionId";
	    $STH = $this->db->prepare( $query );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function addAdditionProductDescriptionTagId ( $productDescriptionId, $tagIdArray ) {
	    $this->addTagIdByTable( 'AdditionProductDescriptionTags', $productDescriptionId, $tagIdArray );
	}
	
	public function addProductDescriptionTagId( $productDescriptionId, $tagIdArray ) {
	    $this->addTagIdByTable( 'ProductDescriptionTags', $productDescriptionId, $tagIdArray );
	}
	
	private function addTagIdByTable ( $table, $productDescriptionId, $tagIdArray ) {
	    $query = "insert into `$table` (`ProductDescriptionId`, `TagId`) values ";
	    foreach ( $tagIdArray as &$value ) {
		$query .= "( $productDescriptionId , $value ),";
	    }
	    $query = substr($query, 0, -1);
	    $STH = $this->db->prepare( $query );
	    $STH->execute();
	}
	
	private function removeProductDescriptionTag( $productId ) {
	    $this->removeItemByTable( 'ProductDescriptionTags', $productId );
	    $this->removeItemByTable( 'AdditionProductDescriptionTags', $productId );
	}
	
	private function removeItemByTable( $table, $primaryId ) {
	    $STH = $this->db->prepare("delete from `$table` where `$primaryId` = :id");
	    $STH->bindParam(':id', $primaryId);
	    $STH->execute();
	}
	
	
	
    }
    
 
    require_once('Product.php');
    require_once('ProductDescription.php');
    require_once('DataInfo.php');
    require_once('Brand.php');
    require_once('Category.php');
    
    
?>