var btns = document.getElementsByClassName("pc");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}


function showPc(value){
	var sites = document.querySelectorAll(".sites");
	for(var i=0;i<sites.length;i++)
		sites[i].style.display = 'none';
	document.getElementById(value).style.display = 'block';
}