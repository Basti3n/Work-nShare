<?php
date_default_timezone_set('Europe/Paris');

class Ticket{
  private $_idTicket = -1;
  private $_contentTicket = "Empty";
  private $_email = "Empty";
  private $_ticketCategory ="Empty";
  private $_idPrimaryTicket =-1;
  private $_ticketLinkDoc = "Empty";
  private $_idEquipment  = -1;
  private $_statusTicket = -1;
  private $_ticketSenderStatus = -1;
  private $_dateTicket;


  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'idTicket':
          $this->idTicket($value);
          break;
        case 'contentTicket':
          $this->contentTicket($value);
          break;
        case 'statusTicket':
          $this->statusTicket($value);
          break;
        case 'email':
          $this->email($value);
          break;
        case 'ticketLinkDoc':
          $this->ticketLinkDoc($value);
          break;
        case 'ticketCategory':
          $this->ticketCategory($value);
          break;
        case 'idEquipment':
          $this->idEquipment($value);
          break;
        case 'idPrimaryTicket':
          $this->idPrimaryTicket($value);
          break;
        case 'dateTicket':
          $this->dateTicket($value);
          break;
        case 'ticketSenderStatus':
          $this->ticketSenderStatus($value);
          break;

        default:
          break;
      }
    }
  }



  public function idTicket($idTicket = -2){
    if($idTicket == -2)
      return $this->_idTicket;
    else
    if(!is_numeric($idTicket)){
      $errors[] = 15;
      return 1;
    }
      $this->_idTicket= $idTicket;
    return 0;
  }


  public function contentTicket($contentTicket = "0"){
    if($contentTicket == "0")
      return $this->_contentTicket;
    else
      $this->_contentTicket= $contentTicket;
    return 0;
  }

/* Stocké en char
public function status($new = "-1"){
  if($new == "-1")
    return $this->_status;
  if (!$this->isStatus($new)){
    $this->errors[] = 17;
    return 1;
  }
  $this->_status = $new;
  return 0;
}
*/

  public function statusTicket($statusTicket = -2){
    if($statusTicket == -2)
      return $this->_statusTicket;
    else{
      if($statusTicket >= 0 && $statusTicket <= 5){
        $this->_statusTicket= $statusTicket;
        return 0;
      }else{
        return 1;
      }
    }
  }


  public function ticketSenderStatus($ticketSenderStatus = -2){
    if($ticketSenderStatus == -2)
      return $this->_ticketSenderStatus;
    else{
      if($ticketSenderStatus >= 0 && $ticketSenderStatus <= 3){
        $this->_ticketSenderStatus= $ticketSenderStatus;
        return 0;
      }else{
        return 1;
      }
    }
  }

  public function email($email = "0"){
    if($email == "0")
      return $this->_email;
    else
      $this->_email= $email;
    return 0;
  }

  public function ticketLinkDoc($ticketLinkDoc = "0"){
    if($ticketLinkDoc == "0")
      return $this->_ticketLinkDoc;
    else
      $this->_ticketLinkDoc= $ticketLinkDoc;
    return 0;
  }


  public function ticketCategory($ticketCategory = "0"){
    if($ticketCategory == "0")
      return $this->_ticketCategory;
    else
      $this->_ticketCategory= $ticketCategory;
    return 0;
  }


  public function idEquipment($idEquipment = "0"){
    if($idEquipment == "0")
      return $this->_idEquipment;
    else
      $this->_idEquipment= $idEquipment;
    return 0;
  }


  public function dateTicket($date = '0'){
    if($date == '0')
      return date('j \/ m \/ Y');
    else{
      $this->_dateTicket = strtotime($date);
    }
    return $this->_dateTicket;
  }

  public function idPrimaryTicket($idPrimaryTicket = "0"){
    if($idPrimaryTicket == "0")
      return $this->_idPrimaryTicket;
    else
      $this->_idPrimaryTicket= $idPrimaryTicket;
    return 0;
  }
}

class TicketMng{

  private $_db;
  private $_nbLine = 0;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }


  public function add(Ticket $ticket){
    try{
      $query = $this->_db->prepare("INSERT INTO TICKETS (contentTicket,statusTicket,email,ticketLinkDoc,ticketCategory,idEquipment,idPrimaryTicket,dateTicket,ticketSenderStatus)
                                    VALUES (:contentTicket,1,:email,:ticketLinkDoc,:ticketCategory,:idEquipment,:idPrimaryTicket,NOW(),:ticketSenderStatus)");
      $query->execute( [
        "contentTicket"=>  utf8_decode($ticket->contentTicket())  ,
        "email"=>$ticket->email(),
        "ticketLinkDoc"=>$ticket->ticketLinkDoc(),
        "ticketCategory"=>$ticket->ticketCategory(),
        "idEquipment"=>$ticket->idEquipment(),
        "idPrimaryTicket"=>$ticket->idPrimaryTicket(),
        "ticketSenderStatus"=>$ticket->ticketSenderStatus()
        ]);
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }

  }


  public function get($idTicket='-11'){
    if($idTicket == -1)
      return -1;

    $query = $this->_db->prepare('SELECT * FROM TICKETS WHERE idTicket = :idTicket');
    $query->execute(["idTicket"=> $idTicket]);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      return new Ticket($data[0]);
    }else{
      return -1;
    }
  }

  public function getAllTickets($value="-1"){
    try{
      if($value =="-1"){
        $query = $this->_db->prepare('SELECT * FROM TICKETS WHERE ticketSenderStatus=0 ORDER BY idTicket ');
        $query->execute();
      }else{
        $query = $this->_db->prepare('SELECT * FROM TICKETS WHERE idPrimaryTicket = :idPrimaryTicket ORDER BY dateTicket ASC');
        $query->execute(["idPrimaryTicket"=>$value]);
      }

    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();

    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $tickets = [];
      foreach ($data as $key => $ticket) {
        array_push($tickets,new Ticket($ticket));
      }
      return $tickets;
    }else{
      return 1;
    }

  }


  public function getLastMessageDate(Ticket $ticket){
    $query = $this->_db->prepare('SELECT * FROM TICKETS WHERE idPrimaryTicket = :idTicket ORDER BY dateTicket DESC');
    $query->execute(["idTicket"=>$ticket->idTicket()]);

    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data!=NULL){
      $lastTicket = new Ticket($data[0]);
      return $lastTicket->dateTicket();
    }else{
      return $ticket->dateTicket();
    }
  }

  public function updateTicketStatus($idTicket , $statusTicket){


    try{
      $query = $this->_db->prepare('UPDATE TICKETS SET statusTicket = :statusTicket WHERE idTicket = :idTicket');
      $query->execute([
        "statusTicket"=>$statusTicket,
        "idTicket"=>$idTicket
      ]);
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
  }


    public function getParse($start,$end,$email){
      $sql = "SELECT * FROM TICKETS WHERE email = :email LIMIT $start,$end";// query
      try{
        $query = $this->_db->prepare($sql);
        $query->execute(["email"=>$email]);

      }catch(Exception $e){
        echo "PDOException : " . $e->getMessage();
      }
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
      if($data != NULL){
        $this->_nbLine = $query->rowCount();
        $tickets = [];
        foreach ($data as $key => $ticket) {
          array_push($tickets,new Ticket($ticket));
        }
        return $tickets;
      }else{

        echo "Il n'y a aucun ticket pour l'instant";
        return 1;
      }
      return 0;
    }

    public function getLine($email,$choice = "0"){
      if($choice != "0")
        return $this->_nbLine;
      try{
        $query = $this->_db->prepare('SELECT * FROM TICKETS WHERE email = :email');
        $query->execute(["email"=>$email]);
        $this->_nbLine = $query->rowCount();
      }catch(Exception $e){
        echo "PDOException : " . $e->getMessage();
      }
      return (int)$this->_nbLine;
    }


}
