<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Signup</title>

    <?php require "link.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="container">
      <div class="page-header">
        <h2>Inscrivez-vous !</h2>
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
          <form method="POST" action="saveUser.php" class="form-horizontal" name="register">

            <div class="form-group">
              <label class="control-label col-md-2" for="name">Nom:</label>
                <div class="col-md-9">
                  <input type="text" class="form-control emptycheck" id="name" name="name" placeholder="Entrez votre nom" required="required" value="<?php echo(isset ($dataForm["name"]))?$dataForm["name"]:"";?>">
                  <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2" for="surname">Prénom:</label>
                <div class="col-md-9">
                  <input type="text" class="form-control emptycheck" id="surname" name="surname" placeholder="Entrez votre prénom" required="required" value="<?php echo(isset ($dataForm["surname"]))?$dataForm["surname"]:"";?>">
                  <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2" for="email">Email:</label>
                <div class="col-md-9">
                  <input type="email" class="form-control emailcheck" id="emaili" name="email" placeholder="Entrez votre adresse email" required="required" value="<?php echo(isset ($dataForm["email"]))?$dataForm["email"]:"";?>">
                  <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2" for="email2">Confirmation:</label>
                <div class="col-md-9">
                  <input type="email" class="form-control emailcheck" id="emaili2" name="email2" placeholder="Confirmez votre adresse email" required="required" value="<?php echo(isset ($dataForm["email2"]))?$dataForm["email2"]:"";?>">
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

            <div class="form-group">
              <label class="control-label col-md-2" for="pwd2">Confirmation:</label>
                <div class="col-md-9">
                  <input type="password" class="form-control emptycheck" id="pwdi2" name="pwd2" placeholder="Confirmez votre mot de passe" required="required">
                  <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2" for="captcha">Captcha:</label>
                <div class="col-md-9">
                  <div class="g-recaptcha" name="captcha" data-sitekey="6Lc8MUwUAAAAAIKq3_LrET3W9XIYYxGUvEw7nas2"></div>
                  <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label label-text">
                <input type="checkbox" name="check"> <span class="label-text"><a href="#" target="_blank">J'accepte les CGU</a></span>
                <i class="fa fa-times errorfield" style="visibility: hidden" aria-hidden="true" ></i>
              </label>
            </div>


            <input class="btn mybutton btn-lg btn-block" type="submit" value="inscription" onclick="check()">
          </form>
        </div>

      </section>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
