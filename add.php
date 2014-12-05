<head>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="css/summernote.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/summernote.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>

<?php
require_once ('inc/Product.php');
require_once ('inc/ProductDao.php');
require_once ('inc/ProductDescription.php');
require_once ('inc/Category.php');
require_once ('inc/Brand.php');
require_once ('inc/Inventory.php');
require_once ('inc/InventoryDao.php');
	if (isset($_GET["id"])) {
		$result = Product::GetProduct($_GET["id"]);
	}
	
	
?>

<?php

	$product_str;
	
	if (isset($_GET["id"])) {
		$product = Product::GetProduct($_GET["id"]);
		
		$productdescs = $product->productDescription;
		
		
		global $product_str;
		
		$quan = Inventory::getQuntity($product->id);
		$tag_str = implode(", ", $productdescs->additionTags);
		
		$product_str = "
				$(\"#name\").val(\"{$productdescs->productName}\");
				$(\"#code\").val(\"{$productdescs->modelCode}\");
				$(\"#price\").val(\"{$product->price}\");
				$(\"#weight\").val(\"{$productdescs->weight}\");
				$(\"#desc\").code(replaceDoubleQuote('{$productdescs->description}'));
				$(\"#image\").val(\"{$productdescs->images[0]}\");
				$(\"#category\").val(\"{$productdescs->category->value}\");
				$(\"#tag\").val(\"$tag_str\");
				$(\"#quan\").val(\"$quan\");
				$(\"#brand\").val(\"{$productdescs->brand->value}\");
		";
	}
?>

<div style="width: 90%; height: 90%; border-radius: 6px;">

Name:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="name" placeholder="Title">
</div>

Code:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="code" placeholder="Text">
</div>

Price:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
	<input type="number" class="form-control" id="price" placeholder="Number" min="0">
</div>

Weight:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-save"></span></span>
	<input type="number" class="form-control" id="weight" placeholder="Number" min="0">
	<span class="input-group-addon">Grams</span>
</div>

Description:
<div id="desc"></div>

Image URL:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="image" placeholder="URL">
</div>

Category:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
	<input type="text" class="form-control" id="category" value="Others" placeholder="" disabled>
	<div class="btn-group btn-group-sm" style="width: 100%">
			<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
				Category <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="category-dropdown" role="menu" style="width: 100%">
				<li><a>Clothes</a></li>
			    <li><a>Equipments</a></li>
			    <li><a>Balls</a></li>
			    <li><a>Others</a></li>
			</ul>
		</div> 
</div>

Tag:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
	<input type="text" class="form-control" id="tag" placeholder="Separated with comma ,">
</div>

Quantity:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span></span>
	<input type="number" class="form-control" id="quan" placeholder="Integer" min="0">
</div>

Brand:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="brand" placeholder="Text">
</div>

<table class="table">
	<tr>
		<?php
			if (isset($_GET["id"])) {
				echo "<th><button type=\"button\" class=\"btn btn-info\" id=\"button-save\" val=\"{$_GET["id"]}\"style=\"width: 100%\">Save</button></th>";
			}
			else {
				echo "<th><button type=\"button\" class=\"btn btn-success\" id=\"button-add\" style=\"width: 100%\">Add</button></th>";
			}
		?>
		<th><button type="button" class="btn btn-danger" id="button-clear" style="width: 100%">Clear</button></th>
	</tr>
</table>

<script type="text/javascript">
	$("#category-dropdown li").click(function() {
		$("#category").val($(this).text());
	});

	$("#button-add").click(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {"submit":"add",
				"name": $("#name").val(),
				"code": $("#code").val(),
				"price": $("#price").val(),
				"weight": $("#weight").val(),
				"desc": $("#desc").code(),
				"image": $("#image").val(),
				"category": $("#category").val(),
				"tag": $("#tag").val(),
				"quan": $("#quan").val(),
				"brand": $("#brand").val()}
		}).done(function(response) {
			alert(response);
			window.parent.closeModal();
		});
	});

	$("#button-clear").click(function() {
		$("#name").val(""); 
		$("#code").val("") ;
		$("#price").val("") ;
		$("#weight").val(""),
		$("#desc").code("") ;
		$("#image").val(""),
		$("#category").val("") ;
		$("#tag").val("") ;
		$("#quan").val("") ;
		$("#brand").val("") ;		
	});

	$("#button-save").click(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {"submit":"edit",
				"id": $("#button-save").attr("val"),
				"name": $("#name").val(),
				"code": $("#code").val(),
				"price": $("#price").val(),
				"weight": $("#weight").val(),
				"desc": $("#desc").code(),
				"image": $("#image").val(),
				"category": $("#category").val(),
				"tag": $("#tag").val(),
				"quan": $("#quan").val(),
				"brand": $("#brand").val()}
		}).done(function(response) {
			alert(response);
			window.parent.closeModal();
		});
	});

	$(document).ready(function() {
		$("#desc").summernote({
			  height: 300,
			  minHeight: 300,
			  maxHeight: 300,
			  oninit: function() {
				<?php global $product_str; echo $product_str; ?>
			  }
		});
	});

	function replaceDoubleQuote(str) {
		return str.replace('"', '\\"');
	}

	$("input[type=number]").on("mousewheel", function(e) {
	    $(this).blur(); 
	});

	
</script>