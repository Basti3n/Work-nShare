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
		setInterval(function() {$("#overlay").hide(); },500);
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
