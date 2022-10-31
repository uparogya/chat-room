<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex">
	<meta charset="utf-8">
	<title>Ended</title>
	<style>
		#ended_body{
			font-family: 'Courier New', monospace;
		}
		#ended_div{
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			text-align: center;
			padding: 5vh 5vw;
			overflow: hidden;
		}
		#ended_div h2{
			color: #33658A;
			display: block;
			-webkit-touch-callout: none; 
		    -webkit-user-select: none; 
		     -khtml-user-select: none;
		       -moz-user-select: none;
		        -ms-user-select: none;
		            user-select: none;
		}
		#ended_button{
			width: 46%;
			border: 1px solid;
			border-radius: 5px;
			font-size: 20px;
			font-family: monospace;
			font-variant: small-caps;
			background-color: transparent;
			color: #33658A;
			transition: 0.5s;
			cursor: pointer;
		}
		#ended_button:hover, #ended_button:focus{
			border-size: 1.5px;
			transform: scale(1.07);
		}
		@media(prefers-color-scheme: dark){
			#ended_button{
				border-color: gray;
			}
		}
		@media(prefers-color-scheme: light){
			#ended_button{
				border-color: black;
			}
		}
	</style>
</head>
<body id="ended_body">
	<div id="ended_div">
		<h2 id="ended_div">The Host Ended The Chat</h2>
		<p>Thank You For Joining!</p>
		<button onclick="refresh()" id="ended_button">Go Back</button>
	</div>
</body>
</html>
<script type="text/javascript">
	function refresh(){
		location.reload();
	}
</script>
<script type="text/javascript">
	window.history.pushState(null, null, window.location.href);
	window.onpopstate = function () {
    	window.history.go(1);
	};
</script>