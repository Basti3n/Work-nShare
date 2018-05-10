<?php
date_default_timezone_set('Europe/Paris');

class IsSub{
  private $_email = "empty";
  private $_idSubscription = -1;
  private $_dateSubscription ;
  private $_dateEndSubscription;
  private $_idIsSubcribed = -1;

  public $listOfErrors =[];


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
          case 'idSubscription':
            $this->idSubscription($value);
            break;
          case 'dateSubscription':
            $this->dateSubscription($value);
            break;
          case 'dateEndSubscription':
            $this->dateEndSubscription($value);
            break;
          case 'idIsSubcribed':
            $this->idIsSubcribed($value);
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


    public function idSubscription($id='0'){
      if($id=='0')
        return $this->_idSubscription;
      else
        $this->_idSubscription = $id;
      return 0;
    }

    public function idIsSubcribed($id='0'){
      if($id=='0')
        return $this->_idIsSubcribed;
      else
        $this->_idIsSubcribed = $id;
      return 0;
    }


    public function dateSubscription($date = '0',$action ='0'){
      if($date == '0' && $action=='0')
        return date('Y\-m\-j H:i:s',$this->_dateSubscription);
      else if($action == 0){
        $this->_dateSubscription = strtotime($date);
      }else{
        return date('Y\-m\-j H:i',$this->_dateSubscription);

      }
      return 0;
    }

    public function dateEndSubscription($date = '0',$action ='0'){
      if($date == '0' && $action=='0')
        return date('Y\-m\-j H:i:s',$this->_dateEndSubscription);
      else if($action == 0){
        $this->_dateEndSubscription = strtotime($date);
      }else{
        return date('Y\-m\-j H:i',$this->_dateEndSubscription);

      }
      return 0;
    }



}



class IsSubMng{

  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function add(IsSub $val){
    $query = $this->_db->prepare("INSERT INTO ISSUBSCRIBED (email,idSubscription,dateSubscription,dateEndSubscription)
                                  VALUES (:email,:idSubscription,:dateSubscription,:dateEndSubscription) ");
    $query->execute( [
      "email"=>$val->email(),
      "idSubscription"=>$val->idSubscription(),
      "dateSubscription"=>$val->dateSubscription(),
      "dateEndSubscription"=>$val->dateEndSubscription()
      ]);
  }

/*
  public function update(IsSub $val){
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
*/

}
?>
