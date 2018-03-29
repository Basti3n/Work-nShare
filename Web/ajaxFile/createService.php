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
    if($service->IdSpace($_POST["spaceId"]))
      $error = true;

    if($service->NameOfService($_POST["serviceName"]))
      $error = true;

    if($service->CompInfo($_POST["serviceCompInf"]))
      $error = true;

    if($error){
      $_SESSION["errorServiceForm"] = $service->listOfErrors;
      print_r($_SESSION["errorSpaceForm"]);
    }else{
      $serviceMng = new ServiceMng($db);
      $serviceMng->add($service);
    }
    echo "Ok";

  }


  /* echo $_POST["spaceId"];
   echo $_POST["spaceName"];
   echo 'L\'espace a été ajouté';*/
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
