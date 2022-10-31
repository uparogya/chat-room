<?php
	function chat_id_generation(){
		$generated_chat_id = rand(100000000,999999999);
		$existing_chat_id_retriving_query = "SELECT chat_id FROM current_chats WHERE chat_id_index = '" . $generated_chat_id . "';";
		$chat_already_exists = $GLOBALS['connection'] -> query($existing_chat_id_retriving_query);
		if ($chat_already_exists -> num_rows == 0) {
			$chat_id_inserting_query = "INSERT INTO current_chats(chat_id_index , chat_id) VALUES(" .$generated_chat_id. " , " .$generated_chat_id. ");";
			$GLOBALS['connection'] -> query($chat_id_inserting_query);
			$GLOBALS['chat_id_registration_status'] = true;
		}else{
			$GLOBALS['chat_id_registration_status'] = false;
			chat_id_generation();
		}
		if ($GLOBALS['chat_id_registration_status'] == true) {
			return $generated_chat_id;
		}
	}

	function chat_table_creation($table_name){
		$chat_table_creating_query_slice_1 = "CREATE TABLE `chat`.`";
		$chat_table_creating_query_slice_2 = "` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `message` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		$chat_table_creating_query = $chat_table_creating_query_slice_1 . $table_name . $chat_table_creating_query_slice_2;
		$GLOBALS['connection'] -> query($chat_table_creating_query);
	}

	function participants_table_creation($table_name){
		$participants_table_creating_query_slice_1 = "CREATE TABLE `chat`.`";
		$participants_table_creating_query_slice_2 = "` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;";
		$participants_table_creating_query = $participants_table_creating_query_slice_1 . $table_name . "_PARTICIPANTS" . $participants_table_creating_query_slice_2;
		$GLOBALS['connection'] -> query($participants_table_creating_query);
	}

	function adding_notification($table_name,$name){
		$notification_adding_query = "INSERT INTO `" . $table_name . "`(`name`,`message`) VALUES ('" . $name . "','I started the chat room. Press ... above to view more.');";
		$second_notification_adding_query = "INSERT INTO `" . $table_name . "`(`name`,`message`) VALUES ('" . $name . "','Chat ID = " . "<b>" . $table_name . "</b><br>" . " Share this Chat ID with others to add them in this Chat Room.');";
		$GLOBALS['connection'] -> query($notification_adding_query);
		$GLOBALS['connection'] -> query($second_notification_adding_query);
		$GLOBALS['user_is_able_to_start_a_session'] = true;
		$GLOBALS['user_is_host'] = true;
	}

?>