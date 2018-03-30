<?php
  require "conf.inc.php";
  require "function.php";
  include "object/user.php";
  include "object/spaces.php";
  include "object/services.php";
  include "object/serviceContents.php";

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
                          //. $space->isDeleted().
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
                  //  echo $services[0].nameOfService();
                  ?>

                  <?php if(!empty($services)) :?>
                    <table class="table" id ="spaceArray">
                      <tr>
                                <th>Nom du service général</th>
                                <th>Information complémentaire</th>
                                <th>Espace du service</th>
                                <th>Disponible</th>
                                <th>Supprimé</th>

                      </tr>
                      <?php
                        foreach ($services as $service) {

                          echo '<tr>
                                  <td>'.utf8_encode($service->nameOfService()).'</td>
                                  <td>'. $service->compInfo().'</td>
                                  <td>'.utf8_encode($spaceMng->getSpaceName($service->idSpace())).'</td>
                                  <td>'.$service->isBooked().'</td>
                                  <td>'. $service->isDeleted().'</td>
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
                  //  echo $services[0].nameOfService();
                 //showArray($serviceContents);
                  ?>

                  <?php if(!empty($serviceContents)) :?>

                    <table class="table" id ="spaceContentArray">
                      <tr>
                                <th>Nom du service</th>
                                <th>Information complémentaire</th>
                                <th>Service concerné</th>
                                <th>Disponible</th>
                                <th>Supprimé</th>

                      </tr>
                      <?php
                        foreach ($serviceContents as $serviceContent) {

                          echo '<tr>
                                  <td>'.$serviceContent->nameServiceContent().'</td>
                                  <td>'. $serviceContent->informationServiceContent().'</td>
                                  <td>'.$serviceMng->getServiceName($serviceContent->idService()).'</td>
                                  <td>'.$serviceContent->isFree().'</td>
                                  <td>'. $serviceContent->isDeleted().'</td>
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
              <div class="container col-md-12">
                <p>Base de données</p>
              </div>
            </div>
            <div class="tab-pane fade" id="tickets" role="tabpanel" aria-labelledby="tickets-list">
              <div class="container col-md-12">
                <p>Tickets</p>
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
                            echo "<option value='".$service->idService()."'>".$service->nameOfService()."</option>";
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
    </div>
    <?php require "footer.php"; ?>
    <script type="text/javascript" src="js/admin.js"> </script>
  </body>
</html>
