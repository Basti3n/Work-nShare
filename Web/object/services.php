<?php
date_default_timezone_set('Europe/Paris');

class Service{
  private $_idService;
  private $_idSpace = "Empty";
  private $_isBooked;
  private $_nameService = "Empty";
  private $_compInfo ="Empty";
  private $_isDeleted;
  public $listOfErrors=[];


  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){

    foreach ($data as $key => $value) {
      switch ($key) {
        case 'idService':
          $this->idService($value);
          break;
        case 'idSpace':
          $this->idSpace($value);
          break;
        case 'isBooked':
          $this->isBooked($value);
          break;
        case 'nameService':
          $this->nameOfService($value);
          break;
        case 'compInfo':
          $this->compInfo($value);
          break;
        case 'isDeleted':
          $this->isDeleted($value);
          break;

        default:
          break;
      }
    }
  }


  public function idService($idService ='0'){
    if($idService=='0')return $this->_idService;
     $this->_idService = $idService;
    return 0;
  }

  public function idSpace($idSpace ='0'){
    if($idSpace =='0')return $this->_idSpace;
     $this->_idSpace = $idSpace;
    return 0;
  }

  public function isBooked($isBooked=-10){
    if($isBooked == -10)return $this->_isBooked;
     $this->_isBooked = $isBooked;
    return 0;
  }

  public function nameOfService($nameOfService = '0'){
    if($nameOfService =='0')return $this->_nameService;

    if(strlen($nameOfService)<80){
      $this->_nameService = $nameOfService;
    }else{
      $this->listOfErrors[] = 19;
      return 1;
    }
  }

  public function compInfo($compInfo = '0'){
    if($compInfo == '0')return $this->_compInfo;

    $this->_compInfo == $compInfo;
  }

  public function isDeleted($isDeleted ='9'){
    if($isDeleted=='9') return $this->_isDeleted;

    $this->_isDeleted = $isDeleted;
  }

}

class ServiceMng{
  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function add(Service $service){
    $query = $this->_db->prepare("INSERT INTO SERVICES (idSpace,isBooked,nameService,compInfo,isDeleted)
                                  VALUES (:idSpace,1,:nameService,:compInfo,0) ");
    $query->execute( [
      "idSpace"=>$service->idSpace(),
      "nameService"=>$service->nameOfService(),
      "compInfo"=>$service->compInfo()
      ]);
  }

  public function delete(Service $service){
    $query = $this->_db->prepare('UPDATE SERVICES SET isDeleted = 1 WHERE idService =:idService');
		$query->execute( ["idService"=>$service->idService()]);
  }

  public function get($idService){
    try {
      $query = $this->_db->prepare('SELECT  idService,idSpace,isBooked,nameService,compInfo,isDeleted FROM SERVICES WHERE idService =:idService');
      $query->execute( ["idService"=>$idService]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }

    $data = $query->fetch(PDO::FETCH_ASSOC);
    return new Space($data);
  }

  public function getServiceName($idService){
    try {
      $query = $this->_db->prepare('SELECT  nameService FROM SERVICES WHERE idService =:idService');
      $query->execute( ["idService"=>$idService]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }

    $data = $query->fetch(PDO::FETCH_ASSOC);
    return $data["nameService"];
  }


  public function getAllServices(){
    try{
      $query = $this->_db->prepare('SELECT idService,idSpace,isBooked,nameService,compInfo,isDeleted FROM SERVICES');
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();

    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $services = [];


      foreach ($data as $key => $service) {
        array_push($services,new Service($service));
      }
      return $services;
    }else{
      echo "Il n'y a aucun service pour l'instant";
      return 1;
    }

  }

  
  public function updateService($idService,Service $service){
    try{
        $query = $this->_db->prepare('UPDATE SERVICES
                      SET idSpace =:idSpace,isBooked = :isBooked,nameService = :nameService,compInfo = :compInfo,isDeleted = :isDeleted
                              WHERE idService = :idService');
        $query->execute([
          "idSpace"=>$service->idSpace(),
          "isBooked"=>$service->isBooked(),
          "nameService"=>$service->nameOfService(),
          "compInfo"=>$service->compInfo(),
          "isDeleted"=>$service->isDeleted(),
          "idService"=>$idService
        ]);
    }catch (Exception $e){
      echo "PDOException : ".$e->getMessage();;
    }

      echo "Service updated";
  }



}



 ?>
