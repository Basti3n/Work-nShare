<?php
  require "conf.inc.php";
  require "function.php";
  include "object/user.php";
  include "object/ticket.php";
  include "object/reservation.php";
  include "object/equipment.php";

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
      <div class="row">
        <div class="col-md-3" >
            <div class="list-group text-center" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action list-group-item-dark active" id="general-list" data-toggle="tab" href="#general" role="tab" aria-controls="general">Informations générales</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="messages-list" data-toggle="tab" href="#messages" role="tab" aria-controls="messages">Messages</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="abonnement-list" data-toggle="tab" href="#abonnement" role="tab" aria-controls="abonnement">Abonnement</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="services-list" data-toggle="tab" href="#services" role="tab" aria-controls="services">Services</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="historique-list" data-toggle="tab" href="#historique" role="tab" aria-controls="historique">Historique</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="desactive-list" data-toggle="tab" href="#desactive" role="tab" aria-controls="desactive">Désactiver son compte</a>
            </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show tabcontent active" id="general" role="tabpanel" aria-labelledby="general-list">
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
                    $_SESSION["user"] = serialize($user);
                  ?>
                <div class="col-md-7">
                  <p style="color:grey;">Inscrit depuis le : <?php echo $user->dateSignup(); ?></p>
                  <div class="row text-center" id="contentTab">
                    <div class="col-md-11">
                      <form action="updateProfil.php" method="post">
                        <div class="form-group row">
                          <label for="name" class="col-sm-4 col-form-label"> Prénom</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo $user->name(); ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="lastname" class="col-sm-4 col-form-label">Nom</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="<?php echo $user->lastname();?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-4 col-form-label">Email</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo $user->email(); ?>">
                          </div>
                        </div>
                        <p style="color:grey;text-align:left;">Modifier votre mot de passe actuel<hr></p>
                        <div class="form-group row">
                          <label for="pwdbefore" class="col-sm-4 col-form-label">Mot de passe actuel</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="password" name="pwd" class="form-control" id="pwdbefore" placeholder="*********">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="pwdafter" class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="password" name="npwd1" class="form-control" id="pwdafter" placeholder="password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="pwdafter2" class="col-sm-4 col-form-label">Confirmation</label>
                          <div class="col-sm-8 col-md-auto">
                            <input type="password" name="npwd2" class="form-control" id="pwdafter2" placeholder="password">
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
                <div class="col-md-5">
                  <div class="col-md-12">
                    <?php
              				if(file_exists("Qrcode_".$user->email().".bmp"))
              					echo '<a href="Qrcode_'.$user->email().'.bmp" target="_blank"><img id="qr" src="Qrcode_'.$user->email().'.bmp" height="400" width="400"></a>';
                		?>
                  </div>
                  <div class="col-md-offset-3 col-md-5" style="padding-top:10px;">
                    <a class="btn btn-primary" href="<?php echo 'Qrcodes/Qrcode_'.$user->email().'.bmp'; ?>" download="MyQRCode_worknshare.bmp"><u>Télécharger votre code</u></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade tabcontent" id="messages" role="tabpanel" aria-labelledby="messages-list">
              <div class="container col-md-12">
                <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                  <h4>&nbsp;&nbsp;Vos messages </h4>
                </div>
              </div>
              <div class="container" id="contain">
                <div class="col-md-12 tablemsg" id="pagresult">
                </div>

                <h2>Nouveau ticket</h2><br>
                <div class="col-md-6">
                  <!--Select , ticket catégories-->

                  <select class="select" id="inputCategoryTicket" onchange="checkIfIsEquipment()">
                    <?php
                    foreach ($tc as $key => $category) {
                      echo "<option>".$category."</option>";
                    }
                    ?>
                  </select>
                  <br>

                  <div class="hidden" id="equipmentSelectDiv">
                    <?php
                      $db = connectDb();
                      $equipmentMng = new EquipmentMng($db);
                      $equipments = $equipmentMng->getAll();
                      //showArray($equipments);
                    ?>

                    <?php if($equipments != 1) :?>
                        <select id="equipmentSelect">
                          <?php foreach ($equipments as $key => $equipment): ?>
                              <?php echo  "<option value =".$equipment->idEquipment().">".$equipment->equipmentName()."</option>"?>
                          <?php endforeach; ?>
                        </select>
                    <?php else :?>
                      Aucun équipement pour l'instant
                    <?php endif;?>
                  </div>


                  <div class="form-group">
                    <label for="inputContentTicket">Contenu</label>
                    <textarea class="form-control" id="inputContentTicket" rows="4"></textarea>
                  </div>

                  <div class="form-group row">
                    <div id="sendTicketButtonDiv" class="col-md-7 col-sm-10 ">
                      <button  class="btn btn-primary" onclick="sendTicket('<?php echo $_SESSION["email"] ?>',-1)" >Envoyer</button>
                    </div>

                    <div class="col-md-6 hidden" id="answerButtonDiv">
                      <button  id="answerButton" class="btn btn-primary" onclick="sendTicket()" >Répondre</button>
                    </div>

                    <div class="col-md-6 hidden" id="cancelAnswerButtonDiv">
                      <button  class="btn btn-primary" >Annuler réponse</button>
                    </div>
                  </div>

                </div>

                <div class="col-md-6 hidden" id="ticketChainDiv">

                </div>


              </div>
            </div>
            <div class="tab-pane fade tabcontent" id="abonnement" role="tabpanel" aria-labelledby="abonnement-list">
              <div class="container col-md-12">
                <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                  <h4>&nbsp;&nbsp;Abonnement </h4>
                </div>
                <div class="container">
                  <div class="col-md-12">
                    <?php
                      $query = $db->prepare('SELECT dateSubscription,dateEndSubscription FROM ISSUBSCRIBED WHERE email =:email');
                      $query->execute( ["email"=>$user->email()]);
                      $data = $query->fetch(PDO::FETCH_ASSOC);
                      if($data){
                        echo "<p>Abonné depuis le: ".date('j \/ m \/ Y', strtotime($data["dateSubscription"]))
                            ." jusqu'au: ".date('j \/ m \/ Y', strtotime($data["dateEndSubscription"]))."</p>";
                      }else {
                        echo "<p>Vous n'êtes pas abonné ! <br></p>";
                        echo "<input class='btn btn-warning' type='button' value='Abonnez-vous dès maintenant !' onclick='abbo()' />";
                      }
                    ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade tabcontent" id="services" role="tabpanel" aria-labelledby="services-list">
              <div class="container col-md-12">
                <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                  <h4>&nbsp;&nbsp;Services </h4>
                </div>
              </div>
              <div class="container">
                <div class="col-md-12">
                  <table class="table table-striped">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Reservation</th>
                        <th scope="col" class="col-md-3">Depuis</th>
                        <th scope="col" class="col-md-3">Jusqu'à</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $resmng = new ReservationMng($db);
                      $reservations = [];
                      $reservations = $resmng->getAllOf($user->email());
                      if ($reservations != 0) {
                        for ($i=0; $i < count($reservations); $i++) {
                          echo "
                          <tr>
                            <th scope='row'>".$i."</th>
                            <td>".$reservations[$i]->idServiceContent()."</td>
                            <td>".date('j\/m\/Y G\h i', strtotime($reservations[$i]->reservationStartDateSignup()))."</td>
                            <td>".date('j\/m\/Y G\h i', strtotime($reservations[$i]->reservationEndDateSignup()))."</td>
                          </tr>";
                        }
                      }else {
                        echo "<p>Rien a afficher pour le moment</p>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade tabcontent" id="historique" role="tabpanel" aria-labelledby="historique-list">
              <div class="container col-md-12">
                <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                  <h4>&nbsp;&nbsp;Historique </h4>
                </div>
              </div>
              <div class="container">
                <div class="col-md-12">
                  <table class="table table-striped">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jour</th>
                        <th scope="col" class="col-md-8">Heures</th>
                        <th scope="col" class="col-md-2">Facture</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      /*
                      $query = $db->prepare('SELECT * FROM ACCESS,EXITSPACE WHERE ACCESS.email =:email and EXITSPACE.email =:email0 ');
                      $query->execute( ["email"=>$user->email(),"email0"=>$user->email()]);
                      $data = $query->fetchAll(PDO::FETCH_ASSOC);
                      print_r($data);
                      if (!empty($data)) {
                        foreach ($data as $key => $value) {
                          echo "
                          <tr>
                            <th scope='row'>".$value["idAccess"]."</th>
                            <td>".date('j\/m\/Y', strtotime($value["dateAccess"]))."</td>
                            <td>Vous êtes allé à <b>".nameOfSpace($value["idSpace"])."</b> de ".date('G\h i', strtotime($value["dateAccess"]))." à ".date('G\h i', strtotime($value["dateExit"]))."</td>
                          </tr>";
                        }*/
                      $query = $db->prepare('SELECT * FROM ACCESS WHERE email =:email');
                      $query->execute( ["email"=>$user->email()]);
                      $data = $query->fetchAll(PDO::FETCH_ASSOC);
                      if (!empty($data)) {
                        foreach ($data as $key => $value) {
                          echo "
                          <tr>
                            <th scope='row'>".$value["idAccess"]."</th>
                            <td>".date('j\/m\/Y', strtotime($value["dateAccess"]))."</td>
                            <td>Vous êtes allé à <b>".nameOfSpace($value["idSpace"])."</b> de ".date('G\h i', strtotime($value["dateAccess"]))." à ".date('G\h i', strtotime($value["dateAccess"]))."</td>
                          </tr>";
                        }
                      }else {
                        echo "<p>Rien a afficher pour le moment</p>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>


              </div>
            </div>
            <div class="tab-pane fade tabcontent" id="desactive" role="tabpanel" aria-labelledby="desactive-list">
              <div class="container col-md-12">
                <div class="text-uppercase text-left font-weight-bold">
                  <h4>&nbsp;&nbsp;Désactiver son compte </h4>
                </div>
                <div class="container">
                  <div class="col-md-12">
                    <h2>Etes vous sur de vouloir supprimer votre compte ?</h2>
                    <form action="updateProfil.php" method="post">
                      <div class="form-group row">
                        <div class="col">
                          <button type="submit" class="btn btn-danger" name="ok">Confirmer</button>
                        </div>
                        <div class="col">
                          <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require "footer.php"; ?>
    <script type="text/javascript" src="JS/profil.js"></script>
  </body>
</html>
