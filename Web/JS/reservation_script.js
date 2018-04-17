
var compteur=0;

var DAY = {
	"Monday" : "Lundi",
	"Tuesday" : "Mardi",
	"Wednesday" : "Mercredi",
	"Thursday" : "Jeudi",
	"Friday" : "Vendredi",
	"Saturday" : "Samedi",
	"Sunday" : "Dimanche"
};


/*var json = {
  	"Lundi":{
              "debut":"09",
              "fin":"20"
  	},
  	"Mardi":{
              "debut":"09",
              "fin":"20"
  	},
  	"Mercredi":{
              "debut":"09",
              "fin":"23"
  	},
  	"Jeudi":{
              "debut":"09",
              "fin":"20"
  	},
  	"Vendredi":{
              "debut":"09",
              "fin":"20"
  	},
  	"Samedi":{
              "debut":"11",
              "fin":"20"
	},
  	"Dimanche":{
              "debut":"11",
              "fin":"20"
  }
};*/


$(document).ready(function(){
    moment.updateLocale('en', {
      week: { dow: 1 } // Monday is the first day of the week
    });


  //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
  $("#weeklyDatePicker").datetimepicker({
    format: 'DD-MM-YYYY'
  });
  //Initialise les valeurs par defaut
 	var first = moment().day(1).format("DD-MM-YYYY");
    var last =  moment().day(7).format("DD-MM-YYYY");
    $("#weeklyDatePicker").val(first + " - " + last);
    //affiche les réservations
    ajaxShowReserv();

   //Get the value of Start and End of Week
  $('#weeklyDatePicker').on('dp.change', function (e) {
      var value = $("#weeklyDatePicker").val();
      var firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
      var lastDate =  moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
      $("#weeklyDatePicker").val(firstDate + " - " + lastDate);
			ajaxShowReserv();
  });
});




function changeBg(id){
	//console.log(document.getElementById(id).className);
	if(document.getElementById(id).classList.contains("libre")){
		document.getElementById(id).classList.add("vosreserv");
		document.getElementById(id).classList.remove("libre");
	}else if(document.getElementById(id).classList.contains("vosreserv")){
		document.getElementById(id).classList.add("libre");
		document.getElementById(id).classList.remove("vosreserv");
	}
}

function reserv(site,serviceContent){
	var week = $('#weeklyDatePicker').val();
	var json1 = [];
	var i = 0 ;
	//console.log(week);
	$(".vosreserv").each(function(){
		var hour =(($(this).attr("id")).split("-")[0]).split("d")[1]+":00:00";
		var day = parseInt(($(this).attr("id")).split("-")[1])+1;
		var test = moment(week, "YYYY-MM-DD").day(day).format("YYYY-MM-DD");
		console.log("date : "+test+" "+hour);
		json1[i]=test+" "+hour;
		i++;
	});
	json1=JSON.stringify(json1);
	document.location ='saveReservation.php?site='+site+'&serviceContent='+serviceContent+'&date=' +  json1;
	/*var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {

			}
		}
	};
	request.open('GET', 'saveReservation.php?date=' +  json);
	request.send();*/

}

function ajaxShowReserv(){
	var week = $('#weeklyDatePicker').val();
	var value = [];
	for (var i = 0;i<7;i++){
		value[i] = moment(week, "YYYY-MM-DD").day(i+1).format("YYYY-MM-DD");
	}


	value = JSON.stringify(value);
	//console.log(value);
	var request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(request.readyState == 4){
			if (request.status == 200 ) {
				document.getElementById("scheduler").innerHTML = request.responseText;
			}
		}
	};
	request.open('GET', 'showReservation.php?date=' +  value+"&site="+space);
	request.send();
}


console.log(space);