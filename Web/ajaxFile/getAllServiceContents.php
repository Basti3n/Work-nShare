<?php
  session_start();
  require "../function.php";
  require "../object/serviceContents.php";

  header('content-type: application/json');
  $db = connectDb();
  $serviceContentMng = new ServiceContentMng($db);
  $serviceContents = $serviceContentMng->getAllServiceContents();
  $serviceContentsArray = [];
  $tempArray = ["idServiceContent"=>-1,
                "information"=>"empty",
                "name"=>"empty",
                "isFree"=>-1,
                "isDeleted"=>-1,
                "idService"=>-1
              ];
  foreach ($serviceContents as $serviceContent) {
    $tempArray["idServiceContent"] = $serviceContent->idServiceContent();
    $tempArray["information"] = utf8_encode($serviceContent->informationServiceContent());
    $tempArray["name"] = utf8_encode($serviceContent->nameServiceContent());
    $tempArray["isFree"] = $serviceContent->isFree();
    $tempArray["isDeleted"] = $serviceContent->isDeleted();
    $tempArray["idService"] = $serviceContent->idService();

    array_push($serviceContentsArray, $tempArray );
  }
  //showArray($servicesArray);
  echo json_encode($serviceContentsArray);
