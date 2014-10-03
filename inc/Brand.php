<?php
    class Brand extends DataInfo {
	
	public static function CreateBrand( $brandName ) {
	    $bid = ProductDao::GetInstance()->addBrand( $brandName );
	    return Brand::withIdAndValue( $bid, $brandName );
	}
	
	public static function GetBrand( $brandId ) {
	    $name = ProductDao::GetInstance()->getBrandById( $brandId );
	    return Brand::withIdAndValue( $brandId, $name );
	}
	
    }

?>