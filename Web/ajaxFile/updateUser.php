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
      $error = true;

    if($user->name( $_POST["name"]))
      $error = true;

    if($user->lastname( $_POST["lastname"]))
      $error = true;

    if($user->deletedUser(  ($_POST["isDeleted"]== "true"?1:0)   ) )
      $error = true;

      
    echo "OK";
  }
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
