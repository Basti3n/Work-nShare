<?php
date_default_timezone_set('Europe/Paris');

class User
{
  private $_name = "Empty";
  private $_lastname = "Empty";
  private $_dateSignUp;
  private $_email;
  private $_password;

  public function setName($name){
    if (strlen($name) > 50) {
      trigger_error("Le nom saisie est trop long", E_USER_ERROR);
      return;
    }
    $this->_name = $name;
  }

  public function setLastname($lastname){
    if (strlen($lastname) > 80) {
      trigger_error("Le nom de famille saisie est trop long", E_USER_ERROR);
      return;
    }
    $this->_lastname = $lastname;
  }

  public function setDate(){
    $this->_dateSignUp = date('U');
  }

  public function setEmail($email){
    if (strlen($email) > 80) {
      trigger_error("L'email saisie est trop long", E_USER_ERROR);
      return;
    }
    $this->_email = $email;
  }

  public function setPassword($password){
    if (strlen($password) > 255) {
      trigger_error("Le mot de passe saisie est trop long", E_USER_ERROR);
      return;
    }
    //echo "t'es beau ta race : ".password_verify("apple",$password)."<br>";
    $this->_password = $password;
  }


  public function speak(){
    echo  "<br>\$_name : ".$this->_name.
          "<br>\$_lastname : ".$this->_lastname.
          "<br>\$_dateSignUp : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_dateSignUp).
          "<br>\$_email : ".$this->_email.
          "<br>\$_password : ".$this->_password;
  }

}
?>
