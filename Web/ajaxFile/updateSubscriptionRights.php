<?php
session_start();
require "../function.php";
require "../object/subscription.php";


if(isAdmin() || isSuperAdmin()){
  showArray($_POST);
  if( count($_POST)==2 && isset($_POST["idSubscription"]) && isset( $_POST["right"])  ){
    $db=connectDb();
    $subscriptionMng = new SubscriptionMng($db);
    if($subscriptionMng->updateRights($_POST["idSubscription"] ,  $_POST["right"])){
      echo "Fail";
    }else{
      echo "Success";
    }

  }else{
    echo "not ok";
  }
}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
