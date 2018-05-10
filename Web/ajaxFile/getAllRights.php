<?php
  session_start();
  require "../function.php";
  require "../object/subscription.php";

  header('content-type: application/json');
  $db = connectDb();
  $subscriptionMng = new SubscriptionMng($db);
  $subscriptions = $subscriptionMng->getAll();
  $rightArray = [];

  foreach ($subscriptions as $key => $value) {
    if(!empty($value->right("getAll")))
      foreach (array_keys($value->right("getAll")) as $keykey => $id) {
        if(!in_array($id,$rightArray) )
         array_push($rightArray,$id);
      }
  }

  //showArray($spacesArray);
  echo json_encode($rightArray);
