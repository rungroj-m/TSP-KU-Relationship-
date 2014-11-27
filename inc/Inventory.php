<?php
    class Inventory {
    	
	public static function addProduct( $product, $amount ){
	    InventoryDao::GetInstance()->addInventory( $product->id, $amount );
	    return $amount;
	}
	
	public static function releaseProduct( $product, $amount ){
	    InventoryDao::GetInstance()->releaseInventory( $product->id, $amount );
	    return $amount;
	}
	
	public static function getQuntity( $pid ){
	    return InventoryDao::GetInstance()->getStockInventory( $pid );
	}
	
	
	
    }
    
?>