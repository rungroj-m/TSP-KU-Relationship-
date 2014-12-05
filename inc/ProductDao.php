<?php
    class ProductDao {
    	
    	/*private $host="knotsupavit.in.th";
    	private $user = "knotsupavi_tsp";
    	private $password="1!Qqqqqq";
    	private $database="knotsupavi_tsp";
    	*/
	
	public static $PRODUCT_CREATE_DATE = 'CreateDate';
	//public static $PRODUCT_NAME = 'Price';
	public static $PRODUCT_PRICE = 'Price';
	
	public static $OrderBy;
	private $host="localhost";
    	private $user = "tsp";
    	private $password="tsp";
    	private $database="ecomerce";
    	
	protected $db;
	public function __construct(){
	    ProductDao::$OrderBy = ProductDao::$PRODUCT_CREATE_DATE;
	    $this->db = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password);
	}
	
	public static function GetInstance() {
	    static $dao;
	    if( $dao == NULL ) {
		$dao = new ProductDao();
	    }
	    return $dao;
	}
	
	public function addProductDescriptionImages( $pdid, $images ) {
	    $val = "";
	    foreach ( $images as &$value ) {
			$val .= "( $pdid , '$value' ),";
 	    }
	    $val = substr($val, 0, -1);
	    $STH = $this->db->prepare(  "INSERT INTO `ProductImages`(`ProductDescriptionId`, `ImageAddress`) VALUES $val" );
	    $STH->execute();
	}
	
	public function getImagesByProductDescriptionId( $pdid ) {
	    $STH = $this->db->prepare(  "SELECT * FROM `ProductImages` WHERE `ProductDescriptionId` = $pdid" );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	function addProductDescription( $CategoryId, $BrandId, $ProductName, $ModelCode, $Description, $AdditionTags, $CreateDate, $Weight ) {
	    $STH = $this->db->prepare("insert into `ProductDescriptions`( `CategoryId`, `BrandId`, `ProductName`, `ModelCode`, `Description`, `CreateDate`, `Weight` ) values ( ?,?,?,?,?,?,? );");
	    $STH->execute( array( $CategoryId, $BrandId, $ProductName, $ModelCode, $Description, $CreateDate, $Weight ) );
	    $id = $this->db->lastInsertId();
	    $this->arrangeTag( $id, $CategoryId, $BrandId, $ProductName, $ModelCode, $AdditionTags );
	    
	    return $id;
	}
	
	function editProductDescription( $pdid, $CategoryId, $BrandId, $ProductName, $ModelCode, $Description, $AdditionTags,$Weight ) {
	    $STH = $this->db->prepare("update `ProductDescriptions` set `CategoryId` = :cid, `BrandId` = :bid, `ProductName` = :pn,`Description` = :des, `ModelCode` = :mc , `Weight` = :weight where `ProductDescriptionId`=:id" );
	    $STH->bindParam(':id', $pdid );
	    $STH->bindParam(':cid', $CategoryId );
	    $STH->bindParam(':bid', $BrandId );
	    $STH->bindParam(':des', $Description );
	    $STH->bindParam(':pn', $ProductName );
	    $STH->bindParam(':mc', $ModelCode );
	    $STH->bindParam(':weight', $Weight );
	    //$STH->bindParam(':cd', $CreateDate->format('Y-m-d H:i:s') );
	    $STH->execute();
	    $this->removeProductDescriptionTag( $pdid );
	    $this->arrangeTag( $pdid, $CategoryId, $BrandId, $ProductName, $ModelCode, $AdditionTags );
	    return $pdid;
	}
	
	private function arrangeTag( $Pdid, $CategoryId, $BrandId, $ProductName, $ModelCode, $AdditionTags ) {
	    $tagIdArray = $this->addTags( array( $this->getCategoryById( $CategoryId ), $this->getBrandById( $BrandId ), $ProductName, $ModelCode ) );
	    $this->addProductDescriptionTagId( $Pdid, $tagIdArray );
	    $addtionTagIdArray = $this->addTags( $AdditionTags );
	    //print_r( $addtionTagIdArray );
	    $this->addAdditionProductDescriptionTagId( $Pdid, $addtionTagIdArray );
	}
	
	function addProduct( $ProductDescriptionId, $Price, $CreateDate, $Status ) {
	    $STH = $this->db->prepare("insert into `Products`( `ProductDescriptionId`, `Price`, `CreateDate`, `Status` ) values ( ?, ?, ?, ? );");
	    $STH->execute( array( $ProductDescriptionId, $Price, $CreateDate, $Status ) );
	    
	    $pid = $this->db->lastInsertId();
	    InventoryDao::GetInstance()->addInventory( $pid, 0 );
	    InventoryDao::GetInstance()->releaseInventory( $pid, 0 );
	    
	    return $pid;
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
	
	function getActiveProducts() {
	    $sort = ProductDao::$OrderBy;
	    $STH = $this->db->prepare("SELECT * FROM `Products` WHERE `Status` = 1 ORDER BY `$sort`");
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	function getActiveProductsCount() {
	    $sort = ProductDao::$OrderBy;
	    $STH = $this->db->prepare("SELECT COUNT(*) as c FROM `Products` WHERE `Status` = 1 ORDER BY `$sort`");
	    $STH->execute();
	    return $STH->fetch()['c'];
	}
	
	function getActiveProductsWithLimit( $limit, $pages ) {
	    $pages = $pages - 1;
	    $sort = ProductDao::$OrderBy;
	    $STH = $this->db->prepare("SELECT * FROM `Products` WHERE `Status` = 1 ORDER BY `$sort` LIMIT $limit OFFSET $pages");
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	function getProductDescriptionById( $pdid ) {
	    $STH = $this->db->prepare("SELECT * FROM `ProductDescriptions` WHERE `ProductDescriptionId` = :id");
	    $STH->bindParam(':id', $pdid );
	    $STH->execute();
	    $result = $STH->fetch();
	    
	    $data = $this->getAdditionTagByProductDescriptionId( $pdid );
	    $arr = array();
	    foreach( $data as &$val ) {
		array_push( $arr , $val['Key'] );
	    }
	    $result['AdditionalTags'] = $arr;
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
	    
	    $STH = $this->db->prepare("update `Products` set `Status`=0 where `ProductDescriptionId`=:id and `Status`=1");
	    $STH->bindParam(':id', $productDescriptionId);
	    $STH->execute();
	}
	
	function disableProduct( $pid ) {
	    $STH = $this->db->prepare("SELECT `ProductId` FROM `Products` WHERE `Status` = 1");
	    $STH->execute();
	    $result = $STH->fetch();
	    
	    $STH = $this->db->prepare("update `Products` set `Status`=0 where `ProductId`=:id and `Status`=1");
	    $STH->bindParam(':id', $pid);
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
	    $key = strtolower( $key );
	    $STH = $this->db->prepare("INSERT IGNORE INTO `Tags` SET `Key` = :key");
	    $STH->bindParam(':key', $key);
	    $STH->execute();
	    return $this->getTag( $key );
	}
	
	private function getTag( $key ) {
	    $key = strtolower( $key );
	    $STH = $this->db->prepare("SELECT `TagId` FROM `Tags` WHERE `Key` = :key");
	    $STH->bindParam(':key', $key );
	    $STH->execute();
	    $result = $STH->fetch();
	    return $result['TagId'];
	}
	
	public function findProductDescriptionByTags( $tagArray ) {
	    $tagIds = $this->getTags( array_unique( array_map('strtolower', $tagArray) ) );
	    $array = $this->findProductDescriptionByTagIds( $tagIds );
	    $returnArray = array();
	    foreach ( $array as &$value ) {
		array_push( $returnArray, ProductDescription::GetProductDescription( $value['ProductDescriptionId'] ) );
	    }
	    return $returnArray;
	}
	
	public function findProductDescriptionByTagsWithLimit( $tagArray ,$limit, $pages) {
	    $tagIds = $this->getTags( array_unique( array_map('strtolower', $tagArray) ) );
	    $array = $this->findProductDescriptionByTagIdsWithLimit( $tagIds, $limit, $pages );
	    $returnArray = array();
	    foreach ( $array as &$value ) {
		array_push( $returnArray, ProductDescription::GetProductDescription( $value['ProductDescriptionId'] ) );
	    }
	    return $returnArray;
	}
	
	//public function 
	
	private function getAdditionTagByProductDescriptionId ( $pdid ) {
	    $STH = $this->db->prepare( "SELECT * FROM AdditionProductDescriptionTags AT JOIN Tags T ON T.Tagid = AT.TagId WHERE ProductDescriptionId = :pdid" );
	    $STH->bindParam(':pdid', $pdid );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	public function getTagsByProductDescriptionId( $pdid ) {
	    $STH = $this->db->prepare( "SELECT TG.Key
		FROM ( SELECT * FROM AdditionProductDescriptionTags UNION SELECT * FROM ProductDescriptionTags ) TK
		JOIN Tags TG
		ON TG.TagId = TK.TagId
		WHERE TK.ProductDescriptionId = :pdid" );
	    $STH->bindParam(':pdid', $pdid );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	private function findProductDescriptionByTagIds( $tagArray ) {
	    $tagCount = count( $tagArray );
	    $orQuery = "";
	    foreach ( $tagArray as &$value ) {
		$orQuery .= " PDT.TagId = $value OR";
	    }
	    $orQuery = substr($orQuery, 0, -2);
	    /*
	     SELECT PDT.ProductDescriptionId, Count( PDT.TagId ) as TC FROM
			( SELECT * FROM AdditionProductDescriptionTags UNION SELECT * FROM ProductDescriptionTags ) PDT
			WHERE PDT.TagId = 105 OR PDT.TagId = 106 "
			GROUP BY PDT.ProductDescriptionId
			HAVING TC = $tagCount
	     **/
	    $query = "SELECT PDT.ProductDescriptionId, Count( PDT.TagId ) as TC FROM
			( SELECT * FROM AdditionProductDescriptionTags UNION SELECT * FROM ProductDescriptionTags ) PDT
			WHERE$orQuery
			GROUP BY PDT.ProductDescriptionId
			HAVING TC = $tagCount";
	    $STH = $this->db->prepare( $query );
	    $STH->execute();
	    return $STH->fetchAll();
	}
	
	private function findProductDescriptionByTagIdsWithLimit( $tagArray , $limit, $pages) {
	    $pages -= 1;
	    $tagCount = count( $tagArray );
	    $orQuery = "";
	    foreach ( $tagArray as &$value ) {
		$orQuery .= " PDT.TagId = $value OR";
	    }
	    $orQuery = substr($orQuery, 0, -2);
	    $query = "SELECT PDT.ProductDescriptionId, Count( PDT.TagId ) as TC FROM
			( SELECT * FROM AdditionProductDescriptionTags UNION SELECT * FROM ProductDescriptionTags ) PDT
			WHERE$orQuery
			GROUP BY PDT.ProductDescriptionId
			HAVING TC = $tagCount LIMIT $limit OFFSET $pages";
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
	    $this->removeItemByTable( 'ProductDescriptionTags', 'ProductDescriptionId' , $productId );
	    $this->removeItemByTable( 'AdditionProductDescriptionTags', 'ProductDescriptionId' , $productId );
	}
	
	public function removeItemByTable( $table, $att ,$primaryId ) {
	    $STH = $this->db->prepare("delete from `$table` where `$att` = :id");
	    $STH->bindParam(':id', $primaryId);
	    $STH->execute();
	}
	
    }
    require_once 'ProductDescription.php';
    require_once 'DataInfo.php';
    require_once 'Brand.php';
    require_once 'Category.php';
    require_once 'InventoryDao.php';
    //print_r( ProductDao::GetInstance()->getActiveProductsWithLimit( 1, 1 ));
?>