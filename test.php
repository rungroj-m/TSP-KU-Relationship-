<?php
	require_once("db.php");
	connectdb();
	$name = $_POST['name'];
	$code = $_POST['code'];
	$tag = $_POST['tag'];
	$quan = $_POST['quan'];
	$band = $_POST['band'];

	if (mysql_query("insert into product value(\"$name\",\"$code\",\"$tag\",\"$quan\",\"$band\")")) {
         header('location: /tsp/index.php');
    }
    else {
        echo "what did you do?, i wont obey you!";
    }
?>	