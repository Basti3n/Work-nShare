<?php
  require "conf.inc.php";
  require "function.php";
  include "object/user.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - Profil</title>

    <?php require "head.php" ?>
    <link rel="stylesheet" type="text/css" href="CSS/profil.css">
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="col-md-3" id="navbar">
      <?php // IDEA: https://getbootstrap.com/docs/4.0/components/list-group/ ?>
      <div class="row">
        <div class="col-4">
          <div class="list-group text-center" id="list-tab" role="tablist">
            <div class="list-group-item list-group-item-action list-group-item-dark" id="rest"></div>
            <a class="list-group-item list-group-item-action list-group-item-dark active" id="list-general-list" data-toggle="list" href="#list-general" role="tab" aria-controls="general">Informations général</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-abonnement-list" data-toggle="list" href="#list-abonnement" role="tab" aria-controls="abonnement">Abonnement</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-services-list" data-toggle="list" href="#list-services" role="tab" aria-controls="services">Services</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-historique-list" data-toggle="list" href="#list-historique" role="tab" aria-controls="historique">Historique</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-desactive-list" data-toggle="list" href="#list-desactive" role="tab" aria-controls="desactive">Désactiver son compte</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-general" role="tabpanel" aria-labelledby="list-general-list">...</div>
            <div class="tab-pane fade" id="list-abonnement" role="tabpanel" aria-labelledby="list-abonnement-list">...</div>
            <div class="tab-pane fade" id="list-services" role="tabpanel" aria-labelledby="list-services-list">...</div>
            <div class="tab-pane fade" id="list-historique" role="tabpanel" aria-labelledby="list-historique-list">...</div>
            <div class="tab-pane fade" id="list-desactive" role="tabpanel" aria-labelledby="list-desactive-list">...</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 container text-center" id="contentTab">
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>

    <!--<?php
      $db = connectDb();
      $mng = new UserMng($db);
      $user = $mng->get("invis@gmail.com");
      echo "<br>";
      $user->speak();
    ?>-->
    <?php require "footer.php"; ?>
  </body>
</html>
