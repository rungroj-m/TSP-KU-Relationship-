<?php
require_once('DataInfo.php');
require_once('ProductDao.php');
    
    class Category extends DataInfo {
    	
		public static function CreateCategory( $catName ) {
		    $dao = ProductDao::GetInstance();
		    $cid = $dao->addCategory( $catName );
		    return Category::withIdAndValue( $cid, $catName );
		}
		
		public static function GetCategory( $catId ) {
		    $name = ProductDao::GetInstance()->getCategoryById( $catId );
		    return Category::withIdAndValue( $catId, $name );
		}
	
    }

?>