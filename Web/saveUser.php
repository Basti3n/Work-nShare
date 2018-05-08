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
	$user = new User(null);

	if ($user->name($_POST["name"]))
		$error = true;

	if ($user->lastname($_POST["surname"]))
		$error = true;

	if ($user->password($_POST["pwd"],$_POST["pwd2"]))
		$error = true;

	if($user->Email($_POST["email"],$_POST["email2"]))
		$error = true;

	/*Verification du captcha
	$api_url = "https://www.google.com/recaptcha/api/siteverify"
								."?secret="."6Lc8MUwUAAAAAK6RaVXkOcu0CeDB1Dze4FUDUBWI" 	// Ma clé privée
								."&response=".$_POST['g-recaptcha-response'] 						// Paramètre renvoyé par le recaptcha
								."&remoteip=".$_SERVER['REMOTE_ADDR']; 									// On récupère l'IP de l'utilisateur
	$decode = json_decode(file_get_contents($api_url), true);
	if ($decode['success'] != true) {
		$error = true;
		$user->listOfErrors[] = 8;
	}*/

	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $user->listOfErrors;
		header("Location: signup.php");
	}else{
		$user->emailCheck("generate");
	 	exec('QRcodegen\bin\Debug\QRcodegen.exe '.$user->email());
		$db = connectDb();
		$manage = new UserMng($db);
		$manage->add($user);
		emailConfirmation($user->email(),$user->name(),$user->emailCheck(1));

		header("Location: login.php");
	}

}else{
	die("Access denied, we know who you are and where you live : ".$_SERVER['REMOTE_ADDR']);
}
