<?php
	include('variables.php');
	session_start();
	$connection = new mysqli($GLOBALS['server'], $GLOBALS['server_username'], $GLOBALS['server_password'], $GLOBALS['server_database']);
	$chat_id_search_query = "SELECT chat_id FROM current_chats WHERE chat_id_index = '" . $_COOKIE['chat_id'] . "';";
	$chat_id_exists = $connection -> query($chat_id_search_query);
	if ($chat_id_exists -> num_rows == 0) {
		$chat_exists = false;
	}else{
		$chat_exists = true;
	}
	if (($_SESSION['chat_id']=="") OR ($chat_exists == false)) {
		setcookie("username", "", time()-1, "/");
		setcookie("chat_id", "", time()-1, "/");
		setcookie($_SESSION['chat_id'], "", time()-1, "/");
		setcookie("PHPSESSID", "", time()-1, "/");
		session_unset();
		session_destroy();
		header('location:index.php');
	}

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_POST['leave_chat'])) {
			$leave_notification_adding_query = "INSERT INTO `" . $_SESSION['chat_id'] . "`(`name`,`message`) VALUES ('" . $_SESSION['username'] . "','I left the chat room.');";
			$connection -> query($leave_notification_adding_query);
			$removing_name_query = "DELETE FROM `" . $_SESSION['chat_id'] . "_PARTICIPANTS` WHERE `" . $_SESSION['chat_id'] . "_PARTICIPANTS`.`id` = " . $_SESSION['userid'];
			$connection -> query($removing_name_query);
			setcookie("username", "", time()-1, "/");
			setcookie("chat_id", "", time()-1, "/");
			setcookie("PHPSESSID", "", time()-1, "/");
			session_unset();
			session_destroy();
			header('location:index.php');
		}
		if (isset($_POST['end_chat'])) {
			include 'end_chat.php';
			remove_chat_footprints($_SESSION['chat_id']);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex">
	<meta charset="utf-8">
	<meta name="theme-color" content="#33658A">
	<title>Chat Room : <?php echo $_SESSION['chat_id']; ?></title>
	<link rel="stylesheet" type="text/css" href="chat_page_style_sheet.css">
	<script type="text/javascript" src="javascript.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>
	    $(document).ready(function(){
			 $("#participants_view").load("participant_list.php");
	        setInterval(function() {
	            $("#participants_view").load("participant_list.php");
	        }, 1000);
	    });
	</script>
	<script>
	    $(document).ready(function(){
			 $("#messages").load("retrived_messages.php");
	        setInterval(function() {
	            $("#messages").load("retrived_messages.php");
	        }, 500);
	    });
	</script>
	<script>
		function message_handeling_client_side(){
			var message = document.getElementById('message').value;
			var dataString = 'message=' + message;
			$.ajax({
				 type:"post",
				 url: "server_side_message_processing.php",
				 data:dataString,
				 cache:false,
				 success: function(html){
				 	//var $content = $("#messages");
        			//$content.scrollTop = $content.scrollHeight;
				 }
			});
			//document.getElementsByClassName("message_sender").reset();
			$("#message_sender")[0].reset();
			return false;
		}
	</script>
</head>
<body>
	<div class="navigation_bar">
		<h3><?php echo "Hello " . $_SESSION['username'] . "!"; ?></h3>
		<form method="POST" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"])); ?>">
			<input type="submit" name="leave_chat" value="Leave Session">
			<?php
				if ((isset($_COOKIE[$_SESSION['chat_id']])) AND ($_COOKIE[$_SESSION['chat_id']]==true)) {
					echo '<input type="submit" name="end_chat" value="End Session">';
				}
			?>
		</form>
	</div>
	<div id="message_holder">
		<div class="info_button">
			<button id="show" onclick="show_hide()">...</button>
			<button id="hide" onclick="show_hide()" style="display:none;">&#10005;</button>
		</div>
		<div id="chat_information" style="display:none;">
			<p><b>Chat ID: <?php  echo $_SESSION['chat_id']; ?></b></p>
			<hr style="width:90%">
			<p><b>Active:</b></p><br>
			<div id="participants_view"></div>
		</div>
		<div id="messages">
		</div>
	</div>
	<form id="message_sender" autocomplete="off">
		<input type="text" id="message" placeholder="Text Message" autofocus autocomplete="off">
		<input type="submit" onclick="return message_handeling_client_side()" value="Send">
	</form>
</body>
</html>
<script type="text/javascript">
	window.history.pushState(null, null, window.location.href);
	window.onpopstate = function () {
    	window.history.go(1);
	};
</script>