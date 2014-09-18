<html>
<body>
Add Product 
<form action = "index.php" method = "GET">
<input name="searchbox" type="text" placeholder="input please"><br>
<input name="search" type="submit" value="search"><br>
<a href="add.html">Add</a><br><br>

<?php
        include ("db.php");
		connectdb();

    if (isset($_GET['del'])) {
        $name = $_GET['del'];
        mysql_query("delete from product where name=\"$name\"");
        
    }
	if (isset($_GET['searchbox'])) {
        
		$search = $_GET['searchbox'];
        
        $result = mysql_query("select * from product where name like '%$search%'");
         while($row = mysql_fetch_array($result)) {
            $name = $row['name'];
            $tag = $row['tag'];
            
             echo "<a href=\"index.php?del=$name\">$name</a> $tag<br>";
        }
    }

$result = mysql_query("select * from product");
        while($row = mysql_fetch_array($result)) {
            $name = $row['name'];
            $tag = $row['tag'];
            
             echo "<a href=\"index.php?del=$name\">$name</a> $tag<br>";
        }
?>
</form>
</body>
</head>