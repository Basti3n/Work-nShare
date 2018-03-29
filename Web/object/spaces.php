<?php
date_default_timezone_set('Europe/Paris');

class Space{
  private $_idSpace = "Empty";
  private $_nameSpace = "Empty";
  private $_isDeleted;
  public $listOfErrors =[];

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'idSpace':
          $this->IdSpace($value);
          break;
      case 'nameSpace':
          $this->NameOfSpace($value);
          break;
        case 'isDeleted':
          $this->IsDeleted($value);
          break;
        default:
          break;
      }

    }

  }

  public function IdSpace($idSpace='0',$action ='0'){
    if($idSpace=='0')
      return $this->_idSpace;

    trim($idSpace);
    if(strlen($idSpace)==7 ){
      $this->_idSpace = $idSpace;
      return 0;
    }else{
      $this->listOfErrors[] = 17;
      return 1;
    }
  }

  public function NameOfSpace($nameOfSpace ='0' , $testValue='0'){
    if($nameOfSpace =='0')
      return $this->_nameSpace;

    trim($nameOfSpace);

    if(strlen($nameOfSpace)<25){
      $this->_nameSpace = $nameOfSpace;
    }else{
      $this->listOfErrors[] = 18;
      return 1;
    }
  }

  public function IsDeleted($isDeleted='9'){
    if($isDeleted=='9')
      return $this->_isDeleted;
    trim($isDeleted);
    if($isDeleted != '0' && $isDeleted != '1'){
      return 2;
    }else{
      $this->_isDeleted=$isDeleted;
    }

  }


  public function speak(){
    echo  "<br>\$_idSpace : ".$this->_idSpace.
          "<br>\$_nameSpace : ".$this->_nameSpace.
          "<br>\$_isDeleted : ".$this->_isDeleted;
  }


}



class SpaceMng{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }


  public function add(Space $space){
    $query = $this->_db->prepare("INSERT INTO SPACES (idSpace,nameSpace,isDeleted)
                                  VALUES (:idSpace,:nameSpace,0) ");
    $query->execute( [
      "idSpace"=>$space->IdSpace(),
      "nameSpace"=>$space->NameOfSpace(),
      ]);
  }


  public function delete(Space $space){
    $query = $this->_db->prepare('UPDATE SPACES SET isDeleted = 1 WHERE idSpace =:idSpace');
		$query->execute( ["idSpace"=>$space->IdSpace()]);
  }


  public function get($idSpace){
    try {
      $query = $this->_db->prepare('SELECT  idSpace,nameSpace,isDeleted FROM SPACES WHERE idSpace =:idSpace');
      $query->execute( ["idSPace"=>$idSpace]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }

    $data = $query->fetch(PDO::FETCH_ASSOC);
    return new Space($data);
  }

  public function getSpaceName($idSpace){
    try {
      $query = $this->_db->prepare('SELECT  nameSpace FROM SPACES WHERE idSpace =:idSpace');
      $query->execute( ["idSpace"=>$idSpace]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }

    $data = $query->fetch(PDO::FETCH_ASSOC);
    return $data["nameSpace"];
  }

  public function getAllSpaces(){
    try{
      $query = $this->_db->prepare('SELECT * FROM SPACES');
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();

    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $spaces = [];
      foreach ($data as $key => $space) {
        array_push($spaces,new Space($space));
      }
      return $spaces;
    }else{
      echo "Il n'y a aucun site pour l'instant";
      return 1;
    }

  }


}
 ?>
