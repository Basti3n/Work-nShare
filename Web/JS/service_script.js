$( document ).ready(function() {
    $('#model').hide();
    $('#divService').hide();
    $('#divMatos').hide();
    $('#cmd').hide();
});

function hidemat(){
  var g = $('#divService .active').html();
  if (g != "Matériel informatique" && g != "Salle de réunion")
    $('#model').hide( "fast", function() {});
  else
    $('#model').show( "fast", function() {});
}

$(document).on('click', '.btn', function(e){
  e.preventDefault();
  $(this).parent().children().siblings().removeClass('active');
  $(this).toggleClass("active");
});

$(document).on('click', '#divMatos > button', function(e){
    $('#cmd').show( "fast", function() {});
});

$(document).on('click', '#divService > button', function(e){
  $('#cmd').hide( "fast", function() {});
});

$(document).on('click', '#site > button', function(e){
  console.log(":)");
  $('#divMatos').hide( "slow", function() {});
  $('#divService').hide( "fast", function() {});
  $('#model').hide();
  $('#cmd').hide();
});

function ajaxServices(value){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("divService").innerHTML = request.responseText;
				//invertDisplay("divService");
        $('#divService').show( "slow", function() {});
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
        $('#divMatos').show( "slow", function() {});
        hidemat();
			}
		}
	};
	request.open('GET', 'showServiceContent.php?service=' +  value);
	request.send();
}

/*
function invertDisplay(value){
	if(document.getElementById(value).classList.contains("displayNone")){
		document.getElementById(value).classList.add("displayBlock");
		document.getElementById(value).classList.remove("displayNone");

	}else{
		document.getElementById(value).classList.remove("displayBlock");
		document.getElementById(value).classList.add("displayNone");
	}
}
*/


function command(){
	/*Array.from(document.getElementsByClassName("pc .active")).forEach(
		function(element,index,array){
			console.log(element.value);
		});
	console.log("Je suis passé");
	console.log("id clicked : "+Idclick);
	console.log("click  : "+click);*/
	window.location.href='reservation?choice='+Idclick;
}
