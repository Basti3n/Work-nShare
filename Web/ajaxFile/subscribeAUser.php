<?php
session_start();
require "../function.php";
require "../object/isSubscribed.php";


if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==4 && isset($_POST["email"]) && isset( $_POST["idSubscription"])
                        && isset($_POST["subscribeAUserDateEnd"]) && isset( $_POST["subscribeAUserDateBegin"]) ){
    $db=connectDb();
    $isSub = new IsSub(null);

    $error = false;
    $listOfErrors = [];
    if($isSub->email($_POST["email"]))
      $error = true;

    if($isSub->idSubscription($_POST["idSubscription"]))
      $error = true;

    if($isSub->dateSubscription($_POST["subscribeAUserDateEnd"]))
      $error = true;

    if($isSub->dateEndSubscription($_POST["subscribeAUserDateBegin"]))
      $error = true;

    if($error){
      echo "failure";
    }else{
      $isSubMng = new IsSubMng($db);
      $isSubMng->add($isSub);
    }
  }else{
    echo "failure";
  }

}else{
  echo "Vous n'êtes pas autorisé à entrer sur cette page";
}
