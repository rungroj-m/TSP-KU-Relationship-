<?php
	require_once("db.php");
	connectdb();
	
	if ($_POST['submit'] == "Add") {
		$name = $_POST['name'];
		$code = $_POST['code'];
	    $price = $_POST['price'];
	    $description = $_POST['description'];
	    $category = $_POST['category'];
		$tag = $_POST['tag'];
		$quan = $_POST['quan'];
		$band = $_POST['band'];
	
		if (mysql_query("insert into product(name, code, price, description, category, tag, quantity, band) value(\"$name\",\"$code\", $price, \"$description\", \"$category\" ,\"$tag\", $quan,\"$band\")")) {
			header('location: /tsp/index.php');
	    }
	    else {
	        echo ("insert into product(name, code, price, description, category, tag, quantity, band) value(\"$name\",\"$code\", $price, \"$description\", \"$category\" ,\"$tag\", $quan,\"$band\")") ."<br>";
	        echo "what did you do?, i wont obey you!";
	    }
	}
	else if ($_POST['submit'] == "Save") {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$code = $_POST['code'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$category = $_POST['category'];
		$tag = $_POST['tag'];
		$quan = $_POST['quan'];
		$band = $_POST['band'];
		echo $id;
	if (mysql_query("insert into product(name, code, price, description, category, tag, quantity, band) value(\"$name\",\"$code\", $price, \"$description\", \"$category\" ,\"$tag\", $quan,\"$band\")")) {
			header('location: /tsp/index.php');
	    }
	}
	else if ($_POST['action'] == "Delete") {
		$id = $_POST['id'];
		echo "delete from product where id=$id";
		mysql_query("delete from product where id=$id");
		header('location: /tsp/index.php');
	}
?>	