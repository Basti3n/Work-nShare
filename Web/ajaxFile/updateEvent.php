<?php
session_start();
require "../function.php";
require "../object/event.php";

if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==7 && isset($_POST["nameEvent"]) && isset( $_POST["descriptionEvent"])  && isset( $_POST["idSpace"])
                       && isset( $_POST["start"])  && isset( $_POST["end"])
                       && isset( $_POST["isDeleted"])  && isset( $_POST["idEvent"])){
    $db=connectDb();
    $event = new Event(null);

    $error = false;
    $listOfErrors = [];
    if($event->nameEvent($_POST["nameEvent"]))
      $error = true;

    if($event->descriptionEvent($_POST["descriptionEvent"]))
      $error = true;

    if($event->idSpace($_POST["idSpace"]))
      $error = true;

    if($event->datetimeStart($_POST["start"]))
      $error = true;

    if($event->datetimeEnd($_POST["end"]))
      $error = true;

    if($event->isDeleted(  ($_POST["isDeleted"]== "true"?1:0)    ))
      $error = true;


    if($event->idEvent($_POST["idEvent"]))
      $error = true;

    if($error){
      echo "Erreur à la création de l'objet event";
    }else{
      $eventMng = new EventMng($db);
      $eventMng->update($event);
      echo "Here I am";
    }
    echo "Ok";

  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
