<?php
session_start();
require "function.php";
require_once "conf.inc.php";

if (emailConfirmed()) {
  $db = connectDb();
  $req = $db->prepare('UPDATE USERS SET email_check=1 WHERE email=:email;');
  $success = $req->execute(["email"=>$_GET["email"]]);
  header("Location: index.php");
} else {
	die ( "Erreur lors de la validation de l'email. Veuillez réessayer ultérieurement.");
}
