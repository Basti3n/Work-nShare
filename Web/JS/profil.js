$( document ).ready(function() {
    $('#list-tab a[href="#general"]').tab('show');
});

$('.list-group a').click(function() {
      $(this).siblings('a').removeClass('active');
      $(this).addClass('active');
  });

function abbo(){
  window.location.href='http://localhost/Work-nShare/Web/subscribe.php';
}
/*
$("#YourElementID").css({ display: "block" });
$('#list-tab a[href="#general"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#messages"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#abonnement"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#services"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#historique"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#desactive"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});
*/

function sendTicket(email){
  var ticketCategory = getTicketCategory();
  var contentTicket = document.getElementById('inputContentTicket').value;

  //console.log(ticketCategory + email + contentTicket);

  var request = new XMLHttpRequest();

	request.onreadystatechange =function(){
	  if(request.readyState == 4){
	    if(request.status ==200){
	    	  console.log(request.responseText);

	    }
	  }
	};


	request.open("POST",'ajaxFile\\createTicket.php');
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	var params = [
		'ticketCategory='+ticketCategory,
		'email='+email,
    'contentTicket='+contentTicket
	];
	var body = params.join('&');
	request.send(body);
}

function getTicketCategory(){
	var select = document.getElementById('inputCategoryTicket');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var value = selectedOption.value;
	return value;
}
