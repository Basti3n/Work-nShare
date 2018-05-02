<?php
session_start();
require "../function.php";
require "../object/spaces.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==2 && isset($_POST["idSpace"]) && isset( $_POST["schedule"])  ){
    $db=connectDb();
    $spaceMng = new SpaceMng($db);
    //showArray($_POST["schedule"]);
    $spaceMng->updateSpaceSchedule($_POST["idSpace"] ,  $_POST["schedule"]);
    echo "OK";
  }else{
    echo "not ok";
  }
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
