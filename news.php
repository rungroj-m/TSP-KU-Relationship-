<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">News</h3>
	</div>
	
	<div class="panel-body">
		<div class="jumbotron">
			<h1>Current Promotion</h1>
			<div class="list-group" id="currentPromotion"></div>
		</div>
	</div>
	
	<div class="panel-body">
		<h1>5 New Products.</h1>
		<div class="list-group" id="newsContent"></div>
	</div>
	
</div>

<script type="text/javascript">

	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: {
			"get_news": ""
		}
	}).done(function(response) {
		$("#newsContent").html(response);
	});

	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: {
			"current_promotion": ""
		}
	}).done(function(response) {
		var pros = JSON.parse(response);
		console.log(pros[0].endDate.date);
		if (pros.length == 0)
			$("#currentPromotion").html("No Promotion.");
		else {
			$("#currentPromotion").html("\
				<h2>Now to " + pros[0].endDate.date.split(" ")[0] + "</h2>\
				<h2><i>Discount " + pros[0].value + "%</i></h2>\
			");
		}
		
	});
</script>