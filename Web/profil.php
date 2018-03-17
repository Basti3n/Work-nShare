<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PROFIL</title>

    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>

    <div class="container">
		&nbsp;
    <?php
      include "object/event.php";
      include "object/user.php";
      include "object/settings.php";
      echo "_____________";
      $hentai = new Event;
      $hentai->setName("kawaiii");
      $hentai->startDate(12,02,1998);
      $hentai->endDate(12,02,1999);
      $hentai->speak();

      echo "<br>_____________";
      $user = new User;
      $user->Name("Be");
      $user->Lastname("Rousval");
      $user->Date();
      $user->Email("salope@gmail.com","salope@gmail.com");
      $user->Password("zfzfzffazfz 4554","zfzfzffazfz 4554");
      //$user->speak();
      echo "<br>";
      //echo $user->Password();
      print_r($user->listOfErrors);

    ?>
	</div>
    <?php require "footer.php"; ?>
  </body>
</html>
