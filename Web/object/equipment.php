<?php
date_default_timezone_set('Europe/Paris');

class Equipement{
  private $_idEquipment = -1;
  private $_equipmentName = "Empty";
  private $_isDeleted = -1;
  private $_isFree = -1;
  private $_lastCheckDate;
  private $_idSpace = -1;

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }



    public function hydrate(array $data){
      foreach ($data as $key => $value) {
        switch($key){
          case 'idEquipment':
            $this->idEquipment($value);
            break;
          case 'equipmentName':
            $this->equipmentName($value);
            break;
          case 'isDeleted':
            $this->isDeleted($value);
            break;

          case 'isFree':
            $this->isFree($value);
            break;
          case 'lastCheckDate':
            $this->lastCheckDate($value);
            break;

          case 'idSpace':
            $this->idSpace($value);
            break;
          default:
            break;
        }

      }
    }


    public function idEquipment($idEquipment = -2){
      if($idTicket == -2)
        return $this->_idEquipment;
      else
      if(!is_numeric($idEquipment)){
        $errors[] = 15;
        return -1;
      }
        $this->_idEquipment= $idEquipment;
      return 0;
    }

    public function equipmentName($equipmentName = '0'){
      if($equipmentName == '0')
        return $this->_equipmentName;
      trim($equipmentName);
      if (strlen($equipmentName)<1 || strlen($equipmentName) > 80) {
        return 1;
      }
      $this->_equipmentName = $equipmentName;
      return 0;
    }

    public function lastCheckDate($date = '0'){
      if($date == '0')
        return date('j \/ m \/ Y',$this->_lastCheckDate);
      else{
        $this->_lastCheckDate = strtotime($date);
      }
      return $this->_lastCheckDate;
    }


    public function isDeleted($value = '-1'){
      if($value == '-1')
        return $this->_isDeleted;
      if($value == 0 || $value == 1)
        $this->_isDeleted = $value;
      else
        return 2;
      return -1;
    }


    public function isFree($value = '-1'){
      if($value == '-1')
        return $this->_isDeleted;
      if($value == 0 || $value == 1)
        $this->_isDeleted = $value;
      else
        return 2;
      return -1;
    }


    public function idSpace($idSpace='0',$action ='0'){
      if($idSpace=='0')
        return $this->_idSpace;
      trim($idSpace);
      if(strlen($idSpace)==7 ){
        $this->_idSpace = $idSpace;
        return 0;
      }else{
        return 1;
      }
    }





}

class EquipementMng{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }


  public function add(Ticket $ticket){
    try{
      $query = $this->_db->prepare("INSERT INTO EQUIPMENTS (equipmentName,isDeleted,isFree,lastCheckDate,idSpace)
                                    VALUES (:equipmentName, :isDeleted , :isFree , :lastCheckDate , :idSpace )");
      $query->execute( [
        "equipmentName"=>$ticket->equipmentName(),
        "isDeleted"=>$ticket->isDeleted(),
        "isFree"=>$ticket->isFree(),
        "lastCheckDate"=>$ticket->lastCheckDate(),
        "idSpace"=>$ticket->idSpace()
        ]);
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
  }




}


 ?>
