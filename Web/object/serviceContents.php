<?php
date_default_timezone_set('Europe/Paris');

class ServiceContent{
  private $_idServiceContent;
  private $_informationServiceContent="Empty";
  private $_nameServiceContent ="Empty";
  private $_isFree;
  private $_isDeleted;
  private $_idService;
  public $listOfErrors= [];

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'idServiceContent':
          $this->idServiceContent($value);
          break;

        case 'informationServiceContent':
          $this->informationServiceContent($value);
          break;

        case 'nameServiceContent':
          $this->nameServiceContent($value);
          break;

        case 'isFree':
          $this->isFree($value);
          break;

        case 'isDeleted':
          $this->isDeleted($value);
          break;

        case 'idService':
          $this->idService($value);
          break;

        default:
          break;
      }
    }
  }

  public function idServiceContent($idServiceContent='-1'){
    if($idServiceContent=='-1') return $this->_idServiceContent;

    $this->_idServiceContent = $idServiceContent;
    return 0;
  }

  public function informationServiceContent($informationServiceContent = '-1'){
    if($informationServiceContent =='-1') return $this->_informationServiceContent;

    $this->_informationServiceContent = $informationServiceContent;
  }

  public function nameServiceContent($nameServiceContent ='0'){
    if($nameServiceContent =='0') return $this->_nameServiceContent;

    if( (strlen($nameServiceContent)<80) ){
      $this->_nameServiceContent = $nameServiceContent;
    }else{
        $this->listOfErrors[] = 20;
      return 1;
    }
  }

  public function isFree($isFree ='-1'){
    if($isFree == '-1') return $this->_isFree;

    $this->_isFree = $isFree;
  }

  public function isDeleted($isDeleted = '-1'){
    if($isDeleted =='-1') return $this->$isDeleted;

    $this->_isDeleted = $isDeleted;
  }

  public function idService($idService = '-1'){
    if($idService == '-1') return $this->_idService;

    $this->_idService = $idService ;
  }



}


class ServiceContentMng{


  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }


  public function add(ServiceContent $serviceContent){
    $query = $this->_db->prepare("INSERT INTO SERVICE_CONTENT (informationServiceContent,nameServiceContent,isFree,isDeleted,idService)
                                  VALUES (:informationServiceContent,:nameServiceContent,:isFree,0,:idService) ");
    $query->execute( [
      "informationServiceContent"=>$serviceContent->informationServiceContent(),
      "nameServiceContent"=>$serviceContent->nameServiceContent(),
      "isFree"=>$serviceContent->isFree(),
      "idService"=>$serviceContent->idService()
      ]);
  }


  public function delete(ServiceContent $serviceContent){
    $query = $this->_db->prepare('UPDATE SERVICE_CONTENT SET isDeleted = 1 WHERE idServiceContent =:idServiceContent');
		$query->execute( ["idServiceContent"=>$service->idServiceContent()]);
  }


  public function getAllServiceContents(){
    try{
      $query = $this->_db->prepare('SELECT idServiceContent,informationServiceContent,nameServiceContent,isFree,isDeleted,idService FROM SERVICE_CONTENT');
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();

    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $serviceContents = [];

      //showArray($data);
      foreach ($data as $key => $serviceContent) {
        array_push($serviceContents,new ServiceContent($serviceContent));
      }
      return $serviceContents;
    }else{
      echo "Il n'y a aucun service pour l'instant";
      return 1;
    }

  }

}




?>
