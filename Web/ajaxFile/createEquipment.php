<?php
session_start();
date_default_timezone_set('Europe/Paris');

require "../function.php";
require "../object/equipment.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==2 && isset($_POST["idSpace"]) && isset( $_POST["equipmentName"])  ){
    $db=connectDb();
    $equipment = new Equipment(null);

    $error = false;
    $listOfErrors = [];
    if($equipment->idSpace($_POST["idSpace"]))
      $error = true;

    if($equipment->equipmentName($_POST["equipmentName"]))
      $error = true;

    if( $equipment->isDeleted(0) )
      $error = true;


    if ($equipment->isFree(1) )
      $error = true;


    if($error){
      echo "Erreur à la création de l'objet Equipment";

    }else{
      $equipmentMng = new EquipmentMng($db);
      $equipmentMng->add($equipment);
    }

  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
