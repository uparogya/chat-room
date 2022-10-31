<?php
	include('variables.php');
	session_start();
	$connection = new mysqli($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
	$retriving_query = "SELECT `name` , `message` FROM `" . $_SESSION['chat_id'] . "`;";
	$result = $connection -> query($retriving_query);
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			if ($row["name"] == $_SESSION['username']){
				echo "<p id='my_messages'><b>".$row["name"]."(me) </b><br>".$row["message"]."</p><span id='scroll_here'></span>";
			}else{
				echo "<p id='others_messages'><b>".$row["name"]."</b><br>".$row["message"]."</p><span id='scroll_here'></span>";
			}
		}
	}else{
		header('location:chat_ended.php');
	}
?>