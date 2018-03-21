function ajaxServices(value){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("divService").innerHTML = request.responseText;
				invertDisplay("divService");
			}
		}
	};
	request.open('GET', 'showServices.php?space=' +  value);
	request.send();
}

function ajaxServicesContent(value){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("divMatos").innerHTML = request.responseText;
				invertDisplay("divMatos");
				invertDisplay("model");
			}
		}
	};
	request.open('GET', 'showServiceContent.php?service=' +  value);
	request.send();
}

function invertDisplay(value){
	if(document.getElementById(value).classList.contains("displayNone")){
		document.getElementById(value).classList.add("displayBlock");
		document.getElementById(value).classList.remove("displayNone");

	}else{
		document.getElementById(value).classList.remove("displayBlock");
		document.getElementById(value).classList.add("displayNone");
	}
}

