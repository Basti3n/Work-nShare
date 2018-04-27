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

function sendTicket(email,idPrimaryTicket){
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
		'emailToSave='+email,
    'contentTicket='+contentTicket,
    'idPrimaryTicket='+idPrimaryTicket
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


function displayTickets(idTicket,email){

  var request = new XMLHttpRequest();


  request.onreadystatechange = function(){
    if(request.readyState == 4 ){
      var test = request.responseText;
      //console.log(test);
      if(test !="NO VALUE" ){
        var search = JSON.parse(request.responseText);
      }
      setDisplayTicket(test,search);
      setButton(email,idTicket);
   }
  };
  request.open("POST",'ajaxFile\\getLinkedTicket.php');
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")

  var params = [
    'idTicket='+idTicket
  ];
  var body = params.join('&');
  request.send(body);
}

function setDisplayTicket(test,search){
  var ticketChainDiv = document.getElementById('ticketChainDiv');
  ticketChainDiv.innerHTML ="";
  if(test!="NO VALUE"){
    ticketChainDiv.classList.remove('hidden');
    search.forEach(function(ticket){
      ticketChainDiv.innerHTML += '<div class="col-md-12"> <div class="ticketAdvancedMessage '+(ticket.ticketSenderStatus=="1"?"sender":"receiver")+'">'+ticket.contentTicket+'</div> </div>';
    });
  }

}

function setButton(email,idTicket){
  var answerButtonDiv = document.getElementById('answerButtonDiv');
  var sendTicketButtonDiv = document.getElementById('sendTicketButtonDiv');
  var answerButton = document.getElementById('answerButton');
  var cancelButton = document.getElementById('cancelAnswerButtonDiv');

  sendTicketButtonDiv.classList.add('hidden');
  answerButtonDiv.classList.remove('hidden');
  cancelButton.classList.remove('hidden');
  answerButton.setAttribute('onclick','sendTicket(\''+email+'\','+idTicket+')');

}
