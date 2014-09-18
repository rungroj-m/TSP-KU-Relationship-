<?php

function connectdb(){
	
$host="localhost";
$user = "root";
$password="root";
$database="productTest";

	mysql_connect($host,$user,$password);
	mysql_select_db($database) or die("fail to connectdb");
}
?>