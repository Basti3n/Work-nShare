<?php
date_default_timezone_set('Europe/Paris');

class Equipment{
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
          $this->lastCheckDate('0',$value);
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
    if($idEquipment == -2)
      return $this->_idEquipment;
    else
    if(!is_numeric($idEquipment)){
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

    public function lastCheckDate($action ='0',$date = '0'){
      if($date == '0' && $action =='0')
        return date('j \/ m \/ Y',$this->_lastCheckDate);
      else if($action =='0'){
        $this->_lastCheckDate = strtotime($date);
      }else if($action =='1'){
        return $this->_lastCheckDate;
      }
      return 0;
    }


    public function isDeleted($value = '-1'){
      if($value == '-1')
        return $this->_isDeleted;
      if($value == 0 || $value == 1)
        $this->_isDeleted = $value;
      else
        return 2;
      return 0;
    }


    public function isFree($value = '-1'){
      if($value == '-1')
        return $this->_isFree;

      if($value == 0 || $value == 1)
        $this->_isFree = $value;
      else
        return 2;
      return 0;
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

class EquipmentMng{
  private $_db;
  private $_UPDATE_FREQUENCY = 2592000;


  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }


  public function add(Equipment $equipment){
    $sql = "INSERT INTO EQUIPMENTS (equipmentName,isDeleted,isFree,lastCheckDate,idSpace)
                                  VALUES (:equipmentName, :isDeleted , :isFree , NOW() , :idSpace )";
    try{
      $query = $this->_db->prepare($sql);

      $query->execute( [
        "equipmentName"=>$equipment->equipmentName(),
        "isDeleted"=>$equipment->isDeleted(),
        "isFree"=>$equipment->isFree(),
        "idSpace"=>$equipment->idSpace()
      ]);
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
  }


  public function update(Equipment $equipment){
    try{
        $query = $this->_db->prepare('UPDATE EQUIPMENTS SET equipmentName =:equipmentName, isDeleted = :isDeleted, isFree = :isFree ,idSpace = :idSpace
          WHERE idEquipment = :idEquipment');
        $query->execute([
          "equipmentName"=>$equipment->equipmentName(),
          "isDeleted"=>$equipment->isDeleted(),
          "isFree"=>$equipment->isFree(),
          "idSpace"=>$equipment->idSpace(),
          "idEquipment"=>$equipment->idEquipment()
        ]);
        echo "Equipment updated";
        return 0;
    }catch (Exception $e){
        echo "PDOException : ".$e->getMessage();
        return 1;
    }
  }

  public function getAll($deleted="-1"){
    $sql = 'SELECT * FROM EQUIPMENTS'.($deleted==1?' WHERE isDeleted = 0':'');

    try{
      $query = $this->_db->prepare($sql);
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();

    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $equipments = [];
      foreach ($data as $key => $equipment) {
        array_push($equipments,new Equipment($equipment));
      }
      return $equipments;
    }else{
      echo "Il n'y a aucun équipement pour l'instant";
      return 1;
    }

  }

  public function checkDate(Equipment $equipment){
    if(time() - $equipment->lastCheckDate('1') > $this->_UPDATE_FREQUENCY ){
      return 1;
    }else{
      return 0;
    }
  }


  public function updateLastCheckDate(Equipment $equipment){
    try{
        $query = $this->_db->prepare('UPDATE EQUIPMENTS SET lastCheckDate = NOW()  WHERE idEquipment = :idEquipment');
        $query->execute([
          "idEquipment"=>$equipment->idEquipment()
        ]);
        echo "Equipment date updated";
        return 0;
    }catch (Exception $e){
        echo "PDOException : ".$e->getMessage();
        return 1;
    }
  }


    public function getName($idEquipment){
      try {
        $query = $this->_db->prepare('SELECT  equipmentName FROM EQUIPMENTS WHERE idEquipment =:idEquipment');
        $query->execute( ["idEquipment"=>$idEquipment]);
      } catch(Exception $e) {
          echo "PDOException : " . $e->getMessage();
      }

      $data = $query->fetch(PDO::FETCH_ASSOC);
      return $data["equipmentName"];
    }




}


 ?>
