<?php
	session_start();
	require_once "conf.inc.php";
	include_once "function.php";
	include_once "object/user.php";

	$db = connectDb();

	$error = false;
	$listOfErrors = [];

	$mng = new UserMng($db);
	$user = $mng->get($_POST["email"]);

	if(!$user->deletedUser()){
		//echo "check : ".$user->emailCheck("1")."<br>";
		if ($user->emailCheck()) {
			$accessToken = MD5(uniqid()."ytklfuirkysrteqzBlackLama<sfrfG<ZE4RHF7DV<84GEAD");
			$addToken = $db->prepare("UPDATE USERS set accessToken = :accessToken WHERE email = :email");
			$addToken->execute(["accessToken" => $accessToken, "email"=>$user->email()]);
			$_SESSION["accessToken"] = $accessToken;
			$_SESSION["email"] = $user->email();

			header("Location: index.php");
		}else {
			$error = true;
			$listOfErrors[] = 21;
		}
	}else{
		$error = true;
		$listOfErrors[] = 13;
	}

	if($error){
		$_SESSION["dataForm"] = $_POST;
		$_SESSION["errorsForm"] = $listOfErrors;
		header("Location: login.php");
	}
