function showPc(value){
	if(value == 0){
		var sites = document.querySelectorAll(".sites");
		for(var i=0;i<sites.length;i++)
			sites[i].style.display = 'none';
		document.getElementById(value).style.display = 'block';
		document.getElementById("divMatos").style.display = 'block';
		document.getElementById("canvas").style.display = "block";
	}else{
		document.getElementById("divMatos").style.display = 'none';
		document.getElementById("canvas").style.display = "none";
	}
}

function showService(){
	document.getElementById("divService").style.display = 'block';
}