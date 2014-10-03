<?php
echo 'benz';
require_once('DataInfo.php');
    
    echo 'benz';
    
    class Category extends DataInfo {
    	
		public static function CreateCategory( $catName ) {
			echo "fuck". $cid;
		    $dao = ProductDao::GetInstance();
		    $cid = $dao->addCategory( $catName );
		    echo "fuck". $cid;
		    return Category::withIdAndValue( $cid, $catName );
		}
		
		public static function GetCategory( $catId ) {
		    $name = ProductDao::GetInstance()->getCategoryById( $catId );
		    return Category::withIdAndValue( $catId, $name );
		}
	
    }

?>