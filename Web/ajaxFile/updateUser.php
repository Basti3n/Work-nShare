<?php
session_start();
require "../function.php";
require "../object/user.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==6 && isset($_POST["email"]) && isset( $_POST["newEmail"])
    && isset($_POST["lastname"]) && isset( $_POST["name"])
    && isset($_POST["status"]) && isset( $_POST["isDeleted"])){
    $db=connectDb();
    $user = new User(null);
    $error = false;
    $listOfErrors = [];

    showArray($_POST);

    if($user->email( $_POST["newEmail"]) )
      echo "1";

    if($user->name( $_POST["name"]))
      echo "2";

    if($user->lastname( $_POST["lastname"]))
      echo "3";

    if($user->deletedUser(  ($_POST["isDeleted"]== "true"?1:0)   ) )
      echo "4";

    if($user->statusUser( $_POST["status"]))
      echo "5";

    $listOfErrors = $user->listOfErrors;
    showArray($listOfErrors);
    if(!$error){
      $userMng = new UserMng($db);
      $userMng->update($user,$_POST["email"]);
      echo "OK";
    }else{
      echo "Erreur à la mise à jour de l'utilisateur";
    }

  }
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
