<?php
  require "conf.inc.php";
  require "function.php";
  include "object/user.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>admin</title>
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
            <a class="list-group-item list-group-item-action list-group-item-dark active" id="list-services-list" data-toggle="list" href="#list-services" role="tab" aria-controls="services">Services</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-events-list" data-toggle="list" href="#list-events" role="tab" aria-controls="events">Evènement</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-spaces-list" data-toggle="list" href="#list-spaces" role="tab" aria-controls="spaces">Site</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-database-list" data-toggle="list" href="#list-database" role="tab" aria-controls="database">Base de données</a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-tickets-list" data-toggle="list" href="#list-tickets" role="tab" aria-controls="tickets">Tickets</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-services" role="tabpanel" aria-labelledby="list-services-list"> Services </div>
            <div class="tab-pane fade" id="list-events" role="tabpanel" aria-labelledby="list-events-list"> Evènements </div>
            <div class="tab-pane fade" id="list-spaces" role="tabpanel" aria-labelledby="list-spaces-list"> Site </div>
            <div class="tab-pane fade" id="list-database" role="tabpanel" aria-labelledby="list-database-list"> Base de données  </div>
            <div class="tab-pane fade" id="list-tickets" role="tabpanel" aria-labelledby="list-tickets-list"> Tickets </div>

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
