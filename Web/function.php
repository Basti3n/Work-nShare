<?php

require_once "conf.inc.php";

//Mail
function emailConfirmation($email, $name, $email_check){

	$subjet = "Activation de votre compte" ;
	$header = "From: noreply@worknshare.com" ;
	$message = 'Bienvenue chez Worknshare,'.$name.' !
	Vous pouvez confirmer votre email de compte en cliquant sur ce lien : '.'http://localhost/Work-nShare/Web/emailConfirmed.php?email='.urlencode($email).'&email_check='.urlencode($email_check).'
	Si vous avez des questions à propos de Worknshare, vous êtes libre de nous envoyer un mail à lesbg@worknshare.net. Ce message est un message automatique, veuillez ne pas répondre !\n

	Amicalement,

	L\'équipe Worknshare ';
	mail('invisible.amc@gmail.com', $subjet, $message, $header) ;
}

function emailConfirmed(){
  $db = connectDb();
	$req = $db->prepare('SELECT email_check FROM USERS WHERE email=:email');
	$req->execute(["email"=>$_GET["email"]]);
  $success = $req->fetch(PDO::FETCH_ASSOC);
	if ($_GET["email_check"] == $success["email_check"] && !empty($_GET["email_check"])){
		return true;
	}else{
		return false;
  }
}

function showArray($array){
   echo "<pre>";
   print_r($array);
   echo "</pre>";
 }

 function connectDb(){
   try{
     $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     }catch(Exception $e){
       die("Erreur SQL : ".$e->getMessage());
     }
     return $db;
 }

 function noAccents($str, $charset='utf-8')
 {
     $str = htmlentities($str, ENT_NOQUOTES, $charset);

     $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
     $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
     $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

     return $str;
 }

 function exist($element, $table, $column){
    $db = connectDb();
    $verify = $db->prepare("SELECT 1 FROM $table WHERE $column = :element");
    $verify->execute(["element"=>$element]);
    if($verify->rowCount()){
      return true;
    }
    else return false;
  }


  function isSuperAdmin(){
    if(isConnected()){
      $db = connectDb();
      $admin = $db->prepare("SELECT statusUser FROM USERS WHERE email = :email");
      $admin->execute(["email"=>$_SESSION['email']]);
      $admin = $admin->fetch();
      if($admin["statusUser"] == 0){
        return true;
      }
      else return false;
    }
    else return false;
  }



  function isAdmin(){
    if(isConnected()){
      $db = connectDb();
      $admin = $db->prepare("SELECT statusUser FROM USERS WHERE email = :email");
      $admin->execute(["email"=>$_SESSION['email']]);
      $admin = $admin->fetch();
      if($admin["statusUser"] == 1){
        return true;
      }
      else return false;
    }
    else return false;
  }


  function isEmployee(){
    if(isConnected()){
      $db = connectDb();
      $admin = $db->prepare("SELECT statusUser FROM USERS WHERE email = :email");
      $admin->execute(["email"=>$_SESSION['email']]);
      $admin = $admin->fetch();
      if($admin["statusUser"] == 2){
        return true;
      }
      else return false;
    }
    else return false;
  }


  function isConnected(){


  	if(!empty($_SESSION["accessToken"]) && !empty($_SESSION["email"])){
  		$db = connectDb();
  		$checkSession = $db->prepare("SELECT 1 FROM USERS WHERE email=:email AND accessToken = :accessToken");
  		$checkSession->execute([
  								"email"=>$_SESSION["email"],
  								"accessToken"=>$_SESSION["accessToken"]
  								]);

  		if($checkSession->rowCount()){
  			$_SESSION["accessToken"] = generateAccessToken($_SESSION["email"]);
  			return true;
  		}
  		else{
  			logout();
  			return false;
  		}


  	}else{
      return false;
    }
  }


  function logout($redirect = false){
  	$db = connectDb();
    try {
      $out = $db->prepare("UPDATE USERS SET accessToken = null WHERE email = :email");
    	$out->execute(["email"=>$_SESSION["email"]]);
    } catch(Exception $e) {
        echo "PDOException : " . $e->getMessage();
    }
  	unset($_SESSION["accessToken"]);
  	unset($_SESSION["email"]);

  	if($redirect){
  		header("Location: index.php");
  	}
  }

  function generateAccessToken($email){
  	$db = connectDb();
  	//modification de la bdd avec un nouvel access token
  	$accessToken = MD5(uniqid()."ytklfuirkysrteqzBlackLama<sfrfG<ZE4RHF7DV<84GEAD");
  	//inserer en bdd le token
  	$addToken = $db->prepare("UPDATE USERS set accessToken = :accessToken WHERE email = :email");
  	$addToken->execute(["accessToken" => $accessToken, "email"=>$email]);
  	//stocker dans une variable de session le token
  	return $accessToken;
  }


//SERVICE.PHP
  $site = array(
  "Bastille"=>array(
    "Surface Laptop",
    "Surface Pro"
  ),
  "République"=>array(
    "Surface Laptop",
    "Surface Pro",
    "Surface Pro 2 "
  ),
  "Odéon"=>array(
    "Surface Laptop",
    "Surface Pro",
    "Mac book pro"
  ),
  "Place d'Italie"=>array(
    "Surface Laptop",
    "Surface Laptop 2 ",
    "Surface Pro"
  ),
  "Beaubourg"=>array(
    "Surface Laptop",
    "Surface Pro",
    "Mac book air"
  ),
);

  $service = array(
    "Matériel informatique",
    "Salle de reunion",
    "Salle d'appel",
    "Plateau repas"
  );
