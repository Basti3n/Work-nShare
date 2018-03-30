<?php
date_default_timezone_set('Europe/Paris');

class User
{
  private $_name = "Empty";
  private $_lastname = "Empty";
  private $_dateSignUp;
  private $_email;
  private $_password;
  private $_isdeletedUser = 0;
  public $listOfErrors = [];

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value){
      switch ($key) {
        case 'email':
          $this->Email($value);
          break;
        case 'nameUser':
          $this->name($value);
          break;
        case 'lastnameUser':
          $this->lastname($value);
          break;
        case 'dateSignUp':
          $this->dateSignup($value);
          break;
        case 'passwordUser':
          $this->password($value);
          break;
        case 'isDeleted':
          $this->deletedUser($value);
          break;

      }
      /*$method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
        $this->$method($value);*/
    }
  }

  //Le prenom doit faire plus de 2 caractères et au max 50
  public function name($name = '0'){
    if($name == '0')
      return $this->_name;
    trim($name);
    if (strlen($name)<2 || strlen($name) > 50) {
      //trigger_error("Le nom saisie est trop long", E_USER_ERROR);
      $this->listOfErrors[] = 1;
      return 1;
    }
    $this->_name = $name;
    return 0;
  }

  //Le nom de famille doit faire plus de 2 caractères et au max 50
  public function lastname($lastname = '0'){
    if($lastname == '0')
      return $this->_lastname;
    trim($lastname);
    if (strlen($lastname)<2 || strlen($lastname) > 80) {
      //trigger_error("Le nom de famille saisie est trop long", E_USER_ERROR);
      $this->listOfErrors[] = 2;
      return 1;
    }
    $this->_lastname = $lastname;
    return 0;
  }

//Le mot de passe doit faire plus de 8 caractères et au max 64 et confirmation correspondante
  public function password($password = '0',$confirm = '0'){
    if($password == '0' && $confirm == '0')
      return $this->_password;
    if (strlen($password) < 7 || strlen($password) > 64) {
      trigger_error("Le mot de passe saisie est trop long", E_USER_ERROR);
      $this->listOfErrors[] = 4;
      return 1;
    }
    if ($password != $confirm && $confirm != '0') {
      $this->listOfErrors[] = 5;
      return 1;
    }
    if (!preg_match("/[a-z]/i", $password))
      trigger_error("Mot de passe sans lettres", E_USER_WARNING);
    if (!preg_match("/[0-9]/i", $password))
      trigger_error("Mot de passe sans chiffre", E_USER_WARNING);
    if (!preg_match("/[A-Z]/", $password))
      trigger_error("Mot de passe sans majuscules", E_USER_WARNING);
    if (!preg_match('/\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\[|\{|\]|\}|\||\\|\'|\<|\,|\.|\>|\?|\/|\""|\;|\:|\s/i', $password))
      trigger_error("Mot de passe sans caractère spéciaux", E_USER_WARNING);

    //echo "pwd : ".password_verify("apple",$password)."<br>";
    $this->_password = password_hash($password,PASSWORD_DEFAULT);
    return 0;
  }

  public function dateSignup($date = '0'){
    if($date == '0')
      return date('j \/ m \/ Y',$this->_dateSignUp);
    else{
      $this->_dateSignUp = strtotime($date);
    }
    return $this->_dateSignUp;
  }

  //email valide à la regex et confirmation correspondante, ainsi que non inscrit
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

  public function deletedUser($value = '0'){
    if($value == '0')
      return $this->_isdeletedUser;
    if($value != 0 || $value != 1)
      return 1;
    else{
      $this->_isdeletedUser = $value;
    }
    return 0;
  }

  public function speak(){
    echo  "<br>\$_name : ".$this->_name.
          "<br>\$_lastname : ".$this->_lastname.
          "<br>\$_dateSignUp : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_dateSignUp).
          "<br>\$_email : ".$this->_email.
          "<br>\$_password : ".$this->_password;
  }

}

/**
 * Obligatoire pour la gestion de l'objet (norme)
 */
class UserMng
{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function add(User $user){
    $date = date("y-m-d");
    $query = $this->_db->prepare("INSERT INTO USERS (email,nameUser,lastnameUser,dateSignUp,passwordUser,isdeletedUser,statusUser,qrCode,qrCodeToken)
                                  VALUES (:email,:name, :lastname,NOW(),:pwd,:deleted,3,:qrCode,:qrCodeToken) ");
    $qrCode = password_hash($_POST["email"],PASSWORD_DEFAULT);
		$query->execute( [
			"name"=>$user->name(),
			"lastname"=>$user->lastname(),
			"email"=>$user->email(),
			"pwd"=>$user->password(),
      "deleted"=>$user->deletedUser(),
			"qrCode"=>$qrCode,
			"qrCodeToken"=>"data/qrCode/qrCode.png"
			]);
  }

  public function update(User $user, $id = '0'){
    if ($id == '0')
      $id = $user->email();
    $date = date("y-m-d");
    //Update all associate branches
    if($user->email() != $id){
      /*
      $assoc = $this->_db->prepare(" UPDATE TICKETS INNER JOIN ISSUBSCRIBED INNER JOIN ACCESS INNER JOIN EXITSPACE INNER JOIN RESERVATION
                                     ON TICKETS.email = ISSUBSCRIBED.email = ACCESS.email = EXITSPACE.email = RESERVATION.email
                                     SET TICKETS.email=:nemail, ISSUBSCRIBED.email=:nemail, ACCESS.email=:nemail, EXITSPACE.email=:nemail, RESERVATION.email=:nemail
                                     WHERE TICKETS.email=:email");*/
      $assoc = $this->_db->prepare(" UPDATE TICKETS SET email=:email WHERE email=:id");
      $assoc->execute( [ "email"=>$user->email(), "id"=>$id ]);
      $assoc = $this->_db->prepare(" UPDATE ISSUBSCRIBED SET email=:email WHERE email=:id");
      $assoc->execute( [ "email"=>$user->email(), "id"=>$id ]);
      $assoc = $this->_db->prepare(" UPDATE ACCESS SET email=:email WHERE email=:id");
      $assoc->execute( [ "email"=>$user->email(), "id"=>$id ]);
      $assoc = $this->_db->prepare(" UPDATE EXITSPACE SET email=:email WHERE email=:id");
      $assoc->execute( [ "email"=>$user->email(), "id"=>$id ]);
      $assoc = $this->_db->prepare(" UPDATE RESERVATION SET email=:email WHERE email=:id");
      $assoc->execute( [ "email"=>$user->email(), "id"=>$id ]);
      }
    $query = $this->_db->prepare("UPDATE USERS
                                  SET email=:email,nameUser=:name,lastnameUser=:lastname,passwordUser=:pwd,statusUser=3,qrCode=:qr
                                  WHERE email=:id");
    $qrCode = password_hash($user->email(),PASSWORD_DEFAULT);
		$query->execute( [
			"name"=>$user->name(),
			"lastname"=>$user->lastname(),
			"email"=>$user->email(),
			"pwd"=>$user->password(),
			"qr"=>$qrCode,
      "id"=>$id
			]);
  }

  public function delete(User $user){
    $date = date("y-m-d");
    $query = $this->_db->prepare('UPDATE USERS SET isdeletedUser = 1 WHERE email =:email');
		$query->execute( ["email"=>$user->email()]);
    $user->deletedUser(1);
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
}

?>
