<?php
session_start();
require "../function.php";
require "../object/subscription.php";

if(isAdmin() || isSuperAdmin()){
  if( count($_POST)==5 && isset($_POST["name"]) && isset( $_POST["monthly"])  && isset( $_POST["dayPrice"])
                        && isset( $_POST["firstHour"])  && isset( $_POST["halfHour"]) ){
    $db=connectDb();
    $subscription = new Subscription(null);

    $error = false;
    if($subscription->name($_POST["name"]))
      $error = true;

    if($subscription->monthly($_POST["monthly"]))
      $error = true;

    if($subscription->dayPrice($_POST["dayPrice"]))
      $error = true;

    if($subscription->firstHour($_POST["firstHour"]))
      $error = true;

    if($subscription->halfHour($_POST["halfHour"]))
      $error = true;


    if($subscription->isDeleted(1))
      $error = true;

    if($error){
      echo "Fail";
    }else{
      $subscriptionMng = new SubscriptionMng($db);
      $subscriptionMng->add($subscription);
    }

  }else{
    echo "Fail";
  }

}else{
  echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
