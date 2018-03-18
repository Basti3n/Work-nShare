function showPc(value){
	if(value == 0){
		var sites = document.querySelectorAll(".sites");
		for(var i=0;i<sites.length;i++)
			sites[i].style.display = 'none';
		document.getElementById(value).style.display = 'block';
		document.getElementById("divMatos").style.display = 'block';
		document.getElementById("canvas").style.display = "block";
		document.getElementById("carac").style.display = "block";
		document.getElementById("command").style.display = "block";

	}else{
		document.getElementById("divMatos").style.display = 'none';
		document.getElementById("canvas").style.display = "none";
		document.getElementById("carac").style.display = "none";
		document.getElementById("command").style.display = "none";
	}
}

function ajaxServices(value){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("divService").innerHTML = request.responseText;
				document.getElementById("divService").style.display = 'block';
			}
		}
	};
	request.open('GET', 'showServices.php?space=' +  value);
	request.send();
}