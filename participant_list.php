<?php
	include('variables.php');
	session_start();
	$connection = new mysqli($GLOBALS['server'], $GLOBALS['server_username'], $GLOBALS['server_password'], $GLOBALS['server_database']);
	$retriving_query = "SELECT name FROM `" . $_SESSION['chat_id'] . "_PARTICIPANTS`";
	$result = $connection -> query($retriving_query);
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			echo "<p>".$row["name"]."</p>";
		}
	}else{
		header('location:no_participants.php');
	}
?>