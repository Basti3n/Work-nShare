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
    if($serviceContent->idService($_POST["serviceId"]))
      $error = true;

    if($serviceContent->nameServiceContent($_POST["serviceContentName"]))
      $error = true;

    if($serviceContent->informationServiceContent($_POST["newServiceContentInformation"]))
      $error = true;

    if($serviceContent->isFree($_POST["availableNumber"]))
      $error = true;

    if($error){
      echo "failure";
    }else{
      $serviceContentMng = new ServiceContentMng($db);
      $serviceContentMng->add($serviceContent);
      echo "ok";
    }

  }else{
    echo "failure";

  }
}else{
echo "Vous n'êtes pas autorisé à accéder à cette page";
}
