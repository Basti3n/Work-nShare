<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Event</title>
    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>

		<div class="inner container">
      <div class="page-header">
        <h2>Connexion !</h2>
      </div>
        <section class="row">  <!-- CREATE ACCOUNT -->
          <?php if(isset($_SESSION["errors_form"])){
                  echo '<div class="errorList col-xs-12"><div><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><ul>';
                  foreach ($_SESSION["errors_form"] as $error) {
                    echo "<li>".$listOfErrors[$error];
                  }
                  echo "</ul></div></div>";
                  $dataForm = $_SESSION["data_form"];
                  unset($_SESSION["errors_form"]);
                }
          ?>
          <div class="col-md-offset-3 col-md-6 col-xs-12 col-sm-12">
            <form method="POST" action="checkLogin.php" class="form-horizontal" name="login">

              <div class="form-group">
                <label class="control-label col-md-2" for="email">Email:</label>
                  <div class="col-md-9">
                    <input type="email" class="form-control emailcheck" id="emaili" name="email" placeholder="Entrez votre adresse email" required="required" value="<?php echo(isset ($dataForm["email"]))?$dataForm["email"]:"";?>">
                    <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2" for="pwd">Mot de passe:</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control emptycheck" id="pwdi" name="pwd" placeholder="Entrer votre mot de passe  (entre 8 et 64 caractères)" required="required">
                    <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                  </div>
              </div>

              <input class="btn mybutton btn-lg btn-block" type="submit" value="Connexion">
            </form>
          </div>

        </section>
			</div>
    <?php require "footer.php"; ?>
  </body>
</html>
