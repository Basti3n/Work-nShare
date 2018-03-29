<?php
session_start();
require "../function.php";
require "../object/spaces.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==2 && isset($_POST["spaceId"]) && isset( $_POST["spaceName"])  ){
    $db=connectDb();
    $space = new Space(null);

    $error = false;
    $listOfErrors = [];
    if($space->IdSpace($_POST["spaceId"]))
      $error = true;

    if($space->NameOfSpace($_POST["spaceName"]))
      $error = true;

    if($error){
      $_SESSION["errorSpaceForm"] = $space->listOfErrors;
      print_r($_SESSION["errorSpaceForm"]);
    }else{
      $spaceMng = new SpaceMng($db);
    //  $spaceMng->add($space);
    }

    echo "Ok";
  }


  /* echo $_POST["spaceId"];
   echo $_POST["spaceName"];
   echo 'L\'espace a été ajouté';*/
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
