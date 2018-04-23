<?php
  require "conf.inc.php";
  require "function.php";
  require "object/user.php";
  require "object/spaces.php";
  require "object/services.php";
  require "object/serviceContents.php";
  require "object/ticket.php";


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - Profil</title>

    <?php require "head.php" ?>
    <link rel="stylesheet" type="text/css" href="CSS/profil.css">
    <link rel="stylesheet" type="text/css" href="CSS/admin.css">

  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="row">
        <div class="col-md-3" >
            <div class="list-group text-center" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action list-group-item-dark active" id="spaces-list" data-toggle="tab" href="#spaces" role="tab" aria-controls="spaces">Espace</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="services-list" data-toggle="tab" href="#services" role="tab" aria-controls="services">Services</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="events-list" data-toggle="tab" href="#events" role="tab" aria-controls="events">Evènement</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="database-list" data-toggle="tab" href="#database" role="tab" aria-controls="database">Base de données</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="tickets-list" data-toggle="tab" href="#tickets" role="tab" aria-controls="historique">Tickets</a>
            </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane tabcontent fade show active in" id="spaces" role="tabpanel" aria-labelledby="spaces-list">
              <div class="container col-md-12">
                <div style="margin-top:2%;">
                  <button class="btn btn-primary" id="addSpaceButton">Ajouter un espace</button>
                </div>

                  <br>
                <div id="spaceDiv">
                  <?php
                    $db = connectDb();
                    $spaceMng = new SpaceMng($db);
                    $spaces = $spaceMng->getAllSpaces();
                  ?>

                  <?php if(!empty($spaces)) :?>
                    <table class="table" id="spaceArray">
                      <tbody id="spaceArrayBody">
                      <tr>
                                <th>Id de L'espace</th>
                                <th>Nom de l'espace</th>
                                <th>Créer un service</th>
                                <th>Créer un évènement</th>
                                <th>Désactiver l'espace</th>
                                <th>Valider les modifications</th>

                      </tr>
                      <?php
                        foreach ($spaces as $space) {
                          echo '<tr>
                                  <td>'.$space->idSpace().'</td>
                                  <td><input type="text" id="'.$space->idSpace().'NameSpace" value="'.utf8_encode($space->nameOfSpace()).'"></td>
                                  <td>'.'<button onclick="displayCreateServicePannel(\''.$space->idSpace().'\')" >Ajouter un service</button>'.'</td>
                                  <td>'.'<button>Ajouter un évènement</button>'.'</td>
                                  <td> <input id="'.$space->idSpace().'isDeleted" type="checkbox" '.($space->isDeleted()?"checked":"").'></td>
                                  <td> <button onclick="updateSpace(\''.$space->idSpace().'\')">Valider </button> </td>

                                </tr>';
                        }
                          //
                      ?>
                    </tbody>
                    </table>
                  <?php else :?>
                  <?php endif;?>
                </div>
              </div>
            </div>
            <div class="tab-pane tabcontent fade" id="services" role="tabpanel" aria-labelledby="services-list">



              <div class="container col-md-12">

                <div class="row buttonRow" >
                    <select id="serviceTypeSelector" onchange="changeServiceType()">
                      <option value="1">Services</option>
                      <option value="2">Service contents</options>
                    </select>
                    <button class="btn btn-primary" id="addServiceButton">Ajouter un type de Service</button>
                    <button class="btn btn-primary" id="addServiceContentButton">Ajouter un service</button>
                </div>
                <br>
                <div id="servicesDiv" class="">
                  <?php
                    $db = connectDb();
                    $serviceMng = new ServiceMng($db);
                    $services = $serviceMng->getAllServices();
                  ?>

                  <?php if(!empty($services)) :?>
                    <table class="table" id ="serviceArray">
                      <tr>
                                <th>Nom du service général</th>
                                <th>Information complémentaire</th>
                                <th>Espace du service</th>
                                <th>Disponible</th>
                                <th>Supprimé</th>
                                <th>Valider les modifications</th>

                      </tr>
                      <?php
                        foreach ($services as $service) {


                          echo '<tr>
                                  <td><input type="text" id="'.$service->idService().'NameService" value="'.utf8_encode($service->nameOfService()).'"></td>
                                  <td><textarea class="compInfoTextArea" id="'.$service->idService().'CompInfoService">'.utf8_encode($service->compInfo()).'</textarea></td>
                                  <td>
                                    <select id="'.$service->idService().'ServiceSpaceId">';
                                    foreach ($spaces as $key => $space) {
                                      echo "<option value='".$space->idSpace()."'   ".($service->idSpace()==$space->idSpace()? "selected":"")."    >".utf8_encode($space->nameOfSpace())."</option>";
                                    }
                          echo      '</select>
                                  </td>
                                  <td><input id="'.$service->idService().'IsBookedService" type="checkbox" '.($service->isBooked()?"checked":"").'></td>
                                  <td><input id="'.$service->idService().'IsDeletedService" type="checkbox" '.($service->isDeleted()?"checked":"").'></td>
                                  <td> <button onclick="updateService(\''.$service->idService().'\')">Valider </button> </td>
                                </tr>';
                        }

                      ?>
                    </table>
                  <?php else :?>
                  <?php endif;?>
                </div>

                <div id="serviceContentsDiv" class="hidden">
                  <?php
                    $db = connectDb();
                    $serviceContentMng = new ServiceContentMng($db);
                    $serviceContents = $serviceContentMng->getAllServiceContents();
                  ?>

                  <?php if(!empty($serviceContents)) :?>

                    <table class="table" id ="serviceContentArray">
                      <tr>
                                <th>Nom du service</th>
                                <th>Information complémentaire</th>
                                <th>Service concerné</th>
                                <th>Disponible</th>
                                <th>Supprimé</th>
                                <th>Valider les modifications</th>

                      </tr>
                      <?php
                        foreach ($serviceContents as $serviceContent) {

                          echo '<tr>
                                  <td><input type="text" id="'.$serviceContent->idServiceContent().'NameServiceContent" value="'.utf8_encode($serviceContent->nameServiceContent()).'"></td>
                                  <td><textarea class="compInfoTextArea" id="'.$serviceContent->idServiceContent().'InformationServiceContent">'.utf8_encode($serviceContent->informationServiceContent()).'</textarea></td>
                                  <td><select id="'.$serviceContent->idServiceContent().'ServiceContentServiceId">';
                                  foreach ($services as $key => $service) {
                                    echo "<option value='".$service->idService()."'  ". ( $service->idService()==$serviceContent->idService()? "selected":"") ."  >".utf8_encode($service->nameOfService())."</option>";
                                  }

                          echo        '</select></td>
                                  <td><input type="number" id="'.$serviceContent->idServiceContent().'IsFreeServiceContent" value="'.($serviceContent->isFree()).'"></td>
                                  <td><input id="'.$serviceContent->idServiceContent().'IsDeletedServiceContent" type="checkbox" '.($serviceContent->isDeleted()?"checked":"").'></td>
                                  <td> <button onclick="updateServiceContent(\''.$serviceContent->idServiceContent().'\')">Valider </button> </td>
                                </tr>';
                        }
                      ?>
                    </table>
                  <?php else :?>
                  <?php endif;?>
                </div>
              </div>
            </div>
            <div class="tab-pane tabcontent fade" id="events" role="tabpanel" aria-labelledby="events-list">
              <div class="container col-md-12">
                <p>Evènements</p>
              </div>
            </div>
            <div class="tab-pane tabcontent fade" id="database" role="tabpanel" aria-labelledby="database-list">
                <select id="tableSelect" onchange="changeTable()">
                  <option value="users">Utilisateur</option>
                  <option value="spaces">Espace</option>
                  <option value="services">Modèle service</option>
                  <option value="service_content">Service</option>
                  <option value="tickets">Tickets</option>
                  <option value="subscriptions">Abonnement</options>
                  <option value="reservation">Réservation</options>
                  <option value="equipments">Equipement</options>
                </select>

              <br>
              <div class="container col-md-12" id="databaseContainer">

                <!--
                <table class="table" id ="dbUsers">
                  <tr>
                            <th>Email</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date inscription</th>
                            <th>Status</th>
                            <th>Supprimé</th>
                            <th>Valider les modifications<th>

                  </tr>


                  <?php
                  /*
                  $db = connectDb();
                  $users = new UserMng($db);
                  $users = $users->getAll();


                    foreach ($users as $user) {

                      echo '<tr>
                              <td><input type="text" id="'.$user->email().'Email" value="'.utf8_encode($user->email()).'"></td>
                              <td><input type="text" id="'.$user->email().'LastName" value="'.utf8_encode($user->lastName()).'"></td>
                              <td><input type="text" id="'.$user->email().'Name" value="'.utf8_encode($user->name()).'"></td>
                              <td>'.$user->dateSignUp().'</td>
                              <td><select>';
                              foreach ($statusUserArray as $key => $statusUser) {
                                echo "<option value='".$key."'  ". ( $user->statusUser()==$key? "selected":"") ."  >".$statusUser."</option>";
                              }
                      echo    '</select></td>
                              <td><input id="'.$user->email().'IsDeletedUser" type="checkbox" '.($user->deletedUser()?"checked":"").'></td>
                              <td> <button onclick="updateUser(\''.$user->email().'\')">Valider </button> </td>
                            </tr>';
                    }*/
                    ?>
                </table>
              -->
              </div>
            </div>
            <div class="tab-pane fade" id="tickets" role="tabpanel" aria-labelledby="tickets-list">
              <div class="container col-md-12">
                <h1>Tickets</h1>
                <div class="row">
                  <div class="col-xs-8">
                    <?php
                      $db = connectDb();
                      $ticketMng = new TicketMng($db);
                      $tickets = $ticketMng->getAllTickets();
                      //showArray($tickets);
                    ?>

                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Catégorie</th>
                        <th>Message</th>
                        <th>Date début</th>
                        <th>Dernier message</th>
                        <th>Correspondant</th>
                        <th>Etat</th>
                      </tr>
                      <?php
                        foreach ($tickets as $ticket) {
                          echo '<tr onclick="displayTicket('.$ticket->idTicket().',\''.$_SESSION["email"].'\','.$ticket->statusTicket().','.$ticket->idPrimaryTicket().')">
                                    <td>'.$ticket->idTicket().'</td>
                                    <td>'.$ticket->ticketCategory().'</td>
                                    <td>'.$ticket->contentTicket().'</td>
                                    <td>'.$ticket->dateTicket().'</td>
                                    <td>'.$ticketMng->getLastMEssageDate($ticket).'</td>
                                    <td>'.$ticket->email().'</td>
                                    <td>'.$statusTicket[$ticket->statusTicket()].'</td>
                                </tr>';
                        }
                      ?>
                    </table>
                  </div>

                  <div class="col-xs-4">
                    <div id="ticketAdvancedInfo">
                      <div class ="row" id="ticketInformation">
                          <div class="col-xs-3" id="idTicketAdvancedInfo">
                            <?php
                              echo "ID :".$tickets[2]->idTicket();
                            ?>
                          </div>

                          <div class="col-xs-9" id="emailSenderAdvancedInfo">
                            <?php
                              echo "Correspondant :".$tickets[2]->email();
                            ?>
                          </div>
                       </div>
                      <br>
                      <div id="ticketAdvancedInfoHistorique">
                        <?php
                          $ticketsAdvanced = $ticketMng->getAllTickets($tickets[2]->idTicket());
                          echo '<div class="ticketAdvancedMessage receiver">'.$tickets[2]->contentTicket().'</div>';
                          foreach($ticketsAdvanced as $ticketAdvanced){
                            if($ticketAdvanced->ticketSenderStatus()== 0){
                              echo '<div class="ticketAdvancedMessage receiver">'.$ticketAdvanced->contentTicket().'</div>';
                            }else{
                              echo '<div class="ticketAdvancedMessage sender">'.$ticketAdvanced->contentTicket().'</div>';
                            }
                          }
                        ?>
                      </div>
                      <br>
                      <div>
                        <div class="form-group">
                          <label for="ticketAnswer">Réponse</label>
                          <textarea class="form-control" id="ticketAnswer" rows="4"></textarea>
                        </div>
                      </div>

                      <div>
                        <div class="row">
                          <div class="col-xs-6">
                            Etat :
                            <select id="ticketStatusSelect" onchange="updateTicketStatus(<?php $tickets[2]->idTicket()?>)">
                              <?php
                                foreach ($statusTicket as $key =>  $status) {
                                  echo "<option value='".$key."'  ". ( $tickets[2]->statusTicket()==$key? "selected":"") ."  >".$status."</option>";
                                }
                              ?>
                            </select>
                          </div>


                          <div class="col-xs-6">
                            <div class="form-group row">
                              <div class="col-md-7 col-sm-10 ">
                                <button  id="ticketSendingButton" class="btn btn-primary" onclick="sendAnswer(<?php echo $tickets[2]->idTicket();echo ",'"; echo $_SESSION['email']."'";?>)"  >Envoyer</button>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
            <!--  <div class="container col-md-12">
                <p>Disable</p>
              </div>-->
          </div>


            <!--Create space pannel -->
            <div id="createSpacePannel" class="hidden">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createSpaceForm">
                    <input type="text" placeholder="L'id en 7 caractères de votre espace" id="newSpaceId"><br>
                    <input type="text" placeholder="Le nom de votre espace" id="newSpaceName"><br>
                    <button class="btn btn-primary" onclick="createSpace()">Valider</button>
                    <button class="btn btn-primary"  id="cancelCreateSpaceButton">Annuler</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Create Space pannel-->

            <!--Create service pannel-->
            <div class="pannel hidden" id="createServicePannel">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createServiceForm">
                    <input type="text" placeholder="Le nom de votre service" id="newServiceName"><br>
                    <textarea placeholder="Information complémentaire de votre service" id="newServiceCompInf"></textarea>
                    <br>
                    <select id="spaceSelector">

                        <?php
                          foreach ($spaces as $key => $space) {
                            echo "<option value='".$space->idSpace()."'>".$space->nameOfSpace()."</option>";
                          }
                         ?>
                    </select>
                    <br>

                    <button class="btn btn-primary" onclick="createService()">Valider</button>
                    <button class="btn btn-primary"  id="cancelCreateServiceButton">Annuler</button>
                  </div>
                </div>
              </div>
            </div>
            <!--End create service pannel-->


            <!--Create service content pannel-->
            <div class="pannel hidden" id="createServiceContentPannel">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createServiceContentForm">
                    <input type="text" placeholder="Le nom de votre service content" id="newServiceContentName"><br>
                    <input type="number" id="newServiceContentNumber" placeholder="Nombre disponible pour votre service content"> </input>
                    <br>
                    <textarea placeholder="Information  de votre service content" id="newServiceContentInformation"></textarea>
                    <br>
                    <select id="serviceSelector">

                        <?php
                          foreach ($services as $key => $service) {
                            echo "<option value='".$service->idService()."'>".utf8_encode($service->nameOfService())."</option>";
                          }
                         ?>
                    </select>
                    <br>

                    <button class="btn btn-primary" onclick="createServiceContent()">Valider</button>
                    <button class="btn btn-primary"  id="cancelCreateServiceContentButton">Annuler</button>
                  </div>
                </div>
              </div>
            </div>
            <!--End create service content pannel-->


        </div>
      </div>
    </div>
    <?php require "footer.php"; ?>
    <script type="text/javascript" src="js/admin.js"> </script>
  </body>
</html>
