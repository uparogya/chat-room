<?php
	include('variables.php');
	if (isset($_COOKIE['chat_id'])) {
        header('location:chat_page.php');
    }
	$GLOBALS['connection'] = new mysqli($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
	$GLOBALS['user_is_able_to_start_a_session'] = false;
	$username=$name_error=$user_input_id=$user_input_id_error="";
	include 'essentials.php';
 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$initial_username = sanitizing($_POST['user_name']);
		$is_the_username_string = true_string_check($initial_username);
		if (($is_the_username_string == true) AND !empty($initial_username)) {
			$username = $initial_username;
		}else{
			$name_error = "Inalid Name <br><br>";
		}

		$initial_user_input_id = sanitizing($_POST['user_input_id']);
		$is_the_user_input_id_integer = true_integer_check($initial_user_input_id);
		if (($is_the_user_input_id_integer == true) AND !empty($initial_user_input_id)) {
			$user_input_id = $initial_user_input_id;
		}else{
			if (isset($_POST['join_chat'])) {
				$user_input_id_error = "Invalid ID <br><br>";
			}
		}

		if($username<>""){
			if ($user_input_id<>""){
				if (isset($_POST['join_chat'])) {
					include 'join_chat.php';
					$chat_id = chat_id_validation($user_input_id);
					if ($chat_id == "") {
						$user_input_id_error = "Invalid ID <br><br>";
					}
				}
			}
			if (isset($_POST['create_chat'])) {
				include 'create_chat.php';
				$chat_id = chat_id_generation();
				if ($GLOBALS['chat_id_registration_status'] == true) {
					chat_table_creation($chat_id);
					participants_table_creation($chat_id);
					adding_notification($chat_id,$username);
				}
			}
		}
	}

	if ($GLOBALS['user_is_able_to_start_a_session'] == true) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['chat_id'] = $chat_id;
		setcookie("username", $_SESSION['username'], time()+86400, "/");
		setcookie("chat_id", $_SESSION['chat_id'], time()+86400, "/");
		if ($GLOBALS['user_is_host']==true) {
			$_SESSION['host']=true;
			setcookie($chat_id, $_SESSION['host'], time()+86400, "/");
		}else{
			$_SESSION['host']=false;
			$non_host_notification_adding_query = "INSERT INTO `" . $_SESSION['chat_id'] . "`(`name`,`message`) VALUES ('" . $_SESSION['username'] . "','I joined the chat room.');";
			$GLOBALS['connection'] -> query($non_host_notification_adding_query);
		}
	}

	if ( (isset($_POST['join_chat']) OR isset($_POST['create_chat'])) AND ($GLOBALS['user_is_able_to_start_a_session'] == true) AND ($_SESSION['username']<>"") AND $_SESSION['chat_id'] <> "")  {
		$name_error=$user_input_id_error="";
		$name_1 = name_exist_check($_SESSION['username']);
		$name_2 = name_exist_check($name_1);
		$user_registration_query = "INSERT INTO `" . $_SESSION['chat_id'] . "_PARTICIPANTS` (`name`) VALUES ('" . $name_2 . "');";
		$GLOBALS['connection'] -> query($user_registration_query);
		$_SESSION['userid'] = $GLOBALS['connection']->insert_id;
		header('location:chat_page.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta Content-Type= "text/html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Chat Room created by Arogya Upadhyaya">
	<meta name="keywords" content="Arogya, Arogya Upadhyaya, Arogya Chat Room">
	<meta name="author" content="Arogya Upadhyaya">
	<meta name = "revised" content = "Arogya Upadhyaya, 10/9/2021">
	<meta cache-control = "public">
	<meta name="theme-color" content="#33658A">
	<title>Chat</title>
	<link rel="icon" type="png" href="header.PNG">
	<link rel="stylesheet" type="text/css" href="home_page_style_sheet.css">
</head>
<body>
	<form method="POST" action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" autocomplete="off">
		<h2>Enter Chat Room</h2>
		<input type="text" name="user_name" placeholder="Name" value="<?php echo($username); ?>" maxlength="25" autocomplete="off">
		<input type="text" name="user_input_id" placeholder="Chat ID" value="<?php echo($user_input_id); ?>" maxlength="9" autocomplete="off">
		<div class="button_holder">
			<input type="submit" name="join_chat" value="Join">
			<input type="submit" name="create_chat" value="Create">
		</div>
		<div class="error_list">
			<br><?php echo $name_error; ?><?php echo $user_input_id_error; ?><br>
		</div>
	</form>
</body>
</html>
<script type="text/javascript">
	window.history.pushState(null, null, window.location.href);
	window.onpopstate = function () {
    	window.history.go(1);
	};
</script>