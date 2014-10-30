<head>
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.cookie.js"></script>
	<script src="../js/bootstrap-dropdown.js"></script>
	<script src="../bootstrap/js/bootstrap.js"></script>
</head>



<div style="background-color: pink" id="content" onclick="alert('s'); fn(); alert('d');">
div
</div>


<script type="text/javascript">
function fn() {
	$.ajax({
		url: '../forjscallphp.php',
		type: "POST",
		data: { "get_product_detail": "" }
	}).done(function(response) {
		console.log(response);
		console.log($.parseJSON(response));
	    alert($.parseJSON(response).one);
	});
}


</script>
