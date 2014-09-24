<html>
<body>
<?php
	include ("db.php");
	connectdb();
	
	if (isset($_GET['edit'])) {
		$query = "SELECT * FROM product WHERE id={$_GET['edit']}";
		$result = mysql_fetch_array(mysql_query($query));
	}
	
	
?>

Add Product 
<form action = "test.php" method = "POST">
<?php if (isset($_GET['edit'])) echo "<input type=\"hidden\" name=\"id\" value=\"{$result['id']}\">" ?>
name:	<input name="name" type="text" value="<?php if (isset($_GET['edit'])) echo $result['name']; ?>"><br>
-code:	<input name="code" type="text" value="<?php if (isset($_GET['edit'])) echo $result['code']; ?>"><br>
-price: <input name="price" type="number" value="<?php if (isset($_GET['edit'])) echo $result['price']; ?>"><br>
-description:	<input name="desc" type="text" value="<?php if (isset($_GET['edit'])) echo $result['description']; ?>"><br>
-category   <input name="category" type="text" value="<?php if (isset($_GET['edit'])) echo $result['category']; ?>"><br>
-tag:	<input name="tag" type="text" value="<?php if (isset($_GET['edit'])) echo $result['tag']; ?>"><br>
-quantity:	<input name="quan" type="text" value="<?php if (isset($_GET['edit'])) echo $result['quantity']; ?>"><br>
-band:	<input name="band" type="text" value="<?php if (isset($_GET['edit'])) echo $result['band']; ?>"><br>
<input name ="submit" type="submit" value="<?php echo (isset($_GET['edit']) ? "Save" : "Add"); ?>">
<input name ="reset" type="reset" value="Clear">
<?php if (isset($_GET['edit'])) echo "<input type=\"submit\" name=\"action\" value=\"Delete\" />"; ?>
</form>
    

</body>
</head>