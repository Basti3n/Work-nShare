<?php
session_start();
require "../function.php";
require "../object/services.php";

if(isAdmin() || isSuperAdmin()){
      showArray($_POST);
  if( count($_POST)==3 && isset($_POST["spaceId"]) && isset( $_POST["serviceName"])  && isset( $_POST["serviceCompInf"])){
    $db=connectDb();
    $service = new Service(null);

    $error = false;
    $listOfErrors = [];
    if($service->idSpace($_POST["spaceId"]))
      $error = true;

    if($service->nameOfService($_POST["serviceName"]))
      $error = true;

    if($service->compInfo($_POST["serviceCompInf"]))
      $error = true;

    if($error){
      echo "failure";
    }else{
      $serviceMng = new ServiceMng($db);
      $serviceMng->add($service);
    }


  }else{
    echo "failure";
  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page";
}
