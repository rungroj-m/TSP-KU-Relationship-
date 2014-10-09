<?php
    class ProductDescription {
	
	public $id;
	public $brand;
	public $category;
	public $description;
	public $modelCode;
	public $productName;
	public $createDate;
	public $additionTags;
	
	public function __construct(){
	}
	
	public static function CreateProductDescription( $category, $brand, $description, $modelCode, $additionTags, $productName ) {
	    $dao = ProductDao::GetInstance();
	    $now = new DateTime( 'now' );
	    $pdid = $dao->addProductDescription( $category->id, $brand->id, $productName, $modelCode, $description , $additionTags, $now->format('Y-m-d H:i:s') );
	    
	    $instance = new self();
	    $instance->id = $pdid;
	    $instance->brand = $brand;
	    $instance->category = $category;
	    $instance->description = $description;
	    $instance->modelCode = $modelCode;
	    $instance->productName = $productName;
	    $instance->createDate = $now;
	    $instance->additionTags = $additionTags;
	    return $instance;
	}
	
	public static function GetProductDescription( $pdid ) {
	    $dao = ProductDao::GetInstance();
	    $data = $dao->getProductDescriptionById( $pdid );
	    
	    $instance = new self();
	    $instance->id = $data['ProductDescriptionId'];
	    $instance->category = Category::GetCategory( $data['CategoryId'] );
	    $instance->brand = Brand::GetBrand( $data['BrandId'] );
	    $instance->productName = $data['ProductName'];
	    $instance->modelCode = $data['ModelCode'];
	    $instance->description = $data['Description'];
	    $instance->createDate = new DateTime( $data['CreateDate'] );
	    return $instance;
	}
	
	public static function GetProductDescriptionsByCategoryId ( $categoryId ) {
	    $array = array();
	    $dao = ProductDao::GetInstance();
	    $data = $dao->getProductDescriptionIdByCategoryId( $categoryId );
	    foreach ( $data as &$value ) {
		array_push( $array, ProductDescription::GetProductDescription( $value[0] ) );
	    }
	    return $array;
	}
    }

?>