

function add(){
	console.log($('#val1').val());
	console.log($('#val').val());
}

$(function () {
	$("#datepicker").datepicker({
	    autoclose: true,
	    todayHighlight: true,
	    format: 'yyyy-mm-dd'
	}).datepicker('update', new Date());
});
$(function () {
	$("#datepicker1").datepicker({
	    autoclose: true,
	    todayHighlight: true,
	    format: 'yyyy-mm-dd'
	}).datepicker('update', new Date());
});