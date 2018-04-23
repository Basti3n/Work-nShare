<?php
  session_start();
  require "../function.php";
  require "../object/user.php";

  header('content-type: application/json');
  $db = connectDb();
  $users = new UserMng($db);
  $users = $users->getAll();
  $usersArray = [];
  $tempArray = ["email"=>"empty",
                "name"=>"empty",
                "lastName"=>"empty",
                "dateSignup"=>0,
                "isDeleted"=>-1,
                "statusUser"=>-1,
              ];
  foreach ($users as $user) {

    $tempArray["email"] = $user->email();
    $tempArray["name"] = $user->name();
    $tempArray["lastName"] = $user->lastname();
    $tempArray["dateSignup"] = $user->dateSignup();
    $tempArray["isDeleted"] = $user->deletedUser();
    $tempArray["statusUser"] = $user->statusUser();

    array_push($usersArray, $tempArray );
    //showArray($user);
  }
  //showArray($usersArray);
  echo json_encode($usersArray);
