<?php
  session_start();
  require "../function.php";
  require "../object/spaces.php";

  if(isAdmin() || isSuperAdmin()){
    header('content-type: application/json');
    $db = connectDb();
    $spaceMng = new SpaceMng($db);
    $schedule = $spaceMng->getSchedule($_POST["idSpace"]);
    //showArray($servicesArray);
    if($schedule!=1){
      echo $schedule[0]["HORAIRE"];
    }else {
      echo "erreur";
    }

  }else{
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
  }
