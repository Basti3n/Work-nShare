<?php
session_start();
require "../function.php";
require "../object/ticket.php";
require "../object/user.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==3 && isset($_POST["ticketCategory"]) && isset( $_POST["emailToSave"])
    && isset( $_POST["contentTicket"]) ){
    $db=connectDb();
    $ticket = new Ticket(null);

    $error = false;
    $listOfErrors = [];
    echo $_POST["emailToSave"];
    if($ticket->email($_POST["emailToSave"]))
      $error = true;

    if($ticket->contentTicket($_POST["contentTicket"]))
      $error = true;

    if($ticket->ticketCategory($_POST["ticketCategory"]))
      $error = true;

    if( $ticket->ticketSenderStatus(0) )
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