function show_hide(){
	if (document.getElementById('hide').style.display == "none") {
		document.getElementById('hide').style.display = "block";
		document.getElementById('show').style.display = "none";
	}else{
		document.getElementById('hide').style.display = "none";
		document.getElementById('show').style.display = "block";
	};
	if (document.getElementById('chat_information').style.display == "none") {
		document.getElementById('chat_information').style.display = "flex";
	}else{
		document.getElementById('chat_information').style.display = "none";
	};
}