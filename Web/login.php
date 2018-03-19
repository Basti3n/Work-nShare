<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Event</title>
    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>

			<div class="container login">
				<div class="row">
					<div class="formulaire col-md-offset-4 col-md-4">
						<center>
							<h1>CONNEXION</h1>
						</center>
						<form method="POST" action="checkLogin.php">
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
							<center>
									<label for="email"> </label> <input type="email" name="email" placeholder="Votre email" required="required" id="email"  value="<?php echo (isset($dataForm["email"]))?$dataForm["email"]:""; ?>"><br>
							</center>
							<center>
								<label  for="pwd"></label> <input type="password" name="pwd" placeholder="Saisissez votre mot de passe" required="required" id="pwd"><br>
							</center>
							<center>
								<input type="submit" value="Se connecter">
							</center>
						</form>
					</div>
				</div>
			</div>
    <?php require "footer.php"; ?>
  </body>
</html>
