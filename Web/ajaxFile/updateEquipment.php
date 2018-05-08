<?php
session_start();
date_default_timezone_set('Europe/Paris');

require "../function.php";
require "../object/equipment.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==5 && isset($_POST["idEquipment"]) && isset( $_POST["equipmentName"])
                      && isset( $_POST["isDeleted"])  && isset( $_POST["isFree"])  && isset( $_POST["idSpace"])){
    $db=connectDb();
    $equipment = new Equipment(null);

    $error = false;
    $listOfErrors = [];

    if($equipment->idEquipment( $_POST["idEquipment"] ))
      $error = true;

    if($equipment->idSpace($_POST["idSpace"]))
      $error = true;

    if($equipment->equipmentName($_POST["equipmentName"]))
      $error = true;

    if( $equipment->isDeleted( ($_POST["isDeleted"]== "true"?1:0) ) )
      $error = true;


    if ($equipment->isFree( ($_POST["isFree"]== "true"?1:0) ) )
      $error = true;


    if($error){
      echo "Erreur à la création de l'objet Equipment";

    }else{
      $equipmentMng = new EquipmentMng($db);
      $equipmentMng->update($equipment);
      echo "OK";
    }

  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
