<?php
    class DataInfo {
	
	public $id;
	public $value;
	
	public function __construct(){
	}
	
	protected static function withIdAndValue ( $id, $value ) {
	    $instance = new self();
	    $instance->id = $id;
	    $instance->value = $value;
	    return $instance;
	}
	
    }

?>