
//Jquery
$( document ).ready(function() {
    $('#list-tab a[href="#general"]').tab('show');
});

$('.list-group a').click(function() {
      $(this).siblings('a').removeClass('active');
      $(this).addClass('active');
  });

/*
$('#list-tab a[href="#services"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#events"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#spaces"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#database"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#list-tab a[href="#tickets"]').on('click', function (e) {
  e.preventDefault();
  $(this).tab('show');
});
*/

$('#addSpaceButton').on('click', function (e){
  $('#createSpacePannel').removeClass('hidden');
})

$('#cancelCreateSpaceButton').on('click', function (e){
  $('#createSpacePannel').addClass('hidden');
})

$('#addServiceButton').on('click', function (e){
  $('#createServicePannel').removeClass('hidden');
})

$('#cancelCreateServiceButton').on('click', function (e){
  $('#createServicePannel').addClass('hidden');
})

$('#addServiceContentButton').on('click', function (e){
  $('#createServiceContentPannel').removeClass('hidden');
})

$('#cancelCreateServiceContentButton').on('click', function (e){
  $('#createServiceContentPannel').addClass('hidden');
})




//function JS
function createSpace(){
	var spaceId = document.getElementById('newSpaceId').value;
	var spaceName = document.getElementById('newSpaceName').value;

	var request = new XMLHttpRequest();

	request.onreadystatechange =function(){
	  if(request.readyState == 4){
	    if(request.status ==200){
	    	  console.log(request.responseText);
          if(request.responseText != 'failure'){
            var createSpacePannel = document.getElementById('createSpacePannel');
            createSpacePannel.setAttribute('class','hidden');
            //updateSpaceArray(spaceId,spaceName);
            //updateArraySelector in create Service
          }
	    }
	  }
	};


	request.open("POST",'ajaxFile\\createSpace.php');
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	var params = [
		'spaceId='+spaceId,
		'spaceName='+spaceName
	];
	var body = params.join('&');
	request.send(body);

}

function updateSpaceArray(spaceId,spaceName){
  var array = document.getElementById('spaceArray');
  console.log(array);
  var row = document.createElement('tr');
  array.appendChild(row);

  var idSpaceCell = document.createElement('td');
  idSpaceCell.innerHTML = spaceId;
  row.appendChild(idSpaceCell);

  var nameSpaceCell = document.createElement('td');
  nameSpaceCell.innerHTML = spaceName;
  row.appendChild(nameSpaceCell);

  var addServiceButtonCell = document.createElement('td');
  row.appendChild(addServiceButtonCell);

  var addServiceButton = document.createElement('button');
  addServiceButton.value="Ajouter un service";
  addServiceButton.onclick="";
  addServiceButtonCell.appendChild(addServiceButton);

  var addEventButtonCell = document.createElement('td');
  row.appendChild(addEventButtonCell);

  var addEventButton = document.createElement('button');
  addEventButton.value="Ajouter un évènement";
  addEventButton.onclick="";
  addServiceButtonCell.appendChild(addEventButton);

  var isDeletedCell = document.createElement('td');
  idSpaceCell.innerHTML = '0';
  row.appendChild(isDeletedCell);

}


function updateSpace(idSpace){
    var newNameSpace = document.getElementById(idSpace+'NameSpace').value;
    var newSpace = document.getElementById(idSpace+'isDeleted').checked;

    var request = new XMLHttpRequest();

  	request.onreadystatechange =function(){
  	  if(request.readyState == 4){
  	    if(request.status ==200){
  	    	  console.log(request.responseText);

  	    }
  	  }
  	};


  	request.open("POST",'ajaxFile\\updateSpace.php');
  	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
  	var params = [
  		'idSpace='+idSpace,
  		'newNameSpace='+newNameSpace,
      'newSpace='+newSpace
  	];
  	var body = params.join('&');
  	request.send(body);
}

function createService(){

	var spaceId = getSpaceId()
	var serviceName = document.getElementById('newServiceName').value;
  var serviceCompInf = document.getElementById('newServiceCompInf').value;

	var request = new XMLHttpRequest();

	request.onreadystatechange =function(){
	  if(request.readyState == 4){
	    if(request.status ==200){
	    	  console.log(request.responseText);
          if(request.responseText != 'failure'){

            var createSpacePannel = document.getElementById('createServicePannel');
            createSpacePannel.setAttribute('class','hidden');
          }
	    }
	  }
	};


	request.open("POST",'ajaxFile\\createService.php');
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	var params = [
		'spaceId='+spaceId,
		'serviceName='+serviceName,
    'serviceCompInf='+serviceCompInf
	];
	var body = params.join('&');
	request.send(body);

}


function getSpaceId(){
	var select = document.getElementById('spaceSelector');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var bookId = selectedOption.value;
	return bookId;
}



function displayCreateServicePannel(idSpace){
  var select = document.getElementById('spaceSelector');
  var options = select.getElementsByTagName('option');
  var i = 0;
  for(;i<options.length ;i++){
    if(options[i].value==idSpace){
      options[i].setAttribute('selected','selected');
    }
  }

  var pannel = document.getElementById('createServicePannel');
  createServicePannel.setAttribute('class','pannel');

}


function changeServiceType(){
  var serviceType = getServiceType();
  var serviceDiv = document.getElementById('servicesDiv');
  var serviceContentDiv = document.getElementById('serviceContentsDiv');
  if(serviceType== 1){
    serviceDiv.setAttribute('class','');
    serviceContentDiv.setAttribute('class','hidden');
  }else{
    serviceDiv.setAttribute('class','hidden');
    serviceContentDiv.setAttribute('class','');
  }
}


function getServiceType(){
	var select = document.getElementById('serviceTypeSelector');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var bookId = selectedOption.value;
	return bookId;
}


function createServiceContent(){

	var serviceId = getServiceId()
	var serviceContentName = document.getElementById('newServiceContentName').value;
  var newServiceContentInformation = document.getElementById('newServiceContentInformation').value;
  var availableNumber = document.getElementById('newServiceContentNumber').value


	var request = new XMLHttpRequest();

	request.onreadystatechange =function(){
	  if(request.readyState == 4){
	    if(request.status ==200){
	    	  console.log(request.responseText);
          if(request.responseText != 'failure'){
            var createSpacePannel = document.getElementById('createServiceContentPannel');
            createSpacePannel.setAttribute('class','hidden');
          }
	    }
	  }
	};


	request.open("POST",'ajaxFile\\createServiceContent.php');
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	var params = [
		'serviceId='+serviceId,
		'serviceContentName='+serviceContentName,
    'newServiceContentInformation='+newServiceContentInformation,
    'availableNumber='+availableNumber
	];
	var body = params.join('&');
	request.send(body);

}



function getServiceId(){
	var select = document.getElementById('serviceSelector');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var bookId = selectedOption.value;
	return bookId;
}


function updateService(idService){
    var newServiceName = document.getElementById(idService+'NameService').value;
    var newCompInfo = document.getElementById(idService+'CompInfoService').value;
    var newSpaceId = getSpaceIdInService(idService);
    var newIsBookedService = document.getElementById(idService+'IsBookedService').checked;
    var newIsDeletedService = document.getElementById(idService+'IsDeletedService').checked;

/*
    console.log(newServiceName);
    console.log(newCompInfo);
    console.log(newSpaceId);
    console.log(newIsBookedService);
    console.log(newIsDeletedService);
*/

    var request = new XMLHttpRequest();
  	request.onreadystatechange =function(){
  	  if(request.readyState == 4){
  	    if(request.status ==200){
  	    	  console.log(request.responseText);

  	    }
  	  }
  	};


  	request.open("POST",'ajaxFile\\updateService.php');
  	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
  	var params = [
  		'newServiceName='+newServiceName,
  		'newCompInfo='+newCompInfo,
      'newSpaceId='+newSpaceId,
      'newIsBookedService='+newIsBookedService,
      'newIsDeletedService='+newIsDeletedService,
      'idService='+idService
  	];
  	var body = params.join('&');
  	request.send(body);
}


function getSpaceIdInService(idService){
	var select = document.getElementById(idService+'ServiceSpaceId');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var spaceId = selectedOption.value;
	return spaceId;
}



function updateServiceContent(idServiceContent){
    var newNameServiceContent = document.getElementById(idServiceContent+'NameServiceContent').value;
    var newInformationServiceContent = document.getElementById(idServiceContent+'InformationServiceContent').value;
    var newServiceId = getServiceIdInServiceContent(idServiceContent);
    var newIsFreeServiceContent = document.getElementById(idServiceContent+'IsFreeServiceContent').value;
    var newIsDeletedServiceContent = document.getElementById(idServiceContent+'IsDeletedServiceContent').checked;


    console.log(newNameServiceContent);
    console.log(newInformationServiceContent);
    console.log(newServiceId);
    console.log(newIsFreeServiceContent);
    console.log(newIsDeletedServiceContent);


    var request = new XMLHttpRequest();
  	request.onreadystatechange =function(){
  	  if(request.readyState == 4){
  	    if(request.status ==200){
  	    	  console.log(request.responseText);

  	    }
  	  }
  	};


  	request.open("POST",'ajaxFile\\updateServiceContent.php');
  	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
  	var params = [
  		'newNameServiceContent='+newNameServiceContent,
  		'newInformationServiceContent='+newInformationServiceContent,
      'newServiceId='+newServiceId,
      'newIsFreeServiceContent='+newIsFreeServiceContent,
      'newIsDeletedServiceContent='+newIsDeletedServiceContent,
      'idServiceContent='+idServiceContent
  	];
  	var body = params.join('&');
  	request.send(body);
}


function getServiceIdInServiceContent(idServiceContent){
	var select = document.getElementById(idServiceContent+'ServiceContentServiceId');
	var idx=select.selectedIndex;
	var options = select.getElementsByTagName('option');
	var selectedOption = options[idx];
	var serviceId = selectedOption.value;
	return serviceId;
}
