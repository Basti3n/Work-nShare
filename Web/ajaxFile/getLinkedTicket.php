<?php
  session_start();
  require "../function.php";
  require "../object/ticket.php";
  if(isAdmin() || isSuperAdmin()){
    if( count($_POST)==1 && isset($_POST["idTicket"]) ){
      header('content-type: application/json');
      $db = connectDb();
      $ticketMng = new TicketMng($db);
      $tickets = $ticketMng->getAllTickets($_POST["idTicket"]);
      $originalTicker = $ticketMng->get($_POST["idTicket"]);
      $ticketsArray = [];
      $tempArray = ["contentTicket"=>"empty",
                    "statusTicket"=>"empty",
                    "email"=>"empty",
                    "ticketCategory"=>0,
                    "idEquipment"=>-1,
                    "idPrimaryTicket"=>-1,
                    "dateTicket"=>-1,
                    "ticketSenderStatus"=>-1
                  ];

      $tempArray["idTicket"] = $originalTicker->idTicket();
      $tempArray["contentTicket"] = utf8_encode($originalTicker->contentTicket());
      $tempArray["statusTicket"] = $originalTicker->statusTicket();
      $tempArray["email"] = utf8_encode($originalTicker->email());
      $tempArray["ticketCategory"] = utf8_encode($originalTicker->ticketCategory());
      $tempArray["idEquipment"] = $originalTicker->idEquipment();
      $tempArray["idPrimaryTicket"] = $originalTicker->idPrimaryTicket();
      $tempArray["dateTicket"] = $originalTicker->dateTicket();
      $tempArray["ticketSenderStatus"] = $originalTicker->ticketSenderStatus();
      array_push($ticketsArray, $tempArray );
      if( $tickets !="1" ){
        foreach ($tickets as $ticket) {

          $tempArray["idTicket"] = $ticket->idTicket();
          $tempArray["contentTicket"] = utf8_encode($ticket->contentTicket());
          $tempArray["statusTicket"] = $ticket->statusTicket();
          $tempArray["email"] = utf8_encode($ticket->email());
          $tempArray["ticketCategory"] = utf8_encode($ticket->ticketCategory());
          $tempArray["idEquipment"] = $ticket->idEquipment();
          $tempArray["idPrimaryTicket"] = $ticket->idPrimaryTicket();
          $tempArray["dateTicket"] = $ticket->dateTicket();
          $tempArray["ticketSenderStatus"] = $ticket->ticketSenderStatus();

          array_push($ticketsArray, $tempArray );

        }
        //showArray($ticket);

      }else{

      }
      echo json_encode($ticketsArray);
      //showArray($ticketsArray);

    }else{
      echo "pb";
    }

  }else{
    echo "Vous n'êtes pas autorisé";
  }
