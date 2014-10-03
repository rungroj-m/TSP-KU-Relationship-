<html>
<body>
    
    <div style="b">
        header    
    </div>
Add Product 
<form action = "index.php" method = "GET">
<input name="searchbox" type="text" placeholder="input please"><br>
<input name="search" type="submit" value="search"><br>
<a href="add.php">Add</a><br><br>

<?php
        include ("db.php");
		connectdb();

	if (isset($_GET['searchbox'])) {
        
		$search = $_GET['searchbox'];
        
        $result = mysql_query("select * from product where name like '%$search%'");
         while($row = mysql_fetch_array($result)) {
            $id = $row['id'];
            $name = $row['name'];
            
             echo "<a href=\"add.php?edit=$id\">$name</a><br>";
        }
    }
	else {
	$result = mysql_query("select * from product");
        while($row = mysql_fetch_array($result)) {
            $id = $row['id'];
            $name = $row['name'];
            
             echo "<a href=\"add.php?edit=$id\">$name</a><br>";
        }
	}
?>
</form>
</body>
</head>