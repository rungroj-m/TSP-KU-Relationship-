<html>
<body>
Add Product 
<form action = "index.php" method = "GET">
<input name="searchbox" type="text" placeholder="input please"><br>
<input name="search" type="submit" value="search"><br>
<a href="add.html">Add</a>

<?php
	if (isset($_GET['searchbox'])) {
		include ("db.php");
		connectdb();
		$search = $_GET['searchbox'];
			echo mysql_query("select * from product where name = $search");
	}
?>
</form>
</body>
</head>