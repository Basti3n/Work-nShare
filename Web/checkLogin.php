<?php
	session_start();
	require_once "conf.inc.php";
	include_once "function.php";

	$db = connectDb();

	$error = false;
	$listOfErrors = [];

/*
	$mng = new UserMng;
	$user = new User($mng->get($_POST["email"]));

	if($user->isDeletedUser()){

	}
*/
	$account = $db->prepare("SELECT passwordUser, isDeletedUser FROM USERS WHERE email = :email");
	$account -> execute(["email"=>$_POST["email"]]);
	$pwdv = $account->fetch();
	if(!$pwdv["isDeletedUser"]){
		if(!empty($account)){
			if(password_verify($_POST["pwd"], $pwdv['passwordUser'])){
				$accessToken = MD5(uniqid()."ytklfuirkysrteqzBlackLama<sfrfG<ZE4RHF7DV<84GEAD");
				$addToken = $db->prepare("UPDATE USERS set accessToken = :accessToken WHERE email = :email AND isDeletedUser = 0");
				$addToken->execute(["accessToken" => $accessToken, "email"=>$_POST["email"]]);
				$_SESSION["accessToken"] = $accessToken;
				$_SESSION["email"] = $_POST["email"];

				header("Location: index.php");
			}else{
				$error = true;
				$listOfErrors[] = 12;
			}
		}
	}
	else{
		$error = true;
		$listOfErrors[] = 13;
	}

	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $listOfErrors;
		header("Location: login.php");
	}
