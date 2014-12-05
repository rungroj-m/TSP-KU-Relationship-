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
	public $images;
	public $weight ;
	
	public function __construct(){
	}
	
	public static function CreateProductDescription( $category, $brand, $description, $modelCode, $additionTags, $productName, $weight ) {
	    $dao = ProductDao::GetInstance();
	    $now = new DateTime( 'now' );
	    $pdid = $dao->addProductDescription( $category->id, $brand->id, $productName, $modelCode, $description , $additionTags, $now->format('Y-m-d H:i:s'), $weight );	    
	    $instance = new self();
	    $instance->id = $pdid;
	    $instance->brand = $brand;
	    $instance->category = $category;
	    $instance->description = $description;
	    $instance->modelCode = $modelCode;
	    $instance->productName = $productName;
	    $instance->createDate = $now;
	    $instance->additionTags = $additionTags;
	    $instance->weight = $weight;
	    return $instance;
	}
	
	public function addImages( $imageAddressArray ) {
	    $dao = ProductDao::GetInstance();
	    $dao->addProductDescriptionImages( $this->id, $imageAddressArray );
	}
	
	public function updateData() {
	    $dao = ProductDao::GetInstance();
	    //echo ("x" .$this->productName);
	    $dao->editProductDescription( $this->id, $this->category->id, $this->brand->id, $this->productName, $this->modelCode, $this->description , $this->additionTags, $this->weight );
	    //echo ("y" .$this->productName);
	}
	
	public function getTags() {
	    $result = array();
	    $data = ProductDao::GetInstance()->getTagsByProductDescriptionId( $this->id );
	    foreach( $data as &$val ) {
		array_push( $result, $val['Key'] );
	    }
	    return $result;
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
	    $instance->additionTags = $data['AdditionalTags'];
	    $instance->weight = $data['Weight'];
	    
	    $data = $dao->getImagesByProductDescriptionId( $pdid );
	    $instance->images = array();
	    foreach ( $data as &$value ) {
		array_push( $instance->images, $value['ImageAddress'] );
	    }
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
	
	public static function SearchByTags ( $stringArray ) {
	    $dao = ProductDao::GetInstance();
	    return $dao->findProductDescriptionByTags( $stringArray );
	}
	
	public static function SearchByTagsWithLimit ( $stringArray, $limit, $pages ) {
	    $dao = ProductDao::GetInstance();
	    return $dao->findProductDescriptionByTagsWithLimit( $stringArray, $limit, $pages);
	}
	
	public static function SearchByTagsCount ( $stringArray ) {
		$dao = ProductDao::GetInstance();
		return count(ProductDescription::SearchByTags($stringArray));
	}
    }
    
    /*require_once( 'ProductDao.php' );
    require_once( 'Product.php' );
    require_once( 'Category.php' );
    require_once( 'Brand.php' );
    $p = Product::GetProduct( 21 );
    print_r( $p );
    $p->disable();*/
    
?>

