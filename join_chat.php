<?php
	function chat_id_validation($user_input_id){
		$chat_id_search_query = "SELECT chat_id FROM current_chats WHERE chat_id_index = '" . $user_input_id . "';";
		$chat_id_exists = $GLOBALS['connection'] -> query($chat_id_search_query);
		if ($chat_id_exists -> num_rows == 0) {
			return "";
		}else{
			$GLOBALS['user_is_able_to_start_a_session'] = true;
			$GLOBALS['user_is_host'] = false;
			return $user_input_id;
		}
	}
?>