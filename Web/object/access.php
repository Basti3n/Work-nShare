<?php
date_default_timezone_set('Europe/Paris');
require_once "subscription.php";


class Access{
  private $_idAccess = -1;
  private $_email = "Empty";
  private $_idSpace = "Empty";
  private $_dateAccess;
  private $_dateExit;
  public $listOfErrors = [];


  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }


  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'email':
          $this->email($value);
          break;
        case 'idSpace':
          $this->idSpace($value);
          break;
        case 'idAccess':
          $this->idAccess($value);
          break;
        case 'dateAccess':
          $this->dateAccess($value);
          break;
        case 'dateExit':
          $this->dateExit($value);
          break;
        default:
          break;
      }

    }

  }


  public function email($email = '0', $confirm = '0'){
    if($email == '0' && $confirm == '0')
      return $this->_email;
    if($confirm == '0'){
      $this->_email = $email;
      return 0;
    }
    trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //trigger_error("L'email saisie est trop long", E_USER_ERROR);
      $this->listOfErrors[] = 6;
      return 1;
    }
    if ($email != $confirm && $confirm != '0') {
      //trigger_error("L'email saisie est trop long", E_USER_ERROR);
      $this->listOfErrors[] = 7;
      return 1;
    }
    $db = connectDb();
		$email_verif = $db->prepare("SELECT email FROM USERS WHERE email = :email");
		$email_verif->execute(["email"=> $email]);
		$resultat = $email_verif->fetch();
		if (!empty($resultat)) {
			$this->listOfErrors[] = 15;
      return 1;
		}
    $this->_email = $email;
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
      $this->listOfErrors[] = 17;
      return 1;
    }
  }


  public function idAccess($idAccess = -2){
    if($idAccess == -2)
      return $this->_idAccess;
    else
    if(!is_numeric($idAccess)){
      return -1;
    }
    $this->_idAccess= $idAccess;
    return 0;
  }


  public function dateAccess($date = '0',$action ='0'){
    if($date == '0' && $action=='0')
      return date('Y\-m\-j H:i:s',$this->_dateAccess);
    else if($action == 0){
      $this->_dateAccess = strtotime($date);
    }else{
      return date('Y\-m\-j H:i',$this->_dateAccess);

    }
    return 0;
  }


  public function dateExit ($date = '0',$action ='0'){
    if($date == '0' & $action =='0')
      return date('Y\-m\-j H:i:s',$this->_dateExit);
    else if ($action =='0'){
      $this->_dateExit = strtotime($date);
    }else{
      return date('Y\-m\-j H:i',$this->_dateExit);

    }
    return 0;
  }



}


Class AccessMng{

  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }
  public function getDb(){
    return $this->_db;
  }

  public function add(Access $val){
    $query = $this->_db->prepare("INSERT INTO ACCESS (email,idSpace,dateAccess,dateExit)
                                  VALUES (:email,:idSpace,:dateAccess,:dateExit) ");
    $query->execute( [
      "email"=>$val->email(),
      "idSpace"=>$val->idSpace(),
      "dateAccess"=>$val->dateAccess(),
      "dateExit"=>$val->dateExit()
      ]);
  }


    public function update(Access $val){
      try{
          $query = $this->_db->prepare('UPDATE ACCESS SET email = :email, idSpace = :idSpace,  dateAccess = :dateAccess, dateExit = :dateExit
            WHERE idAccess = :idAccess');
          $query->execute([
            "email"=>$val->email(),
            "idSpace"=>$val->idSpace(),
            "dateAccess"=>$val->dateAccess(),
            "dateExit"=>  $val->dateExit(),
            "idAccess"=> $val->idAccess()
          ]);
          return 0;
      }catch (Exception $e){
          echo "PDOException : ".$e->getMessage();
          return 1;
      }
    }




  public function getAll($email="-1"){
    $sql = 'SELECT * FROM ACCESS '.($email!="-1"?' WHERE email  = :email':'').' ORDER BY dateExit DESC';

    try{
      $query = $this->_db->prepare($sql);
      if($email != "-1"){
        $query->execute( ["email"=>$email]);
      }else{
        $query->execute();
      }
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data !=NULL){
      $array = [];
      foreach ($data as $key => $access) {
        array_push($array,new Access($access));
      }
      return $array;
    }else{
      echo "Il n'y a aucun accès aux espaces pour l'instant";
      return 1;
    }
  }

  public function getSubscription(Access $access){
    $idSubscription = $this->checkIfIsSub($access);
    $subscriptionMng = new SubscriptionMng($this->getDb());

    $sub = $subscriptionMng->get($idSubscription);
    return $sub->total($access->dateAccess(),$access->dateExit() );
  }

  public function checkIfIsSub(Access $access){
    $sql = 'SELECT * FROM ISSUBSCRIBED WHERE email = :email
                AND :dateAccess BETWEEN dateSubscription AND dateEndSubscription';

    try{
      $query = $this->_db->prepare($sql);
      $query->execute([
        "email"=>$access->email(),
        "dateAccess"=>$access->dateAccess()
      ]);
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }

    if($data != NULL){
      return $data[0]["idSubscription"];
    }else{
      return 1;
    }
  }

}

?>
