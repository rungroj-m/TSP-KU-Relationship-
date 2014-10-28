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
				<table class="table">
					<tbody id="cart">
						<tr>
							<th>Product</th>
							<th>Q.</th>
							<th>U.P.</th>
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
	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: { "get_product_by_category_for_shopping": "3" }
	}).done(function(response) {
	    $("#productBoxContainer").html(response);
	});

	function addToCart(productId, productName, price) {
		if ($.cookie("cartItems") == undefined) {
			var arr = [{id: productId, name: productName, quantity: 1, unitprice: price}];
			
			$.cookie("cartItems", JSON.stringify(arr), { expires: 15 }); // in 15 days
		}
		else {
			block: {
				var arr = $.parseJSON($.cookie('cartItems'));
				for (var i = 0; i < arr.length; i++) {
					if (arr[i].id == productId) {
						arr[i].quantity += 1;
						break block;
					}
				}
				arr.push({id: productId, name: productName, quantity: 1, unitprice: price});
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
			</tr>\
		");
		var total = 0;
		for (var i = 0; i < arr.length; i++) {
			$("#cart").append(
					"<tr>" +
						"<th>" + arr[i].name.substring(0, 12) + "</th>" +
						"<th>" + arr[i].quantity + "</th>" +
						"<th>" + arr[i].unitprice + "</th>" +
					"</tr>"
			);
			total += arr[i].quantity * arr[i].unitprice;
		}
		console.log(total);
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
						"</tr>"
				);
				total += arr[i].quantity * arr[i].unitprice;
			}
			console.log(total);
			$("#total").text("\u0E3F" + total);
		}
	});
	
</script>




