<?php
session_start();
include "function.php";
include "object/user.php";
require_once "conf.inc.php";

if( count($_POST) == 8
	&& isset($_POST["name"])
	&& isset($_POST["surname"])
	&& !empty($_POST["email"])
	&& !empty($_POST["email2"])
	&& !empty($_POST["pwd"])
	&& !empty($_POST["pwd2"])
	&& !empty($_POST["check"])
	&& !empty($_POST["g-recaptcha-response"]) ){

	$error = false;
	$listOfErrors = [];
	$user = new User;


	if ($user->Name($_POST["name"]))
		$error = true;

	if ($user->Lastname($_POST["surname"]))
		$error = true;

	if ($user->Password($_POST["pwd"],$_POST["pwd2"]))
		$error = true;

	if($user->Email($_POST["email"],$_POST["email2"]))
		$error = true;

	//Verification du captcha
	$api_url = "https://www.google.com/recaptcha/api/siteverify"
								."?secret="."6Lc8MUwUAAAAAK6RaVXkOcu0CeDB1Dze4FUDUBWI" 	// Ma clé privée
								."&response=".$_POST['g-recaptcha-response'] 						// Paramètre renvoyé par le recaptcha
								."&remoteip=".$_SERVER['REMOTE_ADDR']; 									// On récupère l'IP de l'utilisateur
	$decode = json_decode(file_get_contents($api_url), true);
	if ($decode['success'] != true) {
		$error = true;
		$listOfErrors[] = 8;
	}

	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $user->listOfErrors;
		header("Location: signup.php");
	}else{
		$db = connectDb();
		$manage = new UserMng($db);
		$manage->add($user);
		
		header("Location: login.php");
	}

}else{
	die("Access denied, we know who you are and where you live : ".$_SERVER['REMOTE_ADDR']);
}
