<?php
date_default_timezone_set('Europe/Paris');

class Ticket
{
  private $_id;
  private $_content = " - ";
  private $_dateSend;
  private $_status;
  private $_file;
  private $_category;
  private $_idEquipment;
  private $_expeditor = "Unknown";
  private $_readed = false;
  public $errors = [];

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value){
      switch ($key) {
        case 'idTicket':
          $this->id($value);
          break;
        case 'contentTicket':
          $this->content($value);
          break;
        case 'statusTicket':
          $this->status($value);
          break;
        case 'email':
          $this->email($value);
          break;
        case 'ticketLinkDoc':
          $this->linkedFile($value);
          break;
        case 'ticketCategory':
          $this->category($value);
          break;
        case 'idEquipment':
          $this->linkedObject($value);
          break;

      }
      /*$method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
        $this->$method($value);*/
    }
  }

  public function id($new = "-1"){
    if($new == "-1")
      return $this->_id;
    if(!is_numeric($new)){
      $errors[] = 15;
      return 1;
    }
    $this->_id = $new;
    return 0;
  }

  public function date($new = '-1'){
    if($new == '-1')
      return date('j \/ m \/ Y');
      //date('j \/ m \/ Y',$this->_dateSend);
    else{
      $this->_dateSend = strtotime($new);
    }
    return $this->_dateSend;
  }

  public function content($new = "-1"){
    if($new == "-1")
      return $this->_content;
    $this->_content = $new;
    return 0;
  }

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

  public function email($new = "-1"){
    if($new == "-1")
      return $this->_email;
    if (!filter_var($new, FILTER_VALIDATE_EMAIL)) {
      $this->errors[] = 6;
      return 1;
    }
    $this->_email = $new;
    return 0;
  }

  public function linkedFile($new = "-1"){
    if($new == "-1")
      return $this->_file;
    $this->_file = $new;
    return 0;
  }

  public function category($new = "-1"){
    if($new == "-1")
      return $this->_category;
    if (!$this->isCategory($new)){
      $this->errors[] = 17;
      return 1;
    }
    $this->_category = $new;
    return 0;
  }

  public function linkedObject($new = "-1"){
    if($new == "-1")
      return $this->_idEquipment;
    if (isset($new)){
      $this->_idEquipment = "null";
      return 0;
    }
    $this->_idEquipment = $new;
    return 0;
  }

  private function isStatus($status){
    $ts = [
      "Nouveau",
    	"En cours",
    	"Résolu",
    	"En attente",
    	"En retard"
    ];
    for ($i=0; $i < count($ts); $i++) {
      if($ts[$i] == $status)
        return true;
    }
    return false;
  }

  private function isCategory($status){
    $tc = [
    	"Matériel",
    	"Réseau",
    	"Alimentaire",
    	"Réservation",
    	"Autre",
      "Equipment"
    ];
    for ($i=0; $i < count($tc); $i++) {
      if($tc[$i] == $status)
        return true;
    }
    return false;
  }

  public function speak(){
    echo  "<br>\$_id : ".$this->_id.
          "<br>\$_content : ".$this->_content.
          "<br>\$_status : ".$this->_status.
          "<br>\$_email : ".$this->_email.
          "<br>\$_category : ".$this->_category.
          "<br>\$_linkedObject : ".$this->_idEquipment.
          "<br>\$_linkedFile : ".$this->_file;
  }

}

/**
 * Obligatoire pour la gestion de l'objet (norme)
 */
class TicketMng
{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function add(Ticket $data){
    $date = date("y-m-d");
    $query = $this->_db->prepare("INSERT INTO TICKETS (idTicket,contentTicket,statusTicket,email,ticketLinkDoc,ticketCategory,idEquipment)
                                  VALUES (:id,:content, :status, :email, :file, :category, :idEquipment) ");
		$query->execute( [
			"id" => $data->id(),
      "content" => $data->content(),
      "status" => $data->status(),
      "email" => $data->email(),
      "file" => $data->linkedFile(),
      "category" => $data->category(),
      "idEquipment" => $data->linkedObject()
			]);
  }

  public function update(Ticket $data){
    $date = date("y-m-d");
    $query = $this->_db->prepare("UPDATE TICKETS
                                  SET idTicket=:id,contentTicket=:content,statusTicket=:status,email=:email,ticketLinkDoc=:file,ticketCategory=:category,idEquipment=:idEquipment
                                  WHERE idTicket=:id");
    $query->execute( [
			"id" => $data->id(),
      "content" => $data->content(),
      "status" => $data->status(),
      "email" => $data->email(),
      "file" => $data->linkedFile(),
      "category" => $data->category(),
      "idEquipment" => $data->linkedObject()
			]);
  }

  public function get($email){
    try {
      $query = $this->_db->prepare('SELECT email,nameUser,lastnameUser,dateSignUp,passwordUser,isdeleted FROM USERS WHERE email =:email');
      $query->execute( ["email"=>$email]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }

    $data = $query->fetch(PDO::FETCH_ASSOC);
    return new User($data);
  }

  public function getAll(){
    try{
      $query = $this->_db->prepare('SELECT * FROM TICKETS');
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data != NULL){
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

}

?>
