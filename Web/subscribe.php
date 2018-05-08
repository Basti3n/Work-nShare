<?php
require_once "conf.inc.php";
include_once "function.php";
require_once 'object/subscription.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SUBSCRIBE</title>

    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="container">
        &nbsp;
        <?php
        $db = connectDb();
        $mng = new SubscriptionMng($db);
        $o = $mng->get(3);
        $o->speak();
         ?>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
