<br>

<div class="row">
	<div class="col-md-2">
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

	<div class="col-md-10">
		<div class="input-group input-group-sm">
			<input type="text" class="form-control" id="search-box">
			<span class="input-group-btn">
				<button id="search-button" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"/></button>
			</span>
		</div>
	</div>	    
</div>

<br>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Shopping</h3>
			</div>
			<div class="panel-body">
				<div id="productBoxContainer">
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Cart</h3>
			</div>
			<div class="panel-body">
				<table class="table" id="cart">
					<tr>
						<th>Product</th>
						<th>Q.</th>
						<th>UP.</th>
					</tr>
				</table>
				
				<table class="table">
					<tr>
						<th>Total</th>
						<th>&#3647;</th>
					</tr>
				</table>
				
				<table class="table">
					<tr>
					
						<th><button type="button" class="btn btn-success">Check Out</button></th>
						<th><button type="button" class="btn btn-danger">Clear</button></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: { "get_product_by_category_for_shopping": "3" }
	}).done(function(response) {
	    $("#productBoxContainer").html(response);
	});

	function addToCart($productName, $price) {
		alert($productName + $price);
	}

	$("#category-dropdown li").click(function() {
		alert($(this).text());
	});

	$("#search-box").keypress(function(event) {
		// 13 means ENTER
		if (event.which == 13) {
			alert($("#search-box").val());
		}
	});
	
	$("#search-button").click(function() {
		alert($("#search-box").val());
	});

	
</script>




