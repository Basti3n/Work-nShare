<?php
session_start();
require "../function.php";
require "../object/ticket.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==2 && isset($_POST["idTicket"]) && isset( $_POST["ticketStatus"])  ){
    $db=connectDb();
    $ticketMng = new TicketMng($db);
    $ticketMng->updateTicketStatus($_POST["idTicket"] ,  $_POST["ticketStatus"]);
    echo "OK";
  }
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
