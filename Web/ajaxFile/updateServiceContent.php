<?php
session_start();
require "../function.php";
require "../object/serviceContents.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==6 && isset($_POST["newNameServiceContent"])//
  && isset( $_POST["newInformationServiceContent"])//
  && isset( $_POST["newServiceId"])//
  && isset( $_POST["newIsFreeServiceContent"])//
  && isset( $_POST["newIsDeletedServiceContent"])//
  && isset( $_POST["idServiceContent"]) ){
    $db=connectDb();
    $serviceContent = new ServiceContent(null);


    $error = false;
    $listOfErrors = [];
    if($serviceContent->idService( $_POST["newServiceId"]))
      $error=true;


    if($serviceContent->isFree(  $_POST["newIsFreeServiceContent"]   ) )
      $error = true;


    if($serviceContent->isDeleted(  ($_POST["newIsDeletedServiceContent"]== "true"?1:0)   ) )
      $error = true;


    if($serviceContent->idServiceContent( $_POST["idServiceContent"] ))
      $error = true;

    if($serviceContent->informationServiceContent($_POST["newInformationServiceContent"]  ))
      $error = true;

    if($serviceContent->nameServiceContent( $_POST["newNameServiceContent"]))
      $error = true;

    if($error){
      $_SESSION["errorServiceContentUpdateForm"] = $serviceContent->listOfErrors;
      print_r($_SESSION["errorServiceContentUpdateForm"]);
    }else{
      $serviceContentMng = new ServiceContentMng($db);
      $serviceContentMng->updateServiceContent($_POST["idServiceContent"],$serviceContent);
    }

  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
