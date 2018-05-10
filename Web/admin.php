<?php
  require "conf.inc.php";
  require "function.php";


  require "object/user.php";
  require "object/spaces.php";
  require "object/services.php";
  require "object/serviceContents.php";
  require "object/ticket.php";
  require "object/equipment.php";
  require "object/event.php";
  require "object/subscription.php";
  require "object/access.php";


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - ADMIN</title>

    <?php require "head.php" ?>
    <link rel="stylesheet" type="text/css" href="CSS/profil.css">
    <link rel="stylesheet" type="text/css" href="CSS/admin.css">

  </head>



  <body>

    <?php require "header.php" ?>

    <?php if( isConnected() && ( isAdmin() || isSuperAdmin() || isEmployee() ) )  :?>

    <div class="inner">
      <div class="row">
        <div class="col-md-3" >
            <div class="list-group text-center" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action list-group-item-dark active" id="spaces-list" data-toggle="tab" href="#spaces" role="tab" aria-controls="spaces">Espace</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="services-list" data-toggle="tab" href="#services" role="tab" aria-controls="services">Services</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="events-list" data-toggle="tab" href="#events" role="tab" aria-controls="events">Evènement</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="database-list" data-toggle="tab" href="#database" role="tab" aria-controls="database">Base de données</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="tickets-list" data-toggle="tab" href="#tickets" role="tab" aria-controls="tickets">Tickets</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="equiments-list" data-toggle="tab" href="#equipements" role="tab" aria-controls="equipements">Equipements</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="subscriptions-list" data-toggle="tab" href="#subscriptions" role="tab" aria-controls="subscriptions">Forfait</a>
              <a class="list-group-item list-group-item-action list-group-item-dark" id="access-list" data-toggle="tab" href="#access" role="tab" aria-controls="access">Accès</a>


            </div>
        </div>
        <div class="col-md-9" id="allMightyContainer" >
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane tabcontent fade show active in" id="spaces" role="tabpanel" aria-labelledby="spaces-list">
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;ESPACES </h4>
              </div>
              <div class="container col-md-12">

                <div style="margin-top:1%;">
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
                                <th>Changer les horraires</th>
                                <th>Valider les modifications</th>

                      </tr>
                      <?php
                        foreach ($spaces as $space) {
                          echo '<tr>
                                  <td>'.$space->idSpace().'</td>
                                  <td><input type="text" class="form-control" id="'.$space->idSpace().'NameSpace" value="'.utf8_encode($space->nameOfSpace()).'"></td>
                                  <td>'.'<button onclick="displayCreateServicePannel(\''.$space->idSpace().'\')" >Ajouter un service</button>'.'</td>
                                  <td>'.'<button>Ajouter un évènement</button>'.'</td>
                                  <td> <input id="'.$space->idSpace().'isDeleted" type="checkbox" '.($space->isDeleted()?"checked":"").'></td>
                                  <td> <button class="btn btn-primary" onclick="displayChangeSchedule(\''.$space->idSpace().'\')">Horaire </button> </td>
                                  <td> <button class="btn btn-primary" onclick="updateSpace(\''.$space->idSpace().'\')">Valider </button> </td>

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
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;SERVICES </h4>
              </div>
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
                                  <td><input type="text" class="form-control" id="'.$service->idService().'NameService" value="'.utf8_encode($service->nameOfService()).'"></td>
                                  <td><textarea class="form-control compInfoTextArea" id="'.$service->idService().'CompInfoService">'.utf8_encode($service->compInfo()).'</textarea></td>
                                  <td>
                                    <select id="'.$service->idService().'ServiceSpaceId">';
                                    foreach ($spaces as $key => $space) {
                                      echo "<option value='".$space->idSpace()."'   ".($service->idSpace()==$space->idSpace()? "selected":"")."    >".utf8_encode($space->nameOfSpace())."</option>";
                                    }
                          echo      '</select>
                                  </td>
                                  <td><input id="'.$service->idService().'IsBookedService" type="checkbox" '.($service->isBooked()?"checked":"").'></td>
                                  <td><input id="'.$service->idService().'IsDeletedService" type="checkbox" '.($service->isDeleted()?"checked":"").'></td>
                                  <td> <button class="btn btn-primary" onclick="updateService(\''.$service->idService().'\')">Valider </button> </td>
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
                                  <td><input type="text" class="form-control" id="'.$serviceContent->idServiceContent().'NameServiceContent" value="'.utf8_encode($serviceContent->nameServiceContent()).'"></td>
                                  <td><textarea class="form-control compInfoTextArea" id="'.$serviceContent->idServiceContent().'InformationServiceContent">'.utf8_encode($serviceContent->informationServiceContent()).'</textarea></td>
                                  <td><select id="'.$serviceContent->idServiceContent().'ServiceContentServiceId">';
                                  foreach ($services as $key => $service) {
                                    echo "<option value='".$service->idService()."'  ". ( $service->idService()==$serviceContent->idService()? "selected":"") ."  >".utf8_encode($service->nameOfService())."</option>";
                                  }

                          echo        '</select></td>
                                  <td><input type="number" id="'.$serviceContent->idServiceContent().'IsFreeServiceContent" value="'.($serviceContent->isFree()).'"></td>
                                  <td><input id="'.$serviceContent->idServiceContent().'IsDeletedServiceContent" type="checkbox" '.($serviceContent->isDeleted()?"checked":"").'></td>
                                  <td> <button class="btn btn-primary" onclick="updateServiceContent(\''.$serviceContent->idServiceContent().'\')">Valider </button> </td>
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
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;EVENEMENTS </h4>
              </div>

              <div class="container col-md-12">

                <div style="margin-top:1%;">
                  <button class="btn btn-primary" id="addEventButton">Ajouter un evènement</button>
                </div>

                  <br>
                <div id="eventDiv">
                  <?php

                    $db = connectDb();
                    $eventMng = new EventMng($db);
                    $events = $eventMng->getAllBackoffice();

                  ?>

                  <?php if( $events != 1) :?>
                    <table class="table" id="eventArray">
                      <tbody id="eventArrayBody">
                      <tr>
                                <th>Nom de l'event</th>
                                <th>Description de l'evenement</th>
                                <th>Date de début</th>
                                <th>Heure de début</th>
                                <th>Date de fin</th>
                                <th>Heure de fin</th>
                                <th>Supprimé</th>
                                <th>Espace</th>
                                <th>Valider les modifications</th>
                      </tr>
                      <?php

                        foreach ($events as $event) {

                          echo '<tr>
                                  <td><input type="text" class="form-control" id="'.$event->idEvent().'NameEvent" value="'.utf8_encode($event->nameEvent()).'"></td>
                                  <td><textarea class="form-control compInfoTextArea" id="'.$event->idEvent().'DescriptionEvent">'.utf8_encode($event->descriptionEvent()).'</textarea></td>
                                  <td><input type="date" value="'.$event->dateStart("0",1).'" id="'.$event->idEvent().'EventDateStart"> </td>
                                  <td><input type="time" value="'.$event->hourStart().'" id="'.$event->idEvent().'EventHourStart"> </td>
                                  <td><input type="date" value="'.$event->dateEnd("0",1).'" id="'.$event->idEvent().'EventDateEnd"> </td>
                                  <td><input type="time" value="'.$event->hourEnd().'" id="'.$event->idEvent().'EventHourEnd"> </td>
                                  <td> <input id="'.$event->idEvent().'isDeletedEvent" type="checkbox" '.($event->isDeleted()?"checked":"").'></td>
                                  <td><select id="'.$event->idEvent().'IdSpaceEvent">';
                                  foreach ($spaces as $key => $space) {
                                    echo "<option value='".$space->idSpace()."'   ".($event->idSpace()==$space->idSpace()? "selected":"")."    >".utf8_encode($space->nameOfSpace())."</option>";
                                  }
                          echo    '</select></td>
                                  <td> <button class="btn btn-primary" onclick="updateEvent(\''.$event->idEvent().'\')">Valider </button> </td>
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
            <div class="tab-pane tabcontent fade" id="database" role="tabpanel" aria-labelledby="database-list">

              <div class="col-md-12 col-sm-12 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;BASE DE DONNEES </h4>

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
                              <td><input type="text" class="form-control" id="'.$user->email().'Email" value="'.utf8_encode($user->email()).'"></td>
                              <td><input type="text" class="form-control" id="'.$user->email().'LastName" value="'.utf8_encode($user->lastName()).'"></td>
                              <td><input type="text" class="form-control" id="'.$user->email().'Name" value="'.utf8_encode($user->name()).'"></td>
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


            </div>
            <div class="tab-pane tabcontent fade" id="tickets" role="tabpanel" aria-labelledby="tickets-list">
              <div class="container col-md-12">


              <div class="container" id="contain">
                <div class="col-md-12 tablemsg" id="pagresult">
                  <div class="col-md-6">
                    <h1>Tickets</h1>
                  </div>
                  <div class="col-md-6">
                    <a class="btn btn-primary" href="<?php exec("java -jar Excel.jar");echo '_out.xls'; ?>" download="tickets_worknshare.xls"><u>Télécharger les tickets</u></a>
                  </div>
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
                            echo '<tr onclick="displayTicket('.$ticket->idTicket().',\''.$_SESSION["email"].'\','.$ticket->statusTicket().','.$ticket->idTicket().')">
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
                      <div id="ticketAdvancedInfo" class="hidden">
                        <div class ="row" id="ticketInformation">
                            <div class="col-xs-3" id="idTicketAdvancedInfo">
                              <?php
                                echo "ID :".$tickets[0]->idTicket();
                              ?>
                            </div>

                            <div class="col-xs-9" id="emailSenderAdvancedInfo">
                              <?php
                                echo "Correspondant :".$tickets[0]->email();
                              ?>
                            </div>
                         </div>
                        <br>
                        <div id="ticketAdvancedInfoHistorique">
                          <?php
                            $ticketsAdvanced = $ticketMng->getAllTickets($tickets[0]->idTicket());
                            echo '<div class="col-md-12"><div class="ticketAdvancedMessage sender">'.$tickets[2]->contentTicket().'</div> </div>';
                            if(($ticketsAdvanced !=1)){
                              foreach($ticketsAdvanced as $ticketAdvanced){
                                if($ticketAdvanced->ticketSenderStatus()== 0){
                                  echo '<div class="col-md-12"><div class="ticketAdvancedMessage sender">'.$ticketAdvanced->contentTicket().'</div> </div>';
                                }else{
                                  echo '<div class="col-md-12"><div class="ticketAdvancedMessage receiver">'.$ticketAdvanced->contentTicket().'</div></div>';
                                }
                              }
                            }

                          ?>
                        </div>
                        <br>
                        <div>
                          <div class="form-group">
                            <label for="ticketAnswer">Réponse</label>
                            <textarea class="form-control form-control" id="ticketAnswer" rows="4"></textarea>
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

              </div>
            </div>
            <div class="tab-pane tabcontent fade" id="equipements" role="tabpanel" aria-labelledby="equipements-list">
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;Equipements </h4>
              </div>

              <div class="container col-md-12">

                <div style="margin-top:1%;">
                  <button class="btn btn-primary" id="addEquipmentButton">Ajouter un matériel</button>
                </div>

                <div id="equipmentDiv">
                  <?php
                    $db = connectDb();
                    $equipmentMng = new EquipmentMng($db);
                    $equipments = $equipmentMng->getAll();
                    //showArray($equipments);
                  ?>

                  <?php if(!empty($equipments)) :?>

                    <table class="table" id="spaceArray">
                      <tbody id="equipmentArrayBody">
                      <tr>
                                <th>Nom de l'équipement</th>
                                <th>Dernière vérification</th>
                                <th>Espace</th>
                                <th>Disponible</th>
                                <th>Supprimé</th>
                                <th>Valider les modifications</th>
                                <th>Maintenance<th>

                      </tr>
                      <?php



                        foreach ($equipments as $equipment) {
                          echo '<tr>
                                  <td><input type="text" class="form-control" id="'.$equipment->idEquipment().'NameEquipment" value="'.utf8_encode($equipment->equipmentName()).'"></td>
                                  <td '.($equipmentMng->checkDate($equipment)?'class="redCell"':'').'>'.$equipment->lastCheckDate('0').'</td>
                                  <td><select id="'.$equipment->idEquipment().'IdSpaceEquipment">';
                                  foreach ($spaces as $key => $space) {
                                    echo "<option value='".$space->idSpace()."'   ".($equipment->idSpace()==$space->idSpace()? "selected":"")."    >".utf8_encode($space->nameOfSpace())."</option>";
                                  }
                          echo    '</select></td>
                                  <td> <input id="'.$equipment->idEquipment().'isFreeEquipment" type="checkbox" '.($equipment->isFree()?"checked":"").'></td>
                                  <td> <input id="'.$equipment->idEquipment().'isDeletedEquipment" type="checkbox" '.($equipment->isDeleted()?"checked":"").'></td>
                                  <td> <button class="btn btn-primary" onclick="updateEquipment(\''.$equipment->idEquipment().'\')">Valider </button> </td>
                                  <td> <button class="btn btn-warning" onclick="updateEquipmentLastDate(\''.$equipment->idEquipment().'\')">Maintenance terminée </button> </td>
                                </tr>';
                        }


                      ?>
                      </tbody>
                    </table>
                  <?php else :?>
                  <?php endif;?>
                </div>
              </div>

            </div>
            <div class="tab-pane tabcontent fade" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-list">
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;Forfait </h4>
              </div>

              <div class="container col-md-12">

                <div style="margin-top:1%;">
                  <button class="btn btn-primary" id="addSubscriptionButton">Ajouter un forfait</button>
                </div>

                <div id="subscriptionDiv">
                  <?php
                    $db = connectDb();
                    $subscriptionMng = new SubscriptionMng($db);
                    $subscriptions = $subscriptionMng->getAll();
                    //showArray($subscriptions);
                  ?>

                  <?php if(!empty($equipments)) :?>


                    <table class="table" id="subscriptionArray">
                      <tbody id="subscriptionArrayBody">
                      <tr>
                                <th>Nom du forfait</th>
                                <th>Prix du mois</th>
                                <th>Prix de la première heure</th>
                                <th>Prix des demi-heures</th>
                                <th>Prix de la journée</th>
                                <th>Liste des droits</th>
                                <th>Supprimé</th>
                                <th>Valider les modifications</th>
                                <th>Modifier les droits</th>

                      </tr>


                      <?php



                        foreach ($subscriptions as $subscription) {
                          echo '<tr>
                                  <td><input type="text" class="form-control" id="'.$subscription->idSubscription().'NameSubscription" value="'.utf8_encode($subscription->name()).'"></td>
                                  <td><input type="number" step="0.01" min="0" id="'.$subscription->idSubscription().'MonthlySubscription" value="'.$subscription->monthly().'"> </td>
                                  <td><input type="number" step="0.01" min="0" id="'.$subscription->idSubscription().'DayPriceSubscription" value="'.$subscription->dayPrice().'"> </td>
                                  <td><input type="number" step="0.01" min="0" id="'.$subscription->idSubscription().'FirstHourPriceSubscription" value="'.$subscription->firstHour().'"> </td>
                                  <td><input type="number" step="0.01" min="0" id="'.$subscription->idSubscription().'HalfHourPriceSubscription" value="'.$subscription->halfHour().'"> </td>
                                  <td>Droit</td>
                                  <td> <input id="'.$subscription->idSubscription().'isDeletedSubscription" type="checkbox" '.($subscription->isDeleted()?"checked":"").'></td>
                                  <td> <button class="btn btn-primary" onclick="updateSubscription(\''.$subscription->idSubscription().'\')">Valider </button> </td>
                                  <td> <button class="btn btn-primary" onclick="updateSubscriptionRights(\''.$subscription->idSubscription().'\')">Modifier </button> </td>

                                </tr>';
                        }


                      ?>
                      </tbody>
                    </table>
                    <?php
                      //showArray($subscriptions);
                    ?>
                  <?php else :?>

                  <?php endif;?>
                </div>
              </div>
            </div>

            <div class="tab-pane tabcontent fade" id="access" role="tabpanel" aria-labelledby="access-list">
              <div class="col-md-6 col-sm-6 text-uppercase text-left font-weight-bold">
                <h4>&nbsp;&nbsp;Accès </h4>
              </div>

              <div class="container col-md-12">

                <div id="subscriptionDiv">
                  <?php
                    $db = connectDb();
                    $accessMng = new AccessMng($db);
                    $accessArray = $accessMng->getAll();
                    //showArray($accessArray);
                  ?>

                  <?php if( $accessArray != 1) :?>


                    <table class="table" id="subscriptionArray">
                      <tbody id="subscriptionArrayBody">
                      <tr>
                                <th>Email</th>
                                <th>Espace</th>
                                <th>Date et heure entrée</th>
                                <th>Date et heure sortie</th>
                                <th>Prix</th>

                      </tr>


                      <?php



                        foreach ($accessArray as $access) {
                          echo '<tr>
                                  <td>'.$access->email().'</td>
                                  <td>'.$spaceMng->getSpaceName($access->idSpace()).' </td>
                                  <td>'.$access->dateAccess("0",1).'</td>
                                  <td>'.$access->dateExit("0",1).' </td>
                                  <td>'.$accessMng->getSubscription($access).' €</td>
                                </tr>';
                        }


                      ?>
                      </tbody>
                    </table>
                    <?php
                      //showArray($subscriptions);
                    ?>


                  <?php else :?>

                  <?php endif;?>
                </div>
              </div>
            </div>


            <!--Create subscription pannel -->
            <div id="createSubscriptionPannel" class="hidden">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createSubscriptionForm">
                    <div class="row">
                      <div class="col-xs-3"></div>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" id="NameNewSubscription" placeholder="Nom du forfait">
                        Prix mensuel    : <input type="number" step="0.01" min="0" id="MonthlyNewSubscription" placeholder="ex : 79,99"> <br>
                        Prix du jour    : <input type="number" step="0.01" min="0" id="DayPriceNewSubscription" placeholder="ex : 9,99"> <br>
                        Prix 1er heure  : <input type="number" step="0.01" min="0" id="FirstHourPriceNewSubscription" placeholder="ex : 7,99"> <br>
                        Prix demi-heure : <input type="number" step="0.01" min="0" id="HalfHourPricNeweSubscription" placeholder="ex : 3,99"><br>
                        <button class="btn btn-primary" onclick="createNewSubscription()">Valider</button>
                        <button class="btn btn-primary"  id="cancelSubscriptionButton">Annuler</button>
                      </div>
                      <div class="col-xs-3"></div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- End Create subscription pannel-->



            <!--Create service pannel-->
            <div class="pannel hidden" id="createEventPannel">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createEventForm">
                    <input type="text" class="form-control" id="NewNameEvent" placeholder="Nom du nouveau evènement">
                    <textarea class="form-control compInfoTextArea" id="NewDescriptionEvent" placeholder="Description de nouveau évènement"></textarea>
                    Date de début :<input type="date"  id="NewEventDateStart">
                    Heure de début : <input type="time"  id="NewEventHourStart">
                    <br>
                    Date de fin :<input type="date"  id="NewEventDateEnd">
                    Heure de fin :<input type="time"  id="NewEventHourEnd">
                    <br>
                    <select id="spaceSelectorNewEvent">
                        <?php
                          foreach ($spaces as $key => $space) {
                            echo "<option value='".$space->idSpace()."'>".utf8_encode($space->nameOfSpace())."</option>";
                          }
                         ?>
                    </select>
                    <br>

                    <button class="btn btn-primary" onclick="createNewEvent()">Valider</button>
                    <button class="btn btn-primary"  id="cancelCreateEventButton">Annuler</button>
                  </div>
                </div>
              </div>
            </div>
            <!--End create service pannel-->



            <!--Create equipment pannel -->
            <div id="createEquipmentPannel" class="hidden">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createEquipmentForm">
                    <div class="row">
                      <div class="col-xs-3"></div>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" placeholder="Nom du matériel" id="newEquipmentName"><br>
                        <select id="spaceSelectorEquipment">
                            <?php
                              foreach ($spaces as $key => $space) {
                                echo "<option value='".$space->idSpace()."'>".utf8_encode($space->nameOfSpace())."</option>";
                              }
                             ?>
                        </select><br><br>
                        <button class="btn btn-primary" onclick="createEquipment()">Valider</button>
                        <button class="btn btn-primary"  id="cancelEquipmentSpaceButton">Annuler</button>
                      </div>
                      <div class="col-xs-3"></div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- End Create equipment pannel-->


            <!--Create space pannel -->
            <div id="createSpacePannel" class="hidden">
              <div class="row">
                <div class="col-xs-12">
                  <div id="createSpaceForm">
                    <input type="text" class="form-control" placeholder="L'id en 7 caractères de votre espace" id="newSpaceId"><br>
                    <input type="text" class="form-control" placeholder="Le nom de votre espace" id="newSpaceName"><br>
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
                    <input type="text" class="form-control" placeholder="Le nom de votre service" id="newServiceName"><br>
                    <textarea placeholder="Information complémentaire de votre service" id="newServiceCompInf"></textarea>
                    <br>
                    <select id="spaceSelector">

                        <?php
                          foreach ($spaces as $key => $space) {
                            echo "<option value='".$space->idSpace()."'>".utf8_encode($space->nameOfSpace())."</option>";
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
                    <input type="text" class="form-control" placeholder="Le nom de votre service content" id="newServiceContentName"><br>
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



            <!--Change schedule div-->
            <div class="pannel hidden" id="changeSpaceSchedulePannel">
              <div class="row">
                <div id="changeSpaceScheduleForm">

                  <div class="col-xs-12">

                    <div class="row">

                      <div class="col-xs-2 offset-xs-3">
                        Lundi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginLundi" >
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndLundi">
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Mardi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginMardi">
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndMardi">
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Mercredi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginMercredi">
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndMercredi" >
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Jeudi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginJeudi" >
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndJeudi">
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Vendredi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginVendredi" >
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndVendredi" >
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Samedi
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginSamedi" >
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndSamedi" >
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-xs-2 offset-xs-2">
                        Dimanche
                      </div>
                      <div class="col-xs-2">
                        Heure début :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputBeginDimanche" >
                      </div>
                      <div class="col-xs-2">
                        Heure fin :
                      </div>
                      <div class="col-xs-1">
                        <input class="numberInput" type="number" id="inputEndDimanche" >
                      </div>
                      <div class="col-xs-2">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-3">

                      </div>

                      <div class="col-xs-3">
                        <button class="btn btn-primary" id="updateScheduleButton" onclick="updateScheduleSpace()" >Valider les modifications </button>
                      </div>

                      <div class="col-xs-3">
                        <button class="btn btn-primary" id="cancelChangeSchedulePannelButton"> Annuler </button>
                      </div>

                      <div class="col-xs-3">

                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>
            <!--End change schedule div-->


        </div>
      </div>
    </div>
    <?php require "footer.php"; ?>
    <script type="text/javascript" src="js/admin.js"> </script>

  <?php else :?>
    <div>
      Vous n'être pas autorisé à accéder à cette page
    </div>
  <?php endif;?>
  </body>


</html>
