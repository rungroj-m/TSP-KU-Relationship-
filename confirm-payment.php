<div>
<p>CartId = <?php echo $_POST["cartId"] ?><p>
<p>OrderTrackingId = <span id="orderTrackingId"></span><p>
<p>Status = <span id="status"></span><p>
</div>

<?php 
print_r($_POST);
?>
<script type="text/javascript">
	$.ajax({
		url: 'http://128.199.145.53:11111/orders/new',
		type: "GET",
		//data : "<order/>",
// 		headers: {
// 	        "Content-Type": "application/xml"
// 	    }
	}).done(function(obj) {
// 		console.log(obj);
// 	    console.log(obj.orders.order.id)
	    var orderTrackingId = obj.orders.order.id;
	    $("#orderTrackingId").text(orderTrackingId);
	    $.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data : {
				"bind_cartid_ordertrackingid": "",
				"cartId": <?php echo $_POST["cartId"] ?>,
				"orderTrackingId": orderTrackingId
			}
		}).done(function(response) {
			$.ajax({
				url: 'http://128.199.145.53:11111/orders/current/' + orderTrackingId,
				type: "GET"
			}).done(function(status) {
				var obj = JSON.parse(status);
// 				console.log(obj);
				$("#status").text(obj.orders.order.status.type);
			});
		});
	});
</script>