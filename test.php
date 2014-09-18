<?php
	require_once("db.php");
	connectdb();
	$name = $_POST['name'];
	$code = $_POST['code'];
	$tag = $_POST['tag'];
	$quan = $_POST['quan'];
	$band = $_POST['band'];
	
	echo mysql_query("insert into product value($name,$code,$tag,$quan,$band)") ."<what>";
?>	