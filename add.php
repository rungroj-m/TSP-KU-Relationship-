<head>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>

<?php
require_once ('inc/Product.php');
require_once ('inc/ProductDao.php');
	if (isset($_GET['edit'])) {
		$result = Product::GetProduct($_GET['edit']);
	}
	
	
?>
<div style="width: 90%; height: 90%; border-radius: 6px; background-color: #eee;">

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
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="number" class="form-control" id="price" placeholder="Number">
</div>

Description:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="desc" placeholder="Description (should change to textarea)">
</div>

Category:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="category" placeholder="(Select below or input for a new category)">
	<div class="btn-group btn-group-sm" style="width: 100%">
			<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
				Category <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="category-dropdown"style="background-color: black" role="menu">
				<li><a style = "color: white">Shirt</a></li>
			    <li><a style = "color: white">Equipment</a></li>
			    <li><a style = "color: white">Balls</a></li>
			    <li><a style = "color: white">Forbidden stuffs</a></li>
			</ul>
		</div> 
</div>

Tag:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="tag" placeholder="Separated with comma ,">
</div>

Price:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="number" class="form-control" id="quan" placeholder="Integer">
</div>

Brand:
<div class="input-group">
	<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
	<input type="text" class="form-control" id="brand" placeholder="Text">
</div>

<table class="table">
	<tr>
		<th><button type="button" class="btn btn-success" id="button-add" style="width: 100%">Add</button></th>
		<th><button type="button" class="btn btn-danger" id="button-clear" style="width: 100%">Clear</button></th>
	</tr>
</table>

<script type="text/javascript">
	$("#category-dropdown li").click(function() {
		$("#category").val($(this).text());
	});

	$("#button-add").click(function() {
		var data = {
			    "submit": "add",
			    "name": $("#name").val(),
			    "code": $("#code").val(),
			    "price": $("#price").val(),
			    "desc": $("#desc").val(),
			    "category": $("#category").val(),
			    "tag": $("#tag").val(),
			    "quan": $("#quan").val(),
			    "brand": $("#brand").val(),
			};
		console.log(JSON.stringify(data));
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: JSON.stringify(data)
		}).done(function(response) {
			alert(response);
			console.log(response);
			window.parent.closeModal();
		});
	});

	
</script>

<form action = "add.php" method = "POST">
<?php if (isset($_GET['edit'])) echo "<input type=\"hidden\" name=\"id\" value=\"{$result->id}\">" ?>
name:	<input name="name" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->productName}"; ?>"><br>
-code:	<input name="code" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->modelCode}"; ?>"><br>
-price: <input name="price" type="number" value="<?php if (isset($_GET['edit'])) echo "{$result->price}"; ?>"><br>
-description:	<input name="desc" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->description}"; ?>"><br>
<!-- category,brand need get and tag / quantity doesn't have attribute. -->
-category   <input name="category" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->category->value}"; ?>"><br>
-tag:	<input name="tag" type="text" value="<?php if (isset($_GET['edit'])) echo "something like tag"; ?>"><br>
-quantity:	<input name="quan" type="text" value="<?php if (isset($_GET['edit'])) echo "something like quantity"; ?>"><br>
-brand:	<input name="brand" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->brand->value}"; ?>"><br>
<input name ="submit" type="submit" value="<?php echo (isset($_GET['edit']) ? "Save" : "Add"); ?>">
<!-- Cannot clear in edit mode -->
<input name ="reset" type="reset" value="Clear">
<?php if (isset($_GET['edit'])) echo "<input type=\"submit\" name=\"action\" value=\"Delete\" />"; ?>
</form>

</div>
	
	

    


<?php 


// 	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	if (isset($_POST['submit'])) {
		$brand = Brand::CreateBrand($_POST['brand']);
		$category = Category::CreateCategory($_POST['category']);
		$productDesc = ProductDescription::CreateProductDescription($category, $brand, $_POST['desc'], $_POST['code'], explode(',', $_POST['tag']), $_POST['name']);
		Product::CreateProduct($productDesc, $_POST['price']);
		
		echo ("Product Added");
	}
	
	if (isset($_POST['action']))
			echo "kuy benz delete gu la";
		//NEED fucking delete method u dick
?>
