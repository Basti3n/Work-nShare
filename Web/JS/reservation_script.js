
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


var json = {
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
};

function add(){
	console.log($('#val1').val());
	console.log($('#val').val());
}

$(function () {
	$("#datepicker").datepicker({
	    autoclose: true,
	    todayHighlight: true,
	    language: 'fr',
	    format: 'yyyy-mm-dd DD'

	}).datepicker('update', new Date());
});
$(function () {
	$("#datepicker1").datepicker({
	    autoclose: true,
	    todayHighlight: true,
	    language: 'fr',
	    format: 'yyyy-mm-dd DD'
	}).datepicker('update', new Date());
});

$(document).ready(function () {
	var fin =  new Date();
	//debut
	var str = $("#val").val();
	str = str.split(" ")[1];
	str = DAY[str];
	//fin
	var str2 = $("#val1").val();
	str2 = str2.split(" ")[1];
	str2 = DAY[str2];

	//debut
	document.getElementById("startTime").min = json[str]["debut"]+":00";
	document.getElementById("startTime").max = (parseInt(json[str]["fin"])-1)+":00";
	console.log("jh");
	//fin
	document.getElementById("endTime").max = (parseInt(json[str2]["fin"])-1)+":00";
	document.getElementById("endTime").min = json[str2]["debut"]+":00";


	if(fin.getHours() > parseInt(json[str]["fin"])){
		document.getElementById("startTime").value =json[str]["debut"]+":00";
	}else{
		document.getElementById("startTime").value = fin.getHours()+":"+(fin.getMinutes()<10?"0"+fin.getMinutes():fin.getMinutes());
	}
	if(fin.getHours() > parseInt(json[str2]["fin"])){
		document.getElementById("endTime").value =json[str2]["debut"]+":00";
	}else{
		document.getElementById("endTime").value = fin.getHours()+":"+(fin.getMinutes()<10?"0"+fin.getMinutes():fin.getMinutes());
	}

	$('#datepicker').datepicker().on('changeDate', function (ev) {
	    changeValu("#val");
	});
	$('#datepicker1').datepicker().on('changeDate', function (ev) {
	    changeValu("#val1");
	});
});


function changeValu(value){
	var str = $(value).val();
	str = str.split(" ")[1];
	str = DAY[str];
	var fin =  new Date();
	if(value == "#val"){
		document.getElementById("startTime").min = json[str]["debut"]+":00";
		document.getElementById("startTime").max = (parseInt(json[str]["fin"])-1)+":00";

		if(fin.getHours() > parseInt(json[str]["fin"])){
			document.getElementById("startTime").value =json[str]["debut"]+":00";;
		}else{
			document.getElementById("startTime").value = fin.getHours()+":"+(fin.getMinutes()<10?"0"+fin.getMinutes():fin.getMinutes());
		}		

	}else if(value == "#val1"){
		document.getElementById("endTime").max = (parseInt(json[str]["fin"])-1)+":00";
		document.getElementById("endTime").min = json[str]["debut"]+":00";
		if(fin.getHours() > parseInt(json[str]["fin"])){
			document.getElementById("endTime").value =json[str]["debut"]+":00";;
		}else{
			document.getElementById("endTime").value = fin.getHours()+":"+(fin.getMinutes()<10?"0"+fin.getMinutes():fin.getMinutes());
		}
	}

}
