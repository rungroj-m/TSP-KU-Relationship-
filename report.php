<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Report</h3>
	</div>
	<div class="panel-body">
		body
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_all_transaction': '',
			}
		}).done(function(json_str) {
			
		});

	});
</script>
