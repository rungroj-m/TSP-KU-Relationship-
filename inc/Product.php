
<?php
	
	class Product {
	
		
	public $id;
	public $productDescription;
	public $price;
	public $createDate;
	public $status;
	
	public function __construct(){
	}
	
	public static function CreateProduct( $productDescription, $price ) {
	    $dao = ProductDao::GetInstance();
	    $now = new DateTime( 'now' );
	    $pid = $dao->addProduct( $productDescription->id, $price, $now->format('Y-m-d H:i:s'), true );
	    
	    $instance = new self();
	    $instance->id = $pid;
	    $instance->productDescription = $productDescription;
	    $instance->price = $price;
	    $instance->status = true;
	    $instance->createDate = $now;
	    return $instance;
	}
	
	public static function GetProduct( $pid ){
	    $dao = ProductDao::GetInstance();
	    $data = $dao->getProductById( $pid );
	    return Product::NewProductByData( $data );
	}
	
	private static function NewProductByData( $data ) {
		$instance = new self();
	    $instance->id = $data['ProductId'];
	    $instance->price = $data['Price'];
	    $instance->productDescription = ProductDescription::GetProductDescription( $data['ProductDescriptionId'] );
	    $instance->status = $data['Status'];
	    $instance->createDate = new DateTime( $data['CreateDate'] );
	    return $instance;
	}
	
	public static function GetAllProduct() {
		$array = array();
		$dao = ProductDao::GetInstance();
		$data = $dao->getActiveProducts();
		foreach ( $data as &$value ) {
			array_push( $array, Product::NewProductByData( $value ) );
		}
		
		return $array;
	}
	
	public static function GetEnabledProductByProductDescriptionId ( $pid ) {
		$dao = ProductDao::GetInstance();
		$data = $dao->getEnabledProductByProductDescriptionId( $pid );
		return Product::GetProduct( $data );
	}
	
    }

?>