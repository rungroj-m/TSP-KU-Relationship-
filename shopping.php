<form>
<input name="searchbox" type="search" placeholder="input please"><br>
</form>

<div id="productBoxContainer" style="background-color: aqua;">

<?php

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	
	$productdescs = ProductDescription::GetProductDescriptionsByCategoryId(3);
	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBox($product);
	}

	function createProductBox($product) {
		echo "
		<div style=\"width: 200px; height: 250px; background-color: green; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">
		<div id=\"pic\" style=\"width: 180px; height: 180px; background-color: red\">
		pic
		</div>
		
		<div id=\"name\">
		{$product->productDescription->productName}
		</div>
		
		<div id=\"price\">
		$product->price
		</div>
		
		<button type=\"button\" onclick=\"addThisToCart($product->id,$product->price);\">ADD</button>
		</div>
				
		";
	}	
?>
</div>

<script language="JavaScript">
// var cartList = [];

var cartID = [];
var cartPrice = [];

function addThisToCart(id,price) {
	cartID.push(id);
	cartPrice.push(price);

	alert(cartID +" "+ cartPrice ) ;
// 	cartList.push({id: id, 'price': price});
// 	alert (cartList[0]);
// 	cartList.add(product);
	var divtest = document.createElement("div");        
// 	divtest.innerHTML = "<div id=\"" + id + "\"><a onclick=\"remove(" + id + ")\">rm</a>" + id + " " + price + "</div>";   
	divtest.innerHTML = "<div>" + id + " " + price + "</div>";   
	document.getElementById("cart").appendChild(divtest);

	document.getElementById("sum").innerHTML = "Price : " + getAllPrice();
		
	
}

function remove(id) {
	for(var i = 0 ; i<cartID.length;i++){
		if(cartID[i] == id){
			cartID.remove[i];
			cartPrice.remove[i];

// 			document.getElementById("\"" + id + "\"").removeNode(true);
// 			alert("ss");
// 			document.getElementById("sum").innerHTML = "Price : " + getAllPrice();
			return ;
		}
	}
}

function getAllPrice() {
	var sum = 0;
	for(var i = 0 ; i < cartID.length ; i++ ){
		sum += cartPrice[i];
	}
	return sum;
}
</script>


<div id="cart" style="background-color: pink">
	
</div>

<div id="sum"></div>






