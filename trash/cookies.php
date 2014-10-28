<script src="js/jquery.js"></script>
<script src="js/jquery.cookie.js"></script>

<script type="text/javascript">
console.log($.cookie('cat') == undefined);
$.cookie('dog', 11, { expires: 365 })
console.log($.cookie('dog'));
// 	var arr = [];
//  	arr.push({"cat": 2});
//  	arr.push({"dog": 2});
//  	arr.push({"cat": 2});

// // 	arr.push("cat");
// // 	arr.push("dog");
// // 	arr.push("cat");
	
// 	$.cookie('name', JSON.stringify(arr), { expires: 365 });
// 	console.log(arr);
// 	console.log($.cookie('name'));

// 	console.log($.cookie('name'));
// 	var z = $.parseJSON($.cookie('name'));
//  	z.push({"duck": 5});
// 	console.log(z);
	
</script>