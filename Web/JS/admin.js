//Jquery
$(document).ready(function() {
  $('#list-tab a[href="#general"]').tab('show');
  //getresult("pagination.ticket.php");
  changeTable();
  initSpaceArray();
  initServiceArray();
  getAllRight();
});

$('.list-group a').click(function() {
  $(this).siblings('a').removeClass('active');
  $(this).addClass('active');

});

$('#addSpaceButton').on('click', function(e) {
  $('#createSpacePannel').removeClass('hidden');
});

$('#cancelCreateSpaceButton').on('click', function(e) {
  $('#createSpacePannel').addClass('hidden');
});

$('#addServiceButton').on('click', function(e) {
  $('#createServicePannel').removeClass('hidden');
});

$('#cancelCreateServiceButton').on('click', function(e) {
  $('#createServicePannel').addClass('hidden');
});

$('#addServiceContentButton').on('click', function(e) {
  $('#createServiceContentPannel').removeClass('hidden');
});

$('#cancelCreateServiceContentButton').on('click', function(e) {
  $('#createServiceContentPannel').addClass('hidden');
});

$('#cancelChangeSchedulePannelButton').on('click', function(e) {
  $('#changeSpaceSchedulePannel').addClass('hidden');
});


$('#addEquipmentButton').on('click', function(e) {
  $('#createEquipmentPannel').removeClass('hidden');
});

$('#cancelEquipmentSpaceButton').on('click', function(e) {
  $('#createEquipmentPannel').addClass('hidden');
});


$('#addEventButton').on('click', function(e) {
  $('#createEventPannel').removeClass('hidden');
});

$('#cancelCreateEventButton').on('click', function(e) {
  $('#createEventPannel').addClass('hidden');
});


$('#addSubscriptionButton').on('click', function(e) {
  $('#createSubscriptionPannel').removeClass('hidden');
});

$('#cancelSubscriptionButton').on('click', function(e) {
  $('#createSubscriptionPannel').addClass('hidden');
});


$('#cancelUpdateRightButton').on('click', function(e) {
  $('#updateRightPannel').addClass('hidden');
});


$('#subscribeAUserButton').on('click', function(e) {
  $('#subscribeAUserPannel').removeClass('hidden');
});


$('#cancelSubscribeAUser').on('click', function(e) {
  $('#subscribeAUserPannel').addClass('hidden');
});


var statusUserArray = ["Super administrateur", "Administrateur", "Employé", "Utilisateur"];
var spaceArray = [];
var serviceArray = [];
var statusTicketArray = ["Ouvert", "Nouveau", "En cours", "Résolue", "En attente", "En retard"];
var days = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];
var rightsArray = [];
//function JS
function createSpace() {
  var spaceId = document.getElementById('newSpaceId').value;
  var spaceName = document.getElementById('newSpaceName').value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        console.log(request.responseText);
        if (request.responseText != 'failure') {
          var createSpacePannel = document.getElementById('createSpacePannel');
          createSpacePannel.setAttribute('class', 'hidden');
          location.reload()
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createSpace.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'spaceId=' + spaceId,
    'spaceName=' + spaceName
  ];
  var body = params.join('&');
  request.send(body);

}



function updateSpace(idSpace) {
  var newNameSpace = document.getElementById(idSpace + 'NameSpace').value;
  var newSpace = document.getElementById(idSpace + 'isDeleted').checked;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateSpace.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idSpace=' + idSpace,
    'newNameSpace=' + newNameSpace,
    'newSpace=' + newSpace
  ];
  var body = params.join('&');
  request.send(body);
}

function createService() {

  var spaceId = getSpaceId()
  var serviceName = document.getElementById('newServiceName').value;
  var serviceCompInf = document.getElementById('newServiceCompInf').value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        if (request.responseText != 'failure') {

          var createSpacePannel = document.getElementById('createServicePannel');
          createSpacePannel.setAttribute('class', 'hidden');
          location.reload()
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createService.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'spaceId=' + spaceId,
    'serviceName=' + serviceName,
    'serviceCompInf=' + serviceCompInf
  ];
  var body = params.join('&');
  request.send(body);

}


function getSpaceId() {
  var select = document.getElementById('spaceSelector');
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var bookId = selectedOption.value;
  return bookId;
}



function displayCreateServicePannel(idSpace) {
  var select = document.getElementById('spaceSelector');
  var options = select.getElementsByTagName('option');
  var i = 0;
  for (; i < options.length; i++) {
    if (options[i].value == idSpace) {
      options[i].setAttribute('selected', 'selected');
    }
  }

  var pannel = document.getElementById('createServicePannel');
  createServicePannel.setAttribute('class', 'pannel');

}


function changeServiceType() {
  var serviceType = getServiceType();
  var serviceDiv = document.getElementById('servicesDiv');
  var serviceContentDiv = document.getElementById('serviceContentsDiv');
  if (serviceType == 1) {
    serviceDiv.setAttribute('class', '');
    serviceContentDiv.setAttribute('class', 'hidden');
  } else {
    serviceDiv.setAttribute('class', 'hidden');
    serviceContentDiv.setAttribute('class', '');
  }
}


function getServiceType() {
  var select = document.getElementById('serviceTypeSelector');
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var bookId = selectedOption.value;
  return bookId;
}


function createServiceContent() {

  var serviceId = getServiceId()
  var serviceContentName = document.getElementById('newServiceContentName').value;
  var newServiceContentInformation = document.getElementById('newServiceContentInformation').value;
  var availableNumber = document.getElementById('newServiceContentNumber').value


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        if (request.responseText != 'failure') {
          var createSpacePannel = document.getElementById('createServiceContentPannel');
          createSpacePannel.setAttribute('class', 'hidden');
          location.reload();
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createServiceContent.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'serviceId=' + serviceId,
    'serviceContentName=' + serviceContentName,
    'newServiceContentInformation=' + newServiceContentInformation,
    'availableNumber=' + availableNumber
  ];
  var body = params.join('&');
  request.send(body);

}



function getServiceId() {
  var select = document.getElementById('serviceSelector');
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var bookId = selectedOption.value;
  return bookId;
}


function updateService(idService) {
  var newServiceName = document.getElementById(idService + 'NameService').value;
  var newCompInfo = document.getElementById(idService + 'CompInfoService').value;
  var newSpaceId = getSpaceIdInService(idService);
  var newIsBookedService = document.getElementById(idService + 'IsBookedService').checked;
  var newIsDeletedService = document.getElementById(idService + 'IsDeletedService').checked;


  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateService.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'newServiceName=' + newServiceName,
    'newCompInfo=' + newCompInfo,
    'newSpaceId=' + newSpaceId,
    'newIsBookedService=' + newIsBookedService,
    'newIsDeletedService=' + newIsDeletedService,
    'idService=' + idService
  ];
  var body = params.join('&');
  request.send(body);
}


function getSpaceIdInService(idService) {
  var select = document.getElementById(idService + 'ServiceSpaceId');
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var spaceId = selectedOption.value;
  return spaceId;
}



function updateServiceContent(idServiceContent) {
  var newNameServiceContent = document.getElementById(idServiceContent + 'NameServiceContent').value;
  var newInformationServiceContent = document.getElementById(idServiceContent + 'InformationServiceContent').value;
  var newServiceId = getServiceIdInServiceContent(idServiceContent);
  var newIsFreeServiceContent = document.getElementById(idServiceContent + 'IsFreeServiceContent').value;
  var newIsDeletedServiceContent = document.getElementById(idServiceContent + 'IsDeletedServiceContent').checked;


  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateServiceContent.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'newNameServiceContent=' + newNameServiceContent,
    'newInformationServiceContent=' + newInformationServiceContent,
    'newServiceId=' + newServiceId,
    'newIsFreeServiceContent=' + newIsFreeServiceContent,
    'newIsDeletedServiceContent=' + newIsDeletedServiceContent,
    'idServiceContent=' + idServiceContent
  ];
  var body = params.join('&');
  request.send(body);
}


function getServiceIdInServiceContent(idServiceContent) {
  var select = document.getElementById(idServiceContent + 'ServiceContentServiceId');
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var serviceId = selectedOption.value;
  return serviceId;
}
/***************************************************
                      Tickets
****************************************************/
/*
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
	}*/


function changeTable() {

  var selectType = document.getElementById('tableSelect').value;
  var element = document.getElementById('databaseContainer');

  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      var test = request.responseText;
      var search = JSON.parse(request.responseText);
      element.innerHTML = "";

      if (selectType == "users") displayDatabaseUsers(element, search);
      else if (selectType == "spaces") displayDatabaseSpaces(element, search);
      else if (selectType == "services") displayDatabaseServices(element, search);
      else if (selectType == "service_content") displayDatabaseServiceContents(element, search);
      else return 0;
    }
  };
  if (selectType == "users") request.open("POST", 'ajaxFile\\getAllUsers.php');
  else if (selectType == "spaces") request.open("POST", 'ajaxFile\\getAllSpaces.php');
  else if (selectType == "services") request.open("POST", 'ajaxFile\\getAllServices.php');
  else if (selectType == "service_content") request.open("POST", 'ajaxFile\\getAllServiceContents.php');
  else return 0;
  request.send();
}


function updateUser(email) {
  var newEmail = document.getElementById(email + 'EmailDb').value;
  var lastname = document.getElementById(email + 'LastNameDb').value;
  var name = document.getElementById(email + 'NameDb').value;
  var status = getSelectedIndex(email + 'UserStatusDb');
  var isDeleted = document.getElementById(email + 'IsDeletedUserDb').checked;

  //console.log(newEmail+" "+lastname+" "+name+" "+status+" "+isDeleted+" ");

  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
      }
    }
  };
  request.open("POST", 'ajaxFile\\updateUser.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'email=' + email,
    'newEmail=' + newEmail,
    'lastname=' + lastname,
    'name=' + name,
    'status=' + status,
    'isDeleted=' + isDeleted
  ];
  var body = params.join('&');
  request.send(body);
}


function displayDatabaseUsers(element, array) {
  //console.log(array);
  //var button = '<tr><td><input type="text" id="searchEmailUserBdd"></td><td><input type="text" id="searchNameUserBdd"></td><td><input type="text" id="searchLastnameUserBdd"></td><td>Date inscription</td><td>Status</td><td>Supprimé</td><td><button class="btn btn-primary" onclick="sortUserDb()">Rechercher</button><td></tr>';
  var button = '';
  element.innerHTML += '<table class="table" id ="dbUsers">'+button+'<tr><th>Email</th><th>Nom</th><th>Prénom</th><th>Date inscription</th><th>Status</th><th>Supprimé</th><th>Valider les modifications<th></tr>';
  element.innerHTML += '</table>'
  var displayArray = document.getElementById('dbUsers');
  array.forEach(function(user) {
    var select = "<select id='" + user.email + "UserStatusDb'>";
    statusUserArray.forEach(function(statusUser) {
      select += "<option value='" + statusUserArray.indexOf(statusUser) + "'  " + (user.statusUser == statusUserArray.indexOf(statusUser) ? "selected" : "") + "  >" + statusUser + "</option>"
    });
    select += "</select>";

    displayArray.innerHTML += '<tr><td><input type="text" class="form-control" id="' + user.email + 'EmailDb" value="' + user.email + '"></td><td><input type="text" class="form-control" id="' + user.email + 'LastNameDb" value="' + user.lastName + '"></td><td><input type="text" class="form-control" id="' + user.email + 'NameDb" value="' + user.name + '"></td><td>' + user.dateSignup + '</td><td>' + select + '</td><td><input id="' + user.email + 'IsDeletedUserDb" type="checkbox" ' + (user.isDeleted == "1" ? "checked" : "") + '></td><td> <button class="btn btn-primary" onclick="updateUser(\'' + user.email + '\')">Valider </button> </td></tr>';

  });

}

function displayDatabaseSpaces(element, array) {
  element.innerHTML += '<table class="table" id="dbSpaces"><tbody><tr><th>Id de L\'espace</th><th>Nom de l\'espace</th><th>Désactiver l`\'espace</th><th>Valider les modifications</th></tr></table>';
  var displayArray = document.getElementById('dbSpaces');
  array.forEach(function(space) {
    displayArray.innerHTML += '<tr><td>' + space.idSpace + '</td><td><input type="text" class="form-control" id="' + space.idSpace + 'NameSpaceDb" value="' + space.name + '"></td><td> <input id="' + space.idSpace + 'isDeletedDb" type="checkbox" ' + (space.isDeleted == "1" ? "checked" : "") + '></td><td> <button class="btn btn-primary" onclick="updateSpaceDb(\'' + space.idSpace + '\')">Valider </button> </td></tr>';
  });
}


function updateSpaceDb(idSpace) {
  var newNameSpace = document.getElementById(idSpace + 'NameSpaceDb').value;
  var newSpace = document.getElementById(idSpace + 'isDeletedDb').checked;

  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };
  request.open("POST", 'ajaxFile\\updateSpace.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idSpace=' + idSpace,
    'newNameSpace=' + newNameSpace,
    'newSpace=' + newSpace
  ];
  var body = params.join('&');
  request.send(body);
}




function displayDatabaseServices(element, array) {
  element.innerHTML += '<table class="table" id ="dbServices"><tr><th>Nom du service général</th><th>Information complémentaire</th><th>Espace du service</th><th>Disponible</th><th>Supprimé</th><th>Valider les modifications</th></tr></table>';
  var displayArray = document.getElementById('dbServices');

  array.forEach(function(service) {
    var select = '<select id="' + service.idService + 'ServiceSpaceIdDb">';
    spaceArray.forEach(function(space) {
      select += "<option value='" + space.idSpace + "'   " + (service.idSpace == space.idSpace ? "selected" : "") + "    >" + space.name + "</option>"
    });
    select += "</select>";
    displayArray.innerHTML += '<tr><td><input type="text" class="form-control" id="' + service.idService + 'NameServiceDb" value="' + service.name + '"></td><td><textarea class="form-control compInfoTextArea" id="' + service.idService + 'CompInfoServiceDb">' + service.compInf + '</textarea></td><td>' + select + '</td><td><input id="' + service.idService + 'IsBookedServiceDb" type="checkbox" ' + (service.isBooked == "1" ? "checked" : "") + '></td><td><input id="' + service.idService + 'IsDeletedServiceDb" type="checkbox" ' + (service.isDeleted == "1" ? "checked" : "") + '></td><td> <button onclick="updateService(\'' + service.idService + '\')">Valider </button> </td></tr>';
  });
}

function initSpaceArray() {

  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      var test = request.responseText;
      var search = JSON.parse(request.responseText);
      spaceArray = search;
    }
  };
  request.open("POST", 'ajaxFile\\getAllSpaces.php');
  request.send();
}

function initServiceArray() {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      var test = request.responseText;
      var search = JSON.parse(request.responseText);
      serviceArray = search;
    }
  };
  request.open("POST", 'ajaxFile\\getAllServices.php');
  request.send();
}


function displayDatabaseServiceContents(element, array) {
  element.innerHTML += '<table class="table" id ="dbServiceContents"><tr><th>Nom du service</th><th>Information complémentaire</th><th>Service concerné</th><th>Disponible</th><th>Supprimé</th><th>Valider les modifications</th></tr></table>';
  var displayArray = document.getElementById('dbServiceContents');

  array.forEach(function(serviceContent) {
    var select = '<select id="' + serviceContent.idServiceContent + 'ServiceContentServiceIdDb">';
    serviceArray.forEach(function(service) {
      select += "<option value='" + service.idService + "'  " + (service.idService == serviceContent.idService ? "selected" : "") + "  >" + service.name + "</option>";
    });
    select += "</select>";

    displayArray.innerHTML += '<tr><td><input type="text" class="form-control" id="' + serviceContent.idServiceContent + 'NameServiceContentDb" value="' + serviceContent.name + '"></td><td><textarea class="form-control compInfoTextArea" id="' + serviceContent.idServiceContent + 'InformationServiceContentDb">' + serviceContent.information + '</textarea></td><td>' + select + '</td><td><input type="number" id="' + serviceContent.idServiceContent + 'IsFreeServiceContentDb" value="' + (serviceContent.isFree) + '"></td><td><input id="' + serviceContent.idServiceContent + 'IsDeletedServiceContentDb" type="checkbox" ' + (serviceContent.isDeleted == "1" ? "checked" : "") + '></td><td> <button onclick="updateServiceContent(\'' + serviceContent.idServiceContent + '\')">Valider </button> </td></tr>';
  });

}

function displayTicket(idTicket, email, statusTicket, idPrimaryTicket) {
  var request = new XMLHttpRequest();
  if (idPrimaryTicket != -1)
    idTicket = idPrimaryTicket;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      var test = request.responseText;
      //console.log(test);
      if (test != "NO VALUE") {
        var search = JSON.parse(request.responseText);
      }

      setTicketInformation(idTicket, email);
      setTicketAdvancedInfoHistorique(test, search);
      setTicketStatusSelect(statusTicket, idTicket);
      setSendTicketButton(idTicket, email, statusTicket, idPrimaryTicket);
    }
  };
  request.open("POST", 'ajaxFile\\getLinkedTicket.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")

  var params = [
    'idTicket=' + idTicket
  ];
  var body = params.join('&');
  request.send(body);
}

function setTicketInformation(idTicket, email) {
  var idDiv = document.getElementById('idTicketAdvancedInfo');
  var senderDiv = document.getElementById('emailSenderAdvancedInfo');
  idDiv.innerHTML = "ID : " + idTicket;
  senderDiv.innerHTML = "Correspondant :" + email;
}


function setTicketAdvancedInfoHistorique(test, search) {
  var ticketAdvancedInfo = document.getElementById('ticketAdvancedInfo');
  ticketAdvancedInfo.classList.remove('hidden');
  var ticketAdvancedInfoHistorique = document.getElementById('ticketAdvancedInfoHistorique');
  ticketAdvancedInfoHistorique.innerHTML ="";
  if(test!="NO VALUE"){
    search.forEach(function(ticket){
      ticketAdvancedInfoHistorique.innerHTML += '<div class="col-md-12"> <div class="ticketAdvancedMessage '+(ticket.ticketSenderStatus=="1"?"receiver":"sender")+'">'+ticket.contentTicket+'</div> </div>';
    });
  }
}

function setTicketStatusSelect(statusTicket, idTicket) {
  var select = document.getElementById('ticketStatusSelect');
  select.setAttribute('onchange', 'updateTicketStatus(' + idTicket + ')');
  select.innerHTML = "";
  statusTicketArray.forEach(function(status) {
    select.innerHTML += "<option value='" + statusTicketArray.indexOf(status) + "'  " + (statusTicket == statusTicketArray.indexOf(status) ? "selected" : "") + "  >" + status + "</option>";
  });

}

function setSendTicketButton(idTicket, email, statusTicket, idPrimaryTicket) {
  var button = document.getElementById('ticketSendingButton');
  button.setAttribute('onclick', "sendAnswer(" + idTicket + ",'" + email + "','"+statusTicket+"','"+idPrimaryTicket+"')");
}


function sendAnswer(idTicket, email, statusTicket, idPrimaryTicket) {
  var ticketCategory = "Administratif";
  var contentTicket = document.getElementById('ticketAnswer').value;

  //console.log(ticketCategory + email + contentTicket);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        displayTicket(idTicket, email, statusTicket, idPrimaryTicket);
      }
    }
  };


  request.open("POST", 'ajaxFile\\createTicketAnswer.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'ticketCategory=' + ticketCategory,
    'email=' + email,
    'contentTicket=' + contentTicket,
    'idPrimaryTicket=' + idPrimaryTicket
  ];
  var body = params.join('&');
  request.send(body);
}


function updateTicketStatus(idTicket) {
  var ticketStatus = getSelectedIndex('ticketStatusSelect');


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateTicketStatus.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idTicket=' + idTicket,
    'ticketStatus=' + ticketStatus
  ];
  var body = params.join('&');
  request.send(body);

}


function getSelectedIndex(selectId) {
  var select = document.getElementById(selectId);
  var idx = select.selectedIndex;
  var options = select.getElementsByTagName('option');
  var selectedOption = options[idx];
  var index = selectedOption.value;
  return index;
}



function displayChangeSchedule(idSpace){

  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        if( request.responseText !="erreur"){
          var search = JSON.parse(request.responseText);
          setSchedulePannel(search,idSpace);
        }

      }
    }
  };


  request.open("POST", 'ajaxFile\\getSpaceSchedule.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idSpace=' + idSpace
  ];
  var body = params.join('&');
  request.send(body);
}


function setSchedulePannel(search,idSpace){
  var pannel = document.getElementById('changeSpaceSchedulePannel');
  var updateButton = document.getElementById('updateScheduleButton');
  updateButton.setAttribute('onclick','updateScheduleSpace(\''+idSpace+'\')');
  search.forEach(function(day){
    var beginInput = document.getElementById('inputBegin'+day.jour);
    var endInput = document.getElementById('inputEnd'+day.jour);

    beginInput.value = day.debut;
    endInput.value = day.fin;
  });

  pannel.classList.remove('hidden');


}

function updateScheduleSpace(idSpace){
    //var arrayToBeJsonned = [];
    var arrayToBeJsonned = [];
    var debut;
    var fin;
    var schedule ;
    days.forEach(function(day){
       var dayElement = {debut : "Empty" , fin : "Empty" , jour : "Empty"};
       debut = document.getElementById('inputBegin'+day).value;
       fin = document.getElementById('inputEnd'+day).value;
       dayElement.debut = debut;
       dayElement.fin = fin;
       dayElement.jour = day;

       arrayToBeJsonned.push(dayElement);
       //arrayToBeJsonned[] += JSON.stringify(dayElement);
    });


    schedule = JSON.stringify(arrayToBeJsonned);


    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        if (request.status == 200) {

        }
      }
    };


    request.open("POST", 'ajaxFile\\updateSpaceSchedule.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    var params = [
      'idSpace=' + idSpace,
      'schedule=' + schedule
    ];
    var body = params.join('&');
    request.send(body);


}







function createEquipment() {
  var equipmentName = document.getElementById('newEquipmentName').value;
  var idSpace = getSelectedIndex('spaceSelectorEquipment');


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        if (request.responseText != 'Erreur à la création de l\'objet Equipment') {
          var createEquipmentPannel = document.getElementById('createEquipmentPannel');
          createEquipmentPannel.setAttribute('class', 'hidden');
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createEquipment.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'equipmentName=' + equipmentName,
    'idSpace=' + idSpace

  ];
  var body = params.join('&');
  request.send(body);

}


function updateEquipment(idEquipment) {
  var equipmentName = document.getElementById(idEquipment + 'NameEquipment').value;
  var isDeleted = document.getElementById(idEquipment + 'isDeletedEquipment').checked;
  var isFree = document.getElementById(idEquipment + 'isFreeEquipment').checked;
  var idSpace = getSelectedIndex(idEquipment+'IdSpaceEquipment');


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateEquipment.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'equipmentName=' + equipmentName,
    'isDeleted=' + isDeleted,
    'isFree=' + isFree,
    'idSpace=' + idSpace,
    'idEquipment=' + idEquipment
  ];
  var body = params.join('&');
  request.send(body);
}




function updateEquipmentLastDate(idEquipment) {


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

      }
    }
  };


  request.open("POST", 'ajaxFile\\updateEquipmentLastCheckDate.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idEquipment=' + idEquipment
  ];
  var body = params.join('&');
  request.send(body);
}





function createNewEvent() {
  var dateStart = document.getElementById('NewEventDateStart').value;
  var hourStart = document.getElementById('NewEventHourStart').value;
  var dateEnd = document.getElementById('NewEventDateEnd').value;
  var hourEnd = document.getElementById('NewEventHourEnd').value;

  var nameEvent = document.getElementById('NewNameEvent').value;
  var descriptionEvent = document.getElementById('NewDescriptionEvent').value;
  var idSpace = getSelectedIndex('spaceSelectorNewEvent');
  var start = dateStart+' '+hourStart;
  var end = dateEnd+' '+hourEnd;

  //console.log(nameEvent+' '+descriptionEvent+' '+start+' '+end+' '+idSpace);


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        if (request.responseText != 'Erreur à la création de l\'objet event') {
          var createEquipmentPannel = document.getElementById('createEquipmentPannel');
          createEquipmentPannel.setAttribute('class', 'hidden');
          location.reload()
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createNewEvent.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'nameEvent=' + nameEvent,
    'descriptionEvent=' + descriptionEvent,
    'idSpace=' + idSpace,
    'start=' + start,
    'end=' + end

  ];
  var body = params.join('&');
  request.send(body);

}



function updateEvent(idEvent) {
  var dateStart = document.getElementById(idEvent+'EventDateStart').value;
  var hourStart = document.getElementById(idEvent+'EventHourStart').value;
  var dateEnd = document.getElementById(idEvent+'EventDateEnd').value;
  var hourEnd = document.getElementById(idEvent+'EventHourEnd').value;

  var nameEvent = document.getElementById(idEvent+'NameEvent').value;
  var descriptionEvent = document.getElementById(idEvent+'DescriptionEvent').value;
  var isDeleted = document.getElementById(idEvent + 'isDeletedEvent').checked;


  var idSpace = getSelectedIndex(idEvent+'IdSpaceEvent');
  var start = dateStart+' '+hourStart;
  var end = dateEnd+' '+hourEnd;

  //console.log(nameEvent+' '+descriptionEvent+' '+start+' '+end+' '+idSpace);


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        /*
        if (request.responseText != 'Erreur à la création de l\'objet Equipment') {
          var createEquipmentPannel = document.getElementById('createEquipmentPannel');
          createEquipmentPannel.setAttribute('class', 'hidden');
        }*/
      }
    }
  };


  request.open("POST", 'ajaxFile\\updateEvent.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'nameEvent=' + nameEvent,
    'descriptionEvent=' + descriptionEvent,
    'idSpace=' + idSpace,
    'start=' + start,
    'end=' + end,
    'isDeleted=' + isDeleted,
    'idEvent=' + idEvent

  ];
  var body = params.join('&');
  request.send(body);

}





function createNewSubscription() {
  var monthly = document.getElementById('MonthlyNewSubscription').value;
  var dayPrice = document.getElementById('DayPriceNewSubscription').value;
  var firstHour = document.getElementById('FirstHourPriceNewSubscription').value;
  var halfHour = document.getElementById('HalfHourPricNeweSubscription').value;

  var name = document.getElementById('NameNewSubscription').value;




  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

        if (request.responseText != 'Fail') {
          var createEquipmentPannel = document.getElementById('createEquipmentPannel');
          createEquipmentPannel.setAttribute('class', 'hidden');
          location.reload();
        }else{

        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createNewSubscription.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'name=' + name,
    'monthly=' + monthly,
    'dayPrice=' + dayPrice,
    'firstHour=' + firstHour,
    'halfHour=' + halfHour

  ];
  var body = params.join('&');
  request.send(body);

}




function createNewSubscription() {
  var monthly = document.getElementById('MonthlyNewSubscription').value;
  var dayPrice = document.getElementById('DayPriceNewSubscription').value;
  var firstHour = document.getElementById('FirstHourPriceNewSubscription').value;
  var halfHour = document.getElementById('HalfHourPricNeweSubscription').value;

  var name = document.getElementById('NameNewSubscription').value;




  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

        if (request.responseText != 'Fail') {
          var createEquipmentPannel = document.getElementById('createEquipmentPannel');
          createEquipmentPannel.setAttribute('class', 'hidden');
          location.reload();
        }else{
          console.log('Fail');
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\createNewSubscription.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'name=' + name,
    'monthly=' + monthly,
    'dayPrice=' + dayPrice,
    'firstHour=' + firstHour,
    'halfHour=' + halfHour

  ];
  var body = params.join('&');
  request.send(body);

}





function updateSubscription(idSubscription) {
  var monthly = document.getElementById(idSubscription+'MonthlySubscription').value;
  var dayPrice = document.getElementById(idSubscription+'DayPriceSubscription').value;
  var firstHour = document.getElementById(idSubscription+'FirstHourPriceSubscription').value;
  var halfHour = document.getElementById(idSubscription+'HalfHourPriceSubscription').value;
  var isDeleted = document.getElementById(idSubscription + 'isDeletedSubscription').checked;

  var name = document.getElementById(idSubscription+'NameSubscription').value;


  console.log(name+' '+monthly+' '+dayPrice+' '+firstHour+' '+halfHour+' '+isDeleted);


  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {

        if (request.responseText == 'Success') {

        }else{
          console.log('Request failed');
        }
      }
    }
  };


  request.open("POST", 'ajaxFile\\updateSubscription.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var params = [
    'name=' + name,
    'monthly=' + monthly,
    'dayPrice=' + dayPrice,
    'firstHour=' + firstHour,
    'halfHour=' + halfHour,
    'idSubscription=' + idSubscription,
    'isDeleted=' + isDeleted


  ];
  var body = params.join('&');
  request.send(body);

}



function updateSubscriptionRightsButton(idSubscription){
  var pannel = document.getElementById('updateRightPannel');
  pannel.classList.remove('hidden');


  var request = new XMLHttpRequest();


  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        result = request.responseText
        search = JSON.parse(result);
        console.log(search);
        displayCheckbox(search);
        displayButton(idSubscription);
      }
    }
  };


  request.open("POST", 'ajaxFile\\getSubscription.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idSubscription=' + idSubscription
  ];
  request.send(params);


}


function displayCheckbox(search){
  var displayCheckboxDiv = document.getElementById('displayRightCheckboxDiv');
  displayCheckboxDiv.innerHTML = "";
  var isPresent = false;



  rightsArray.forEach(function(globalRight){
    Object.keys(search).forEach(function(key){
      if(key == globalRight)
        isPresent=true;
    });
    displayCheckboxDiv.innerHTML +=  '<div class="row"> <input  class="rightCheckbox" id="'+globalRight+'Checkbox" type="checkbox" '+(isPresent?'checked':'')+'> <div> '+globalRight+'</div> </div><br>';
    isPresent=false;
  });

}

function displayButton(idSubscription){
  var addRightButton = document.getElementById('addRightButton');
  var updateRightButton = document.getElementById('updateRightButton');

  addRightButton.setAttribute('onclick','addRight()');
  updateRightButton.setAttribute('onclick','updateRightSubscription('+idSubscription+')');
}


function getAllRight(idSubscription){

  var request = new XMLHttpRequest();


  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        result = request.responseText
        search = JSON.parse(result);
        console.log(search);
        rightsArray = search;
      }
    }
  };


  request.open("POST", 'ajaxFile\\getAllRights.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
  ];
  request.send();
}


function updateRightSubscription(idSubscription){
  var arrayToBeJsonned = {};
  var tempCheckbox;

  rightsArray.forEach(function(right){
    tempCheckbox = document.getElementById(right+'Checkbox').checked
    if( tempCheckbox ){
      arrayToBeJsonned[right] = 1;
    }
  });
  var stringParam = JSON.stringify(arrayToBeJsonned);

  var request = new XMLHttpRequest();


  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        test = request.responseText;
        console.log(test);
      }
    }
  };


  request.open("POST", 'ajaxFile\\updateSubscriptionRights.php');
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  var params = [
    'idSubscription='+idSubscription,
    'right='+stringParam
  ];
  var body = params.join('&');

  request.send(body);
}


function addRight(){
  var newRightName = document.getElementById('newRightName').value;
  var displayCheckboxDiv = document.getElementById('displayRightCheckboxDiv');

  rightsArray.push(newRightName);
  displayCheckboxDiv.innerHTML +=  '<div class="row"> <input class="rightCheckbox" id="'+newRightName+'Checkbox" type="checkbox" >  <div >'+newRightName+' </div> </div><br>';


}



function subscribeAUser() {
  var subscribeAUserDateBegin = document.getElementById('subscribeAUserDateBegin').value;
  var subscribeAUserDateEnd = document.getElementById('subscribeAUserDateEnd').value;
  var email  = getSelectedIndex("subscribeAUserSelectUser");
  var idSubscription  = getSelectedIndex("subscribeAUserSelectSubscription");

//console.log(subscribeAUserDateBegin+' '+subscribeAUserDateEnd+' '+email+' '+idSubscription);
  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        console.log(request.responseText);
        if (request.responseText != 'failure') {
          var createSpacePannel = document.getElementById('createSpacePannel');
          createSpacePannel.setAttribute('class', 'hidden');
          location.reload()
        }
      }
    }
  };


    request.open("POST", 'ajaxFile\\subscribeAUser.php');
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    var params = [
      'email='+email,
      'idSubscription='+idSubscription,
      'subscribeAUserDateEnd='+subscribeAUserDateEnd,
      'subscribeAUserDateBegin='+subscribeAUserDateBegin
    ];
    var body = params.join('&');

    request.send(body);

}
