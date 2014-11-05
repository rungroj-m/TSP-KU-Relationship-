<br>

<div class="row">
	<div class="col-md-2">
		<div class="btn-group btn-group-sm" style="width: 100%">
			<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
				<qq>Category</qq> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="category-dropdown"style="background-color: black" role="menu">
				<li><a style = "color: white">All</a></li>
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
				<h3 class="panel-title">Product Information</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="thumbnail">
							<img id="image" style="width: 100%; background-color: white; border-radius: 3px;" src="">
						</div>
					</div>
					<div class="col-md-6">
						<h3>Name: <span id="name"></span></h3>
						<h4>Brand: <span id="brand"></span></h4>
						<h6>Model Code: <span id="code"></span></h6>
						<br>
						<h5>Category: <span id="category"></span></h5>
						<br>
						<h5>Stock: <span id="quantity"></span></h5>
						<h5>Price: <span id="price"></span></h5>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group" style="width: 100%">
								<button type="button" class="btn btn-primary" style="width: 100%" onclick="addToWish(<?php echo $_GET["id"]; ?>);">
									<span class="glyphicon glyphicon-heart"></span>Add to Wish
								</button>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="input-group">
									<input type="number" class="form-control" id="quan" value="1">
									<span class="input-group-btn">
										<button type="button" class="btn btn-success" onclick="addToCart(0);">ADD</button>
									</span>
								</div>
							</div>
						
						
						</div>
						
					</div>
				</div>
				<h5>Tag: <span class="label label-warning" id="tag">Warning</span></h5>
				<p id="description"></p>
				<br>
				<div class="jumbotron">
					Comment & Like & Share
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
				<table class="table">
					<tbody id="cart">
						<tr>
							<th>Product</th>
							<th>Q.</th>
							<th>U.P.</th>
							<th></th>
						</tr>
					</tbody>
				</table>
				
				<table class="table">
					<tr>
						<th>Total</th>
						<th id="total">&#3647;0</th>
					</tr>
				</table>
				
				<table class="table">
					<tr>
						<th><button type="button" class="btn btn-success" id="button-checkout" >Check Out</button></th>
						<th><button type="button" class="btn btn-danger" id="button-clear-cart" >Clear</button></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Confirm Clar Cart -->
<div class="modal fade" id="clear-cart-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Clear Cart</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure to clear cart item(s)?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="button-confirm-clear-cart">Clear</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var product;
	function aj() {
	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: { "get_product_detail_by_id": <?php echo $_GET["id"]; ?> }
	}).done(function(response) {
		product = $.parseJSON(response);		
	    $("#name").html(product.name);
	    $("#code").html(product.code);
	    $("#price").html(product.price);
	    $("#description").html(product.description);
	    $("#image").attr("src", product.image);
	    $("#category").html(product.category);
	    
	    $("#tag").html(product.tag);
	    $("#quantity").html(product.quantity);
	    $("#brand").html(product.brand);
	});
	}

	function addToCart(quantity) {
		if (quantity == 0)
			quantity = Number($("#quan").val());
		var productId = product.id;
		var productName = product.name;
		var price = product.price;
		
		if ($.cookie("cartItems") == undefined) {
			var arr = [{id: productId, name: productName, quantity: quantity, unitprice: price}];
			
			$.cookie("cartItems", JSON.stringify(arr), { expires: 15 }); // in 15 days
		}
		else {
			block: {
				var arr = $.parseJSON($.cookie('cartItems'));
				for (var i = 0; i < arr.length; i++) {
					if (arr[i].id == productId) {
						arr[i].quantity += quantity;
						if (arr[i].quantity == 0) {
							arr.splice(i, 1);
						}
						break block;
					}
				}
				arr.push({id: productId, name: productName, quantity: quantity, unitprice: price});
			}
		
			$.cookie("cartItems", JSON.stringify(arr), { expires: 15 }); // in 15 days
		}
		
		var arr = $.parseJSON($.cookie('cartItems'));
		
		$("#cart").empty();
		$("#cart").append("\
			<tr>\
				<th>Product</th>\
				<th>Q.</th>\
				<th>U.P.</th>\
				<th></th>\
			</tr>\
		");
		var total = 0;
		for (var i = 0; i < arr.length; i++) {
			$("#cart").append(
					"<tr>" +
						"<th>" + arr[i].name.substring(0, 12) + "</th>" +
						"<th>" + arr[i].quantity + "</th>" +
						"<th>" + arr[i].unitprice + "</th>" +
						"<th>" +
							"<span class=\"label alert-danger\" onclick=\"addToCart(-1)\");\">-</span>" +
							"<span class=\"label alert-success\" onclick=\"addToCart(1)\");\">+</span>" +
						"</th>" +
					"</tr>"
			);
			total += arr[i].quantity * arr[i].unitprice;
		}
		$("#total").text("\u0E3F" + total);
	}

	$("#category-dropdown li").click(function() {
		if ($(this).text() == "all" || $(this).text() == "category") {
// 			pass ""
		}
		else {
// 			pass real value
		}
		
		alert($(this).text());
		$("#dropdown qq").text($(this).text());
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

	$("#button-clear-cart").click(function() {
	    $("#clear-cart-confirm").modal({
		    show: true
		});
		$("#button-confirm-clear-cart").focus();
	});

	$("#button-confirm-clear-cart").click(function() {
		$.removeCookie("cartItems");
		
		$("#cart").empty();
		$("#cart").append("\
			<tr>\
				<th>Product</th>\
				<th>Q.</th>\
				<th>U.P.</th>\
			</tr>\
		");

		$("#total").text("\u0E3F0");
		
		$("#clear-cart-confirm").modal('hide');
	});

	$(document).ready(function() {
		if ($.cookie("cartItems") != undefined) {
			var arr = $.parseJSON($.cookie('cartItems'));
			var total = 0;
			for (var i = 0; i < arr.length; i++) {
				$("#cart").append(
					"<tr>" +
						"<th>" + arr[i].name.substring(0, 12) + "</th>" +
						"<th>" + arr[i].quantity + "</th>" +
						"<th>" + arr[i].unitprice + "</th>" +
						"<th>" +
							"<span class=\"label alert-danger\" onclick=\"addToCart(" + arr[i].id + ", '" + arr[i].name + "', " + arr[i].unitprice + ", -1)\");\">-</span>" +
							"<span class=\"label alert-success\" onclick=\"addToCart(" + arr[i].id + ", '" + arr[i].name + "', " + arr[i].unitprice + ", 1)\");\">+</span>" +
						"</th>" +
					"</tr>"
				);
				total += arr[i].quantity * arr[i].unitprice;
			}
			$("#total").text("\u0E3F" + total);
		}
		aj();
	});
	
</script>




