<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - Reservation</title>

    <?php 
    require "head.php" ;
    require "object/reservation.php";
    ?>
    <link rel="stylesheet" type="text/css" href="CSS/profil.css">
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="JS/reservation_script.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <?php 
      require "header.php"; 
      if(isConnected()==false || !isset($_GET["choice"]) || empty($_GET))
        header("Location: index.php");
      $db = connectDb();
      $query = $db->prepare("SELECT nameServiceContent,idService FROM `SERVICE_CONTENT` WHERE idServiceContent=?");
      $query->execute(array($_GET["choice"]));
      $res = $query->fetchAll(PDO::FETCH_ASSOC);

      $query2 = $db->prepare("SELECT * FROM `SERVICES` WHERE idService=?");
      $query2->execute(array($res[0]["idService"]));
      $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

      $query3 = $db->prepare("SELECT * FROM `SPACES` WHERE idSpace=?");
      $query3->execute(array($res2[0]["idSpace"]));
      $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div> 
      <?php
      echo '<form method="POST" action="saveReservation.php?serviceContent='.$_GET["choice"].'&site='.$res3[0]["nameSpace"].'">';
      ?>
        <h2>Recapitulatif de votre commande: </h2>
        <?php

          echo "<p> Vous avez choisis ".$res[0]["nameServiceContent"]." pour le site de ".$res3[0]["nameSpace"];

          $tab = array(
            "site" => $res3[0]["nameSpace"],
            "email" => $_SESSION["email"],
            "idServiceContent" => $_GET["choice"],
            "idReservation" => 2,
            "reservationStartDate" => date('Y-m-d H:i:s'),
            "reservationEndDate" => date('Y-m-d H:i:s')
          );
          $db = connectDb();
          $mng = new ReservationMng($db);
          $reservation = new Reservation($tab);
          $reservation->speak();

          //$mng->add($reservation);

          /*$json = array(
              "Lundi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Mardi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Mercredi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Jeudi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Vendredi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Samedi"=>array(
                          "debut"=>"11",
                          "fin"=>"20",
              ),
              "Dimanche"=>array(
                          "debut"=>"11",
                          "fin"=>"20",
              ),
          );
          $test = json_encode($json);
          echo "<br>".$test."<br>";

          $wow = json_decode($test);
          foreach ($wow as $key => $value) {
            echo $key." ";
            foreach ($value as $key1 => $value2) {
                          echo $key1." ".$value2;
            }
            echo "<br>";
          }-*/
        ?>
        <button onclick="add()">ici</button>
        <div id="time">
          <h2>Début de la réservation</h2>
          <div id="datepicker" class="input-group date inpm" data-date-format="mm-dd-yyyy">
            <input id="val" name="inputDate" class="form-control" type="text" readonly />
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
          <p>Heure de début</p>
          <input type="time" value="09:00"  name="startTime" id="startTime">
          <h2>Fin de la réservation</h2>
          <div id="datepicker1" class="input-group date inpm" data-date-format="mm-dd-yyyy">
            <input id="val1" name="inputDate1" class="form-control" type="text" readonly />
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
          </div>
          <p>Heure de fin</p>
          <input type="time" value="09:00" name="endTime" id="endTime">
        </div>
        <a href="service.php">Retour en arrière</a>
        <input type="submit" value="Confirmer la reservation">
       </form>
    </div>

</body>
</html>