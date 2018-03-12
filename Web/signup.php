<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Signup</title>

    <?php require "link.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="container login">
      	<div class="row">
      		<div class="formulaire col-md-offset-4 col-md-4">
      			<h1 class="inscriptionTitle">INSCRIPTION</h1>
      			<form method="POST" action="saveUser.php">

      				<?php

      					if( !empty($_SESSION["errorsForm"]) ){

      						echo "<ul>";
      						foreach ($_SESSION["errorsForm"] as $error) {

      							echo "<li>".$listOfErrors[$error];
      						}
      						echo "</ul>";
      						$dataForm = $_SESSION["dataForm"];
      					 	unset($_SESSION["errorsForm"]);
      					}
      				?>
      				<br>
      				<input type="text" name="name" placeholder="Votre nom" value="<?php echo (isset($dataForm["name"]))?$dataForm["name"]:""; ?>" id="name"><br>
      				<input type="text" name="surname" placeholder="Votre prénom" value="<?php echo (isset($dataForm["surname"]))?$dataForm["surname"]:""; ?>" id="prenom"><br>
      				<input type="email" name="email" placeholder="Votre email" required="required" value="<?php echo (isset($dataForm["email"]))?$dataForm["email"]:""; ?>" id="email"><br>

      				<br>
      				<input type="password" name="pwd" placeholder="Saisissez votre mot de passe" required="required" id="pwd"><br>
      				<input type="password" name="pwd2" placeholder="Confirmer votre mot de passe" required="required" id="pwd2"><br>

      				<br>
      				<label>
                J'accèpte les  <a href="cgu.php" target="blank">CGUs</a>
                <input type="checkbox" name="legacy" required="required">
              </label>
              <br>
      				<input type="submit" value="S'inscrire">
      			</form>
      		</div>
      	</div>

	  </div>
    <?php require "footer.php"; ?>
  </body>
</html>
