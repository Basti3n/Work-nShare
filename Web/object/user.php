<?php
date_default_timezone_set('Europe/Paris');

class User
{
  private $_name = "Empty";
  private $_lastname = "Empty";
  private $_dateSignUp;
  private $_email;
  private $_password;
  public $listOfErrors = [];

  public function hydrate(array $data){
    foreach ($data as $key => $value){
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
        $this->$method($value);
    }
  }

  //Le prenom doit faire plus de 2 caractères et au max 50
  public function Name($name = '0'){
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
  public function Lastname($lastname = '0'){
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
  public function Password($password = '0',$confirm = '0'){
    if($password == '0' && $confirm == '0')
      return $this->_password;
    if (strlen($password) < 8 || strlen($password) > 64) {
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

  public function Date(){
    $this->_dateSignUp = date("y-m-d");
    return $this->_dateSignUp;
  }

  //email valide à la regex et confirmation correspondante, ainsi que non inscrit
  public function Email($email = '0', $confirm = '0'){
    if($email == '0' && $confirm == '0')
      return $this->_email;
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

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }

  public function add(User $user){
    $date = date("y-m-d");
    $query = $this->_db->prepare("INSERT INTO USERS (email,nameUser,surnameUser,dateSignIn,passwordUser,isDeleted,statusUser,qrCode,qrCodeToken)
                                  VALUES (:email,:name, :surname,CURDATE(),:pwd,0,3,:qrCode,:qrCodeToken) ");
    $qrCode = password_hash($_POST["email"],PASSWORD_DEFAULT);
		$query->execute( [
			"name"=>$user->Name(),
			"surname"=>$user->Lastname(),
			"email"=>$user->Email(),
			"pwd"=>$user->Password(),
			"qrCode"=>$qrCode,
			"qrCodeToken"=>"data/qrCode/qrCode.png"
			]);
  }

  public function delete(User $user){
    $date = date("y-m-d");
    $query = $this->_db->prepare('UPDATE USERS SET isDeleted = 1 WHERE email =:email');
		$query->execute( ["email"=>$user->Email()]);
  }

  public function get($email){
    $query = $this->_db->query('SELECT email,nameUser,surnameUser,dateSignIn,password FROM USERS WHERE email = '.$email);
    $data = $query->fetch(PDO::FETCH_ASSOC);

    return new User($data);
  }
}

?>
