<?php
	$name = $_POST['name'];
	$connection = new mysqli("localhost", "arogya", "verystrongpassword", "chat");
	$inserting_query = "INSERT INTO `TEST` (`MESSAGE`) VALUES('" . $name . "');";
	$connection -> query($inserting_query);
?>