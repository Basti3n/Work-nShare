<?php
session_start();
require "../function.php";
require "../object/subscription.php";

if(isAdmin() || isSuperAdmin()){

  if( count($_POST)==1 && isset($_POST["idSubscription"]) ){
    $db=connectDb();
    $subscriptionMng = new SubscriptionMng($db);
    $subscription = $subscriptionMng->get( $_POST["idSubscription"]);




    echo json_encode($subscription->right('getAll'));

  }else{
    echo "failure";
  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page";
}
