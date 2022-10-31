<?php
	include 'index.php';
	function remove_chat_footprints($table_name){
		$table_clearing_query = "TRUNCATE `" . $table_name . "`;";
		$table_removing_query = "DROP TABLE `" . $table_name . "`;";
		$participant_table_clearing_query = "TURNCATE `" . $table_name . "_PARTICIPANTS" . "`;";
		$participant_table_removing_query = "DROP TABLE `" . $table_name . "_PARTICIPANTS" . "`;";
		$removing_from_active_chats = "DELETE FROM `current_chats` WHERE `current_chats`.`chat_id_index` = " . $table_name;
		$GLOBALS['connection'] -> query($removing_from_active_chats);
		$GLOBALS['connection'] -> query($table_clearing_query);
		$GLOBALS['connection'] -> query($table_removing_query);
		$GLOBALS['connection'] -> query($participant_table_clearing_query);
		$GLOBALS['connection'] -> query($participant_table_removing_query);
		setcookie("username", "", time()-1, "/");
		setcookie("chat_id", "", time()-1, "/");
		setcookie($table_name, "", time()-1, "/");
		setcookie("PHPSESSID", "", time()-1, "/");
		session_unset();
		session_destroy();
		header('location:index.php');
	}
?>