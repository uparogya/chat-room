<?php
	include('variables.php');
	session_start();
	$user_message = htmlspecialchars(stripslashes(trim($_POST['message'])));
	$connection = new mysqli($GLOBALS['server'], $GLOBALS['server_username'], $GLOBALS['server_password'], $GLOBALS['server_database']);
	if (!empty($user_message)) {
		$inserting_query = "INSERT INTO `" . $_SESSION['chat_id'] . "` (`name`, `message`) VALUES('" .$_SESSION['username']."','".$user_message."');";
		$connection -> query($inserting_query);
	}
?>