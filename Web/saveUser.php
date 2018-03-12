<?php
session_start();
include "function.php";
require_once "conf.inc.php";

if( count($_POST) == 6
	&& isset($_POST["name"])
	&& isset($_POST["surname"])
	&& !empty($_POST["email"])
	&& !empty($_POST["pwd"])
	&& !empty($_POST["pwd2"])
	&& !empty($_POST["legacy"]) ){

	$error = false;
	$listOfErrors = [];

	$_POST["name"] = trim($_POST["name"]);
	$_POST["surname"] = trim($_POST["surname"]);
	$_POST["email"] = trim($_POST["email"]);

	//Le name doit faire plus de 2 caractères et au max 50
	if( strlen($_POST["name"]) <2 ||  strlen($_POST["name"])>50 ){
		$error = true;
		$listOfErrors[] = 1;
	}

	//Le prénom doit faire plus de 2 caractères et au max 50
	if( strlen($_POST["surname"])<2 ||  strlen($_POST["surname"])>50 ){
		$error = true;
		$listOfErrors[] = 2;
	}



	//Le mot de passe doit faire plus de 8 caractères et au max 64
	if( strlen($_POST["pwd"])<8 ||  strlen($_POST["pwd"])>64 ){
		$error = true;
		$listOfErrors[] = 4;
	}

	//La confirmation doit correspondre
	if( $_POST["pwd"] != $_POST["pwd2"] ) {
		$error = true;
		$listOfErrors[] = 5;
	}

	//Email
	if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
		$error = true;
		$listOfErrors[] = 6;
	}


	$db = connectDb();

	$email_verif = $db->prepare("SELECT email FROM USERS WHERE email = :email");
	$email_verif->execute(["email"=> $_POST["email"]]);
	$resultat = $email_verif->fetch();
	if (!empty($resultat)) {

		$error = true;
		$listOfErrors[] = 15;

	}


	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $listOfErrors;
		header("Location: signup.php");
	}else{
	  $date = date("y-m-d");
    $query = $db->prepare(" INSERT INTO USERS (email,nameUser,surnameUser,dateSignIn,passwordUser,isDeleted,statusUser,qrCode,qrCodeToken)
     VALUES (:email,:name, :surname,CURDATE(),:pwd,0,3,:qrCode,:qrCodeToken) ");
		$pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $qrCode = password_hash($_POST["email"],PASSWORD_DEFAULT);
		$query->execute( [
			"name"=>$_POST["name"],
			"surname"=>$_POST["surname"],
			"email"=>$_POST["email"],
			"pwd"=>$pwd,
			"qrCode"=>$qrCode,
			"qrCodeToken"=>"data/qrCode/qrCode.png"
			]);
		header("Location: login.php");
	}

}else{

	die("Access denied, we know who you are and where you live : ".$_SERVER['REMOTE_ADDR']);

}
