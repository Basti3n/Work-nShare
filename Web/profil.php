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
  </head>
  <body>
    <?php require "header.php" ?>

    <div class="container">
		&nbsp;
    <?php
      $db = connectDb();
      $mng = new UserMng($db);
      $user = $mng->get("invis@gmail.com");
      echo "<br>";
      $user->speak();
      //print_r($user->listOfErrors);

    ?>
	</div>
    <?php require "footer.php"; ?>
  </body>
</html>
