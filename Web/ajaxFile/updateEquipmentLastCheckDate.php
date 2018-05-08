<?php
session_start();
date_default_timezone_set('Europe/Paris');

require "../function.php";
require "../object/equipment.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==1 && isset($_POST["idEquipment"]) ){
    $db=connectDb();
    $equipment = new Equipment(null);
    $error = false;

    if($equipment->idEquipment( $_POST["idEquipment"] ))
      $error = true;

    if($error){
      echo "Erreur à la création de l'objet Equipment";

    }else{
      $equipmentMng = new EquipmentMng($db);
      $equipmentMng->updateLastCheckDate($equipment);
      echo "OK";
    }

  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
