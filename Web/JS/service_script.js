function ajaxServices(value){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("divService").innerHTML = request.responseText;
				//invertDisplay("divService");
				document.getElementById("divService").classList.add("displayBlock");
				document.getElementById("divService").classList.remove("displayNone");
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
				//invertDisplay("divMatos");
				//invertDisplay("model");
				document.getElementById("divMatos").classList.add("displayBlock");
				document.getElementById("model").classList.add("displayBlock");
				document.getElementById("divMatos").classList.remove("displayNone");
				document.getElementById("model").classList.remove("displayNone");
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


function command(){
	/*Array.from(document.getElementsByClassName("pc .active")).forEach(
		function(element,index,array){
			console.log(element.value);
		});
	console.log("Je suis passé");*/
	console.log("id clicked : "+Idclick);
	console.log("click  : "+click);
	window.location.href='reservation?choice='+Idclick;
}
