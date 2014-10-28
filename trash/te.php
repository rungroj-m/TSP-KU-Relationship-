
<form name="input" action="te.php" method="POST">
AGE: <input type="text" name="age">
<input type="submit" value="Submit">
</form>
<?php

if (isset($_POST["age"])) {
	if ($_POST["age"] == 1) {
		echo "one";
	}
	else if ($_POST["age"] == 10) {
		echo "ten";
	}
	else {
		echo $_POST["age"];
	}
}