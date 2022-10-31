<?php
	include('variables.php');
	function sanitizing($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function true_string_check($data){
		if(! preg_match("/^[a-zA-Z ]*$/", $data)){
			return false;
		}else{
			return true;
		}
	}
	function true_integer_check($data){
		if(! preg_match("/^[0-9]*$/", $data)){
			return false;
		}else{
			return true;
		}
	}
	function name_exist_check($obtained_name){
		$GLOBALS['connection'] = new mysqli($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
		$name_searching_query = "SELECT `id` FROM " . $_SESSION['chat_id'] . "_PARTICIPANTS WHERE name='".$obtained_name."';";
		$random_num = rand(0,100);
		$obtaines_rows = $GLOBALS['connection'] -> query($name_searching_query);
		if ($obtaines_rows -> num_rows == 0) {
			return $obtained_name;
		}else{
			return $obtained_name . $random_num;
		}
	}
?>