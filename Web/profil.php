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
    <div class="inner">
      <div class="col-md-3" id="navbar">
        <?php // IDEA: https://getbootstrap.com/docs/4.0/components/list-group/ ?>
        <div class="row">
          <div class="col-4">
            <div class="list-group text-center" id="list-tab" role="tablist">
              <div class="list-group-item list-group-item-action list-group-item-dark" id="rest"></div>
              <a class="list-group-item list-group-item-action list-group-item-dark active" id="list-general-list" data-toggle="list" href="#list-general" role="tab" aria-controls="general">Informations générales</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="list-abonnement-list" data-toggle="list" href="#list-abonnement" role="tab" aria-controls="abonnement">Abonnement</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="list-services-list" data-toggle="list" href="#list-services" role="tab" aria-controls="services">Services</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="list-historique-list" data-toggle="list" href="#list-historique" role="tab" aria-controls="historique">Historique</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="list-desactive-list" data-toggle="list" href="#list-desactive" role="tab" aria-controls="desactive">Désactiver son compte</a>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-general" role="tabpanel" aria-labelledby="list-general-list">...</div>
              <div class="tab-pane fade show" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
              <div class="tab-pane fade" id="list-abonnement" role="tabpanel" aria-labelledby="list-abonnement-list">...</div>
              <div class="tab-pane fade" id="list-services" role="tabpanel" aria-labelledby="list-services-list">...</div>
              <div class="tab-pane fade" id="list-historique" role="tabpanel" aria-labelledby="list-historique-list">...</div>
              <div class="tab-pane fade" id="list-desactive" role="tabpanel" aria-labelledby="list-desactive-list">...</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="container col-md-12">
          <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
            <h4>&nbsp;&nbsp;Informations generales </h4>
          </div>
          <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
            <h4>QRCODE</h4>
          </div>
        </div>
        <div class="container col-md-10">
            <?php
              $db = connectDb();
              $mng = new UserMng($db);
              $user = $mng->get($_SESSION["email"]);
            ?>
          <div class="col-md-8">
            <p style="color:grey;">Inscrit depuis le : <?php echo $user->Date(); ?></p>
            <div class="row text-center" id="contentTab">
              <div class="col-md-9">
                <form>
                  <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label"> Prénom</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="text" class="form-control" id="name" placeholder="<?php echo $user->Name(); ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="lastname" class="col-sm-4 col-form-label">Nom</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="text" class="form-control" id="lastname" placeholder="<?php echo $user->Lastname();?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="email" class="form-control" id="email" placeholder="<?php echo $user->Email(); ?>">
                    </div>
                  </div>
                  <p style="color:grey;text-align:left;">Modifier votre mot de passe actuel<hr></p>
                  <div class="form-group row">
                    <label for="pwdbefore" class="col-sm-4 col-form-label">Mot de passe actuel</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="password" class="form-control" id="pwdbefore" placeholder="*********">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pwdafter" class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="password" class="form-control" id="pwdafter" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pwdafter2" class="col-sm-4 col-form-label">Confirmation</label>
                    <div class="col-sm-8 col-md-auto">
                      <input type="password" class="form-control" id="pwdafter2" placeholder="Password">
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <div class="col-md-7 col-sm-10 ">
                      <button type="submit" class="btn btn-primary">Confirmer les modifications</button>
                    </div>
                    <div class="col-md-3 col-sm-10">
                      <button type="reset" class="btn btn-primary">Annuler</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="container" style="font-size:15em">
              <i class="fas fa-barcode"></i>
            </div>
          </div>
        </div>
      </div>
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
