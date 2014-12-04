
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Credit card</h3>
	</div>
	<div class="panel-body">
		<div>
		Name <input type="text" id="name" value="Poramate Homprakob"><br>
		Card Number<input type="text" id="number" value="1909253600008099"><br>
		EXP Date<input type="text" id="month" value="11">/<input type="text" id="year" value="15"><br>
		CVV<input type="password" id="cvv" value="199"><br>
		<input type="button" value="Confirm" id="button-confirm">
		<input type="button" value="Cancel">
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#button-confirm").click(function() {
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"confirm-payment" : "",
				"name" : $("#name").val(),
				"number" : $("#number").val(),
				"cvv" : $("#cvv").val(),
				"expMonth" : $("#month").val(),
				"expYear" : $("#year").val(),
				"customerid" : $.cookie("customerid"),
				"fee" : <?php echo $_POST["fee"]; ?>,
				"customerDetail": "<?php echo $_POST["customer_detail"]; ?>"
			}
		}).done(function(response) {
			console.log(response);
			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				data: {
					"get_cartid_by_customerid": $.cookie("customerid")
				}
			}).done(function(cartid) {
				 post("?page=transaction-detail&cartId=" + (cartid - 1), {});
			});
				   
		});
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