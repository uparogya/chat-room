<?php 
	$connection = new mysqli("localhost", "arogya", "verystrongpassword", "chat");
	$retriving_query = "SELECT * FROM `TEST`";
	$result = $connection -> query($retriving_query);
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			echo $row["MESSAGE"] . "<br>";
		}
	}else{
		echo "empty";
	}
?>