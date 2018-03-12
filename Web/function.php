<?php

require_once "conf.inc.php";


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
      if($admin["status"] == 0){
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
      if($admin["status"] == 1){
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
      if($admin["status"] == 2){
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

  	$out = $db->prepare("UPDATE USERS SET accessToken = null WHERE email = :email");
  	$out->execute(["email"=>$_SESSION["email"]]);

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
