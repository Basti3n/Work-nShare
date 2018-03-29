<?php
session_start();
require "../function.php";
require "../object/serviceContents.php";

if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==4 && isset($_POST["serviceId"]) && isset( $_POST["serviceContentName"])  && isset( $_POST["newServiceContentInformation"]) && isset( $_POST["availableNumber"]) ){
    $db=connectDb();
    $serviceContent = new ServiceContent(null);

    $error = false;
    $listOfErrors = [];
    if($serviceContent->IdService($_POST["serviceId"]))
      $error = true;

    if($serviceContent->NameServiceContent($_POST["serviceContentName"]))
      $error = true;

    if($serviceContent->InformationServiceContent($_POST["newServiceContentInformation"]))
      $error = true;

    if($serviceContent->isFree($_POST["availableNumber"]))
      $error = true;

    if($error){
      echo "not ok";
      $_SESSION["errorServiceContentForm"] = $service->listOfErrors;
      //print_r($_SESSION["errorSpaceContentForm"]);
    }else{
      $serviceContentMng = new ServiceContentMng($db);
      $serviceContentMng->add($serviceContent);
      echo "ok";
    }

  }


  /* echo $_POST["spaceId"];
   echo $_POST["spaceName"];
   echo 'L\'espace a été ajouté';*/
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
