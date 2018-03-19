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

	if($user->isDeleted()){

	}
*/
	$account = $db->prepare("SELECT passwordUser, isDeleted FROM USERS WHERE email = :email");
	$account -> execute(["email"=>$_POST["email"]]);
	$pwdv = $account->fetch();
	if(!$pwdv["isDeleted"]){
		if(!empty($account)){
			if(password_verify($_POST["pwd"], $pwdv['passwordUser'])){
				$accessToken = MD5(uniqid()."ytklfuirkysrteqzBlackLama<sfrfG<ZE4RHF7DV<84GEAD");
				$addToken = $db->prepare("UPDATE USERS set accessToken = :accessToken WHERE email = :email AND isDeleted = 0");
				$addToken->execute(["accessToken" => $accessToken, "email"=>$_POST["email"]]);
				$_SESSION["accessToken"] = $accessToken;
				$_SESSION["email"] = $_POST["email"];

				header("Location: index.php");
			}else{
				$error = true;
				$listOfErrors[] = 17;
			}
		}
	}
	else{
		$error = true;
		$listOfErrors[] = 19;
	}

	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $listOfErrors;
		header("Location: login.php");
	}
