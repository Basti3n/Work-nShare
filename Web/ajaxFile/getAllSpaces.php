<?php
  session_start();
  require "../function.php";
  require "../object/spaces.php";

  header('content-type: application/json');
  $db = connectDb();
  $spaceMng = new SpaceMng($db);
  $spaces = $spaceMng->getAllSpaces();
  $spacesArray = [];
  $tempArray = ["idSpace"=>"empty",
                "name"=>"empty",
                "isDeleted"=>-1
              ];
  foreach ($spaces as $space) {

    $tempArray["idSpace"] = $space->idSpace();
    $tempArray["name"] = $space->nameOfSpace();
    $tempArray["isDeleted"] = $space->isDeleted();

    array_push($spacesArray, $tempArray );
  }
  //showArray($spacesArray);
  echo json_encode($spacesArray);
