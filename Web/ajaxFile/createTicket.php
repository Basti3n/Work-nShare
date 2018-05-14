<?php
session_start();
require "../function.php";
require "../object/ticket.php";
require "../object/user.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==5 && isset($_POST["ticketCategory"]) && isset( $_POST["emailToSave"])
    && isset( $_POST["contentTicket"])  && isset( $_POST["idPrimaryTicket"])  && isset( $_POST["idEquipment"])  ){
    $db=connectDb();
    $ticket = new Ticket(null);

    $error = false;
    $listOfErrors = [];
    if($ticket->email($_POST["emailToSave"]))
      $error = true;

    if($ticket->contentTicket($_POST["contentTicket"] ))
      $error = true;

    if($ticket->ticketCategory($_POST["ticketCategory"]))
      $error = true;

    if( $ticket->ticketSenderStatus(0) )
      $error = true;

    if($ticket->idPrimaryTicket($_POST["idPrimaryTicket"]))
      $error = true;

    if($ticket->idEquipment($_POST["idEquipment"]))
      $error = true;

    if($error){
      $_SESSION["errorSpaceForm"] = $space->listOfErrors;
      print_r($_SESSION["errorSpaceForm"]);
    }else{
      $ticketMng = new TicketMng($db);
      $ticketMng->add($ticket);
      echo "OK";
    }

  }


  /* echo $_POST["spaceId"];
   echo $_POST["spaceName"];
   echo 'L\'espace a été ajouté';*/
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
