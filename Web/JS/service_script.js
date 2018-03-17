function showPc(value){
	var sites = document.querySelectorAll(".sites");
	for(var i=0;i<sites.length;i++)
		sites[i].style.display = 'none';
	document.getElementById(value).style.display = 'block';
	document.getElementById("matos").style.display = 'block';
	document.getElementById("canvas").style.display = "block";
}