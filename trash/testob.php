<?php
function connectdb(){

	$host="localhost";
	$user = "root";
	$password="root";
	$database="testob";

	mysql_connect($host,$user,$password);
	mysql_select_db($database) or die("fail to connectdb");
}


echo "1";
class std {
	private $id;
	private $firstname, $lastname;
	
	public function __construct($id = 0, $first = "fn", $last = "ln") {
		$this->id = $id;
		$this->firstname = $first;
		$this->lastname = $last;
	}
	
	public function get() {
		return "$this->id -> $this->firstname : $this->lastname";
	}
}
echo "2";

connectdb();

$a = new std();
$b = new std(19, "first", "last");

echo $a->get() ."<br>";
echo $b->get() ."<br>";

$a1 = serialize($a);
$b1 = serialize($b);
echo $query = "INSERT INTO test (ob) VALUE ('$a1'), ('$b1')";
echo mysql_query($query);

echo $query = "SELECT * from ob";
$result = mysql_query($query);
echo $a2 = unserialize(mysql_fetch_object($result));
echo $b2 = unserialize(mysql_fetch_object($result));
echo $a2->get() ."<br>";
echo $b2->get() ."<br>";
