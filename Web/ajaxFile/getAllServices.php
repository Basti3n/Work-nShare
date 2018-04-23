<?php
  session_start();
  require "../function.php";
  require "../object/services.php";

  header('content-type: application/json');
  $db = connectDb();
  $serviceMng = new ServiceMng($db);
  $services = $serviceMng->getAllServices();
  $servicesArray = [];
  $tempArray = ["idService"=>-1,
                "name"=>"empty",
                "compInf"=>"empty",
                "space"=>"empty",
                "available"=>0,
                "isDeleted"=>-1
              ];
  foreach ($services as $service) {
    $tempArray["idService"] = $service->idService();
    $tempArray["name"] = utf8_encode($service->nameOfService());
    $tempArray["compInf"] = utf8_encode($service->compInfo());
    $tempArray["idSpace"] = utf8_encode($service->idSpace());
    $tempArray["isBooked"] = $service->isBooked();
    $tempArray["isDeleted"] = $service->isDeleted();

    array_push($servicesArray, $tempArray );
  }
  //showArray($servicesArray);
  echo json_encode($servicesArray);
