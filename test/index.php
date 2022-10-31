<?php
	$connection = new mysqli("localhost", "arogya", "verystrongpassword", "chat");
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_POST['submit_data'])) {
			$inserting_query = "INSERT INTO `TEST` (`MESSAGE`) VALUES('" . $_POST['data'] . "');";
			$connection -> query($inserting_query);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>TEST</title>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script>
	    $(document).ready(function(){
			 $("#div_refresh").load("temp_data.php");
	        setInterval(function() {
	            $("#div_refresh").load("temp_data.php");
	        }, 1000);
	    });
	</script>
	<script>
		function chk(){
			var name = document.getElementById('name').value;
			var dataString = 'name=' + name;
			$.ajax({
				 type:"post",
				 url: "message_processing.php",
				 data:dataString,
				 cache:false,
				 success: function(html){
				 	$('#msg').html(html); 
				 }
			});
			return false;
		}
	</script>
</head>
<body>
	<div id="div_refresh"></div>
	<p id = "msg"></p>

	<form>
		<input type="text" id="name">
		<input type="submit" value="submit" onclick="return chk()">
	</form>
</body>
</html>