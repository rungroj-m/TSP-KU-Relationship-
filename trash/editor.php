<html>
<head>
<!-- include libries(jQuery, bootstrap, fontawesome) -->
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet"> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

<!-- include summernote css/js-->
<link href="../css/summernote.css" rel="stylesheet">
<script src="../js/summernote.js"></script>
</head>


<body>
<div id="summernote">Hello Summernote</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#summernote').summernote({
		  height: 300,                 // set editor height

		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor

		  focus: true,                 // set focus to editable area after initializing summernote
	});
});


</script>

</body>
</html>