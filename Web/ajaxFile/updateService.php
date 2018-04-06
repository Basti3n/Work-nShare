<?php
session_start();
require "../function.php";
require "../object/services.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==6 && isset($_POST["newServiceName"])
  && isset( $_POST["newCompInfo"])
  && isset( $_POST["newSpaceId"])
  && isset( $_POST["newIsBookedService"])
  && isset( $_POST["newIsDeletedService"])
  && isset( $_POST["idService"]) ){
    $db=connectDb();
    $service = new Service(null);


    $error = false;
    $listOfErrors = [];
    if($service->idService( $_POST["idService"]))
      $error=true;


    if($service->isBooked(  ($_POST["newIsBookedService"]== "true"?1:0)   ) )
      $error = true;


    if($service->isDeleted(  ($_POST["newIsDeletedService"]== "true"?1:0)   ) )
      $error = true;


    if($service->idSpace( $_POST["newSpaceId"] ))
      $error = true;

    if($service->compInfo($_POST["newCompInfo"]  ))
      $error = true;

    if($service->nameOfService( $_POST["newServiceName"]))
      $error = true;

    if($error){
      $_SESSION["errorServiceUpdateForm"] = $service->listOfErrors;
      print_r($_SESSION["errorSpaceForm"]);
    }else{
      $serviceMng = new ServiceMng($db);
      $serviceMng->updateService($_POST["idService"],$service);
    }

  }


  /* echo $_POST["spaceId"];
   echo $_POST["spaceName"];
   echo 'L\'espace a été ajouté';*/

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
