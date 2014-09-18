<?php

function connectdb(){
	
$host="localhost";
$user = "root";
$password="";
$database="productTest";

	mysql_connect($host,$user,$password);
	mysql_select_db($database) or die("fail to connectdb");
}
?>