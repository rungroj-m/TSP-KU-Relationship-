<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Transaction</h3>
	</div>
	<div class="panel-body">
		<div>
			<table class="table table-striped table-bordered" id="cart">
				<tr>
					<td>#</td>
					<td>Name</td>
					<td>Quantity</td>
					<td>Unit Price</td>
					<td>Total Price</td>
					<td>Weight</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Address</h3>
	</div>
	<div class="panel-body">
			<form class="form-signin" id="signup-form" role="form">
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="firstname" placeholder="First Name" required="">
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="lastname" placeholder="Last Name" required="">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="address" placeholder="Address" required="">
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="address2" placeholder="Address 2">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="district" placeholder="District" required="">
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="province" placeholder="Province" required="">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-4">
						<input type="text" class="form-control" id="country" placeholder="Country" required="">
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control" id="zip" placeholder="ZIP" required="">
					</div>
					
					<div class="col-md-4">
						<input type="text" class="form-control" id="phone" placeholder="Phone">
					</div>
				</div>
			</form>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Shipping Option</h3>
	</div>
	<div class="panel-body">
		<div>
		
		<table class="table table-hover">
					<tbody id="transaction-list">
						<tr>
							<th>Option</th>
							<th>Fee</th>
							<th>Total</th>
							<th></th>
						</tr>
						<tr>
							<th>EMS</th>
							<th id="emsfee"></th>
							<th id="emstotal"></th>
							<th><input type="radio" name="option" value="1"></th>
						</tr>
						<tr>
							<th>ธรรมดา</th>
							<th id="deliveryfee"></th>
							<th id="deliverytotal"></th>
							<th><input type="radio" name="option" value="2"></th>
							<th></th>
						</tr>
					</tbody>
				</table>
			
		<table class="table">
			<tr>
				<td><button type="button" class="btn btn-info" id="button-back" style="width: 100%">&lt; Back to shopping</button></td>
				<td><button type="button" class="btn btn-primary" id="button-pay" style="width: 100%">Payment &gt;</button></td>
			</tr>
		</table>
			
			
		</div>
	</div>
</div>

<script type="text/javascript">
	var amount = 0;
	var totalquan = 0;
	var totalweight = 0;
	
	$(document).ready(function() {
		showAllProductsInCart();

		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_customer_detail": $.cookie("customerid")
			}
		}).done(function(customer_json) {
			console.log(customer_json);
			var customer_obj = JSON.parse(customer_json);
			console.log(customer_obj);
			$("#firstname").val(customer_obj.firstname);
			$("#lastname").val(customer_obj.lastname);
			$("#address").val(customer_obj.address);
			$("#address2").val(customer_obj.address2);
			$("#district").val(customer_obj.district);
			$("#province").val(customer_obj.province);
			$("#country").val(customer_obj.country);
			$("#zip").val(customer_obj.zip);
			$("#phone").val(customer_obj.phone);
		});
		
	});

	function getEMSFee(weight,amount) {
		var total = 0;
		if(weight < 20)
			total += 32;
		else if(weight < 100)
			total += 37;
		else if(weight < 250)
			total += 42;
		else if(weight < 500)
			total += 52;
		else if(weight < 1000)
			total += 67;
		else if(weight < 1500)
			total += 82;
		else if(weight < 2000)
			total += 97;
		else if(weight < 2500)
			total += 112;
		else if(weight < 3000)
			total += 127;
		else if(weight < 3500)
			total += 147;
		else if(weight < 4000)
			total += 167;
		else if(weight < 4500)
			total += 187;
		else if(weight < 5000)
			total += 207;
		else if(weight < 5500)
			total += 232;
		else if(weight < 6000)
			total += 257;
		else if(weight < 6500)
			total += 282;
		else if(weight < 7000)
			total += 307;
		else if(weight < 7500)
			total += 332;
		else if(weight < 8000)
			total += 357;
		else if(weight < 8500)
			total += 387;
		else if(weight < 9000)
			total += 417;
		else if(weight < 9500)
			total += 447;
		else
			total += 477;
		$("#emsfee").text(total);
		$("#emstotal").text(amount + total);
	}

	function getDeliverFee(weight,amount) {
		var total = 0;
		if(weight < 1000)
			total += 20;
		else if(weight < 2000)
			total += 35;
		else if(weight < 3000)
			total += 50;
		else if(weight < 4000)
			total += 65;
		else if(weight < 5000)
			total += 80;
		else if(weight < 6000)
			total += 95;
		else if(weight < 7000)
			total += 110;
		else if(weight < 8000)
			total += 125;
		else if(weight < 9000)
			total += 140;
		else
			total += 155;
		$("#deliveryfee").text(total);
		$("#deliverytotal").text(amount + total);
	}
	
	function addToCart(productId, productName, price, quantity/*, maxQuan*/) {
		if ($.cookie("customerid") == undefined) {
			$("#alert-signin").modal({
				show: true
			});
			pid = productId; pn = productName; p = price; q = quantity;// mq = maxQuan;
		}
		else {
			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				data: {
					"add_to_cart": $.cookie("customerid"),
					"product_id": productId,
					"quantity": quantity
				}
			}).done(function(response) {
				showAllProductsInCart();
			});
		}
	}

	function showAllProductsInCart() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_all_product_in_cart": $.cookie("customerid")
			}
		}).done(function(products_json) {
			amount = 0;
			totalquan = 0;
			totalweight = 0;
			
			$("#cart").empty();
			$("#cart").append("\
				<thead><tr>\
					<th>#</th>\
					<th>Name</th>\
					<th>Quantity</th>\
					<th>Unit Price</th>\
					<th>Total Price</th>\
					<th>Weight</th>\
				</tr></thead>\
			");

			var array = JSON.parse(products_json);
			for (var i = 0; i < array.length; i++) {

				var productName = array[i].Product.productDescription.productName;
				var quantity = array[i].Quantity;
				var unitprice = array[i].Product.price;
				var weight = array[i].Product.productDescription.weight;
				var pid = array[i].Product.id;
				
				$("#cart").append(
						"<tr>" +
							"<th>" + (i+1) + "</th>" +
							"<th>" + productName + "</th>" +
							"<th>" +
							"<span class=\"label alert-danger\" onclick=\"addToCart(" + pid + ", '" + productName + "', " + unitprice + ", -1);\">-</span>" +
							"<span class=\"label alert-success\" onclick=\"addToCart(" + pid + ", '" + productName + "', " + unitprice + ", 1);\">+</span>" +
							"&nbsp;" + quantity +
							"</th>" +
							"<th>" + unitprice + "</th>" +
							"<th>" + quantity * unitprice + "</th>" +
							"<th>" + quantity * weight+ "</th>" +
						"</tr>"
				);
				amount += quantity * unitprice;
				totalquan += Number(quantity);
				totalweight += Number(quantity * weight);
			}
			$("#cart").append(
					"<tr>" +
						"<th></th>" +
						"<th>Total</th>" +
						"<th>" + totalquan +"</th>" +
						"<th></th>" +
						"<th>" + amount +"</th>" +
						"<th>" + totalweight +"</th>" +
					"</tr>"
			);

		getEMSFee(totalweight,amount);
		getDeliverFee(totalweight,amount);
		});
	}

	$("#button-back").click(function() {
		window.location.href = "?page=shopping";
	});

	$("#button-pay").click(function() {
		var passfee = 0; 
		var option = $("input:radio[name=option]:checked").val();
			if (option == 1)
				passfee = $("#emsfee").text();
			else if (option == 2)
				passfee = $("#deliveryfee").text();
		
		if (option == undefined)
			alert("Please choose shipping method.");
		else {
			var cd = $("#firstname").val() + " " + $("#lastname").val() + "**" + 
			$("#address").val() + "**" + $("#address2").val() + "**" + 
			$("#district").val() + "**" + $("#province").val() + "**" + 
			$("#country").val() + "**" + $("#zip").val() + "**" + 
			$("#phone").val();
			post("?page=dummycredit", {fee: passfee, customer_detail: cd});
		}
	});

	function post(path, params) {
	    var method = "POST";
	    
	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", path);

	    for(var key in params) {
	        if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

	            form.appendChild(hiddenField);
	         }
	    }

	    document.body.appendChild(form);
	    form.submit();
	}
</script>








