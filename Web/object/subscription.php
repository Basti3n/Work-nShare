<?php
date_default_timezone_set('Europe/Paris');

class Subscription{
  private $_idSubscription = "Empty";
  private $_name = "Empty";
  private $_monthly = 0;
  private $_dayPrice = 0;
  private $_firstHour = 0;
  private $_halfHour = 0;
  private $_rights =[];
  private $_isDeleted = -1;

  public $listOfErrors =[];

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'idSubscription':
          $this->idSubscription($value);
          break;
        case 'name':
          $this->name($value);
          break;
        case 'isDeleted':
          $this->isDeleted($value);
          break;
        case 'monthly':
          $this->monthly($value);
          break;
        case 'dayPrice':
          $this->dayPrice($value);
          break;
        case 'firstHour':
          $this->firstHour($value);
          break;
        case 'halfHour':
          $this->halfHour($value);
          break;
        case 'listRights':
          $this->right("decode",null,$value);
          break;
        default:
          break;
      }

    }

  }

  public function idSubscription($id='0'){
    if($id=='0')
      return $this->_idSubscription;
    else
      $this->_idSubscription = $id;
    return 0;
  }

  public function name($value ='0'){
    if($value =='0')
      return $this->_name;

    trim($value);

    if(strlen($value)<80){
      $this->_name = $value;
      return 0;
    }else{
      $this->listOfErrors[] = 18;
      return 1;
    }
  }

  public function isDeleted($isDeleted='9'){
    if($isDeleted=='9')
      return $this->_isDeleted;
    trim($isDeleted);
    if($isDeleted != '0' && $isDeleted != '1'){
      return 2;
    }else{
      $this->_isDeleted=$isDeleted;
    }
    return 0;
  }

  public function right($action='0', $index='0', $val='0'){
    if($action=='0'){
      return $this->_rights;
    }
    switch ($action) {
      /* Edit rights */
      case 'add':
      case 'change':
        $this->_rights[$index] = $val;
        break;
      /* get rights from db */
      case 'decode':
        $this->_rights = json_decode($val,true);
        break;
      /* put rights in db */
      case 'encode':
        return json_encode($this->_rights);
        break;
      /* get single right val */
      case 'get':
        return $this->_rights[$index];
        break;
      /* get all rights val and key*/
      case 'getAll':
        return $this->_rights;
        break;
      /* check permission */
      case 'has':
        if(empty($this->_rights))
          return false;
        if (!array_key_exists($index,$this->_rights))
          return false;
        if ($this->_rights[$index] != 0)
          return true;
        return false;
        break;
      /* get all rights names */
      case 'table':
        if(!empty($this->_rights))
          return array_keys($this->_rights);
      break;

      default:
        break;
    }
    return 0;
  }

  public function monthly($value='-1'){
    if($value=='-1')
      return $this->_monthly;
    else
      $this->_monthly=$value;
    return 0;
  }

  public function dayPrice($value='-1'){
    if($value=='-1')
      return $this->_dayPrice;
    else
      $this->_dayPrice=$value;
    return 0;
  }

  public function firstHour($value='-1'){
    if($value=='-1')
      return $this->_firstHour;
    else
      $this->_firstHour=$value;
    return 0;
  }
  public function halfHour($value='-1'){
    if($value=='-1')
      return $this->_halfHour;
    else
      $this->_halfHour=$value;
    return 0;
  }

  public function total($access="-1", $exit="-1",$reduction="0"){
    if ($access == "-1" || $exit == "-1") {
      $listOfErrors[] = 5;
      return -1;
    }
    $duration = $this->duration(date('U',strtotime($access)),date('U',strtotime($exit))); // minutes
    $temp = 0;
    if($duration > 60*5){ //day : >5 h
      $temp += $this->dayPrice();
      $duration -= $duration;
    }
    if ($duration > 0) { //1ere h
      $temp += $this->firstHour();
      $duration -= 60;
    }
    if ($duration > 0) { // chaque 30mins
      $temp += $this->halfHour()*(ceil($duration/30));
    }
    return $temp;
  }



  public function duration($access="-1", $exit="-1"){
    $time = ($exit-$access) /60;
    return $time;
  }

  public function speak(){
    $this->right("add","ez",1);
    echo  "<br>\$_idSpace : ".$this->_idSubscription.
          "<br>\$_nameSpace : ".$this->_name.
          "<br>Total a payer : ".$this->total('18:25','19:30').
          "<br>rights -> ".print_r($this->right("getAll")).
          "<br>right -> ".$this->right("get","openspace").
          "<br>\$_isDeleted : ".$this->_isDeleted;
  }

}

class SubscriptionMng{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function add(Subscription $val){
    $query = $this->_db->prepare("INSERT INTO SUBSCRIPTIONS (name,isDeleted,monthly,dayPrice,firstHour,halfHour,listRights)
                                  VALUES (:name,:deleted,:monthly,:day,:first,:half,:right) ");
    $query->execute( [
      "name"=>$val->name(),
      "deleted"=>$val->isDeleted(),
      "monthly"=>$val->monthly(),
      "day"=>$val->dayPrice(),
      "first"=>$val->firstHour(),
      "half"=>$val->halfHour(),
      "right"=>$val->right("encode")
      ]);
  }

  public function delete(Subscription $val){
    $query = $this->_db->prepare('UPDATE SUBSCRIPTIONS SET isDeleted = 1 WHERE idSubscription =:idSubscription');
		$query->execute( ["idSubscription"=>$val->idSubscription()]);
    if($query){
      $val->isDeleted(1);
      return 0;
    }
    else {
      return 1;
    }
  }


  public function get($id){
    try {
      $query = $this->_db->prepare('SELECT  * FROM SUBSCRIPTIONS WHERE idSubscription =:idSubscription');
      $query->execute( ["idSubscription"=>$id]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }
    $data = $query->fetch(PDO::FETCH_ASSOC);
    return new Subscription($data);
  }


  public function getAll($deleted="-1"){
    $sql = 'SELECT * FROM SUBSCRIPTIONS'.($deleted==1?' WHERE isDeleted = 0':'');

    try{
      $query = $this->_db->prepare($sql);
      $query->execute();
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $array = [];
      foreach ($data as $key => $subscribe) {
        array_push($array,new Subscription($subscribe));
      }
      return $array;
    }else{
      echo "Il n'y a aucun abonnement pour l'instant";
      return 1;
    }
  }


  public function update(Subscription $val){
    try{
        $query = $this->_db->prepare('UPDATE SUBSCRIPTIONS SET name = :name, monthly = :monthly,  dayPrice = :day, firstHour = :first, halfHour = :half, isDeleted = :isDeleted
          WHERE idSubscription = :idSubscription');
        $query->execute([
          "idSubscription"=>$val->idSubscription(),
          "name"=>$val->name(),
          "isDeleted"=>$val->isDeleted(),
          "monthly"=>  floatval($val->monthly()),
          "day"=> floatval($val->dayPrice())  ,
          "first"=>floatval($val->firstHour()),
          "half"=>floatval($val->halfHour()),
        ]);
        return 0;
    }catch (Exception $e){
        echo "PDOException : ".$e->getMessage();
        return 1;
    }
  }


  public function updateRights($idSub , $listRights){
    try{
        $query = $this->_db->prepare('UPDATE SUBSCRIPTIONS SET listRights = :listRights
          WHERE idSubscription = :idSubscription');
        $query->execute([
          "idSubscription"=>$idSub,
          "listRights"=>$listRights
        ]);
        return 0;
    }catch (Exception $e){
        echo "PDOException : ".$e->getMessage();
        return 1;
    }
  }
}
 ?>
