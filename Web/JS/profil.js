$( document ).ready(function() {
    $('#list-tab a[href="#general"]').tab('show');
    getresult("pagination.ticket.php");
});

$('.list-group a').click(function() {
      $(this).siblings('a').removeClass('active');
      $(this).addClass('active');
  });

function abbo(){
  window.location.href='http://localhost/Work-nShare/Web/subscribe.php';
}


/************************\
        pagination
\************************/
function getresult(url) {
  $("#pagresult").remove();
  $("#contain").prepend( "<div id='pagresult'></div>" );
	$.ajax({
		url: url,
		type: "GET",
		data:  {rowcount:$("#rowcount").val()},
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
		$("#pagresult").html(data);
		setInterval(function() {
      $("#overlay").hide(); 
    },500);
		},
		error: function()
		{}
   });
}
function changePagination(option) {
	if(option!= "") {
		getresult("pagination.ticket.php");
	}
}

function sendTicket(email){
  var ticketCategory = getTicketCategory();
  var contentTicket = document.getElementById('inputContentTicket').value;

  console.log(ticketCategory + email + contentTicket);

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
		'emailToSave='+email,
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
