<?php 
  require "head.php";
  include "object/event.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - EVENT</title>
    <link rel="stylesheet" type="text/css" href="CSS/event.css">
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="container">
        <div id="eventList">
        <?php
          $db = connectDb();
          $mng = new EventMng($db);
          $mng->writeText($mng->getAll());
        ?>
        </div>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
