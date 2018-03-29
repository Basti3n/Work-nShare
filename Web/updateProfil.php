<?php
  session_start();
  require "conf.inc.php";
  require "function.php";
  include "object/user.php";

  $db = connectDb();
  $mng = new UserMng($db);


  $error = 0;

  //$user->speak();
  $user = unserialize($_SESSION["user"]);
  $id = $user->Email();

  if (array_key_exists("ok", $_POST)) {
    $mng->delete($user);
  }else{
    if( isset($_POST["name"])){
      if ($user->Name() != $_POST["name"])
        if ($user->Name($_POST["name"]))
          $error = true;
    }
    if( isset($_POST["lastname"])){
      if ($user->Lastname() != $_POST["lastname"])
        if ($user->Lastname($_POST["lastname"]))
          $error = true;
    }
    if( isset($_POST["email"])){
      if ($user->Email() != $_POST["email"])
        if ($user->Email($_POST["email"]))
          $error = true;
    }
    if( isset($_POST["pwd"])   &&
        isset($_POST["npwd1"]) &&
        isset($_POST["npwd2"])){
        //if (password_verify($_POST["pwd"], $user->Password() ) ){
          if ($_POST["npwd2"] != $_POST["npwd1"])
            $error = true;
          if ($user->Password($_POST["npwd1"]))
            $error = true;
        //}else{
        //  $error = true;
        //}
    }

    if ($error == false) {
      $mng->update($user,$id);
      header("Location: profil.php");
    }else {
      echo "<br> Error : ";
      print_r($user->listOfErrors);

    }

  }


?>
