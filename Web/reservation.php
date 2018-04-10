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
    
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/reservation_style.css">
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

      $space =$res2[0]["idSpace"]; 
    ?>
    <script type="text/javascript">
        var space='<?PHP echo $_GET["choice"];?>';
    </script>
    <div>     
        <h2>Recapitulatif de votre commande: </h2>
        <?php

          echo "<p> Vous avez choisis ".$res[0]["nameServiceContent"]." pour le site de ".utf8_encode($res3[0]["nameSpace"]);

         /*$tab = array(
            "site" => $res3[0]["nameSpace"],
            "email" => $_SESSION["email"],
            "idServiceContent" => $_GET["choice"],
            "idReservation" => 2,
            "reservationStartDate" => date('Y-m-d H:i:s'),
            "reservationEndDate" => date('Y-m-d H:i:s')
          );
          $db = connectDb();
          $mng = new ReservationMng($db);
          $reservation = new Reservation($tab);*/
          //$reservation->speak();

          //$mng->add($reservation);

          /*$json = array(
              "Lundi"=>array(
                          "debut"=>"9",
                          "fin"=>"20",
              ),
              "Mardi"=>array(
                          "debut"=>"9",
                          "fin"=>"20"
              ),
              "Mercredi"=>array(
                          "debut"=>"9",
                          "fin"=>"23"
              ),
              "Jeudi"=>array(
                          "debut"=>"9",
                          "fin"=>"20"
              ),
              "Vendredi"=>array(
                          "debut"=>"9",
                          "fin"=>"20"
              ),
              "Samedi"=>array(
                          "debut"=>"11",
                          "fin"=>"20"
              ),
              "Dimanche"=>array(
                          "debut"=>"11",
                          "fin"=>"20"
              )
          );*/
          /*$test = json_encode($json);
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
        <h2>Selectionner la semaine</h2>
            <div class="col-sm-6 form-group">
              <div class="input-group" id="DateDemo">
                <input type='text' id='weeklyDatePicker' class="form-control" placeholder="Select Week" />
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
        <br>
        <!--<table id="calendar">-->
          <h2>Selectionner l'heure</h2>
          <div id="scheduler">
            
          </div>
        <?php 
        /*
          echo "<thead>";
          echo "<th class='calendarTh'> </th>";
          $max = 0;
          $min = 100;
          foreach ($json as $key => $value) {
            echo "<th class='calendarTh'>".$key."</th>";
            if($value["debut"]<$min){
              $min = $value["debut"];
            }
            if($value["fin"]>$max){
              $max = $value["fin"];
            }
          }
          echo "</thead>";
          echo "<tbody>";
          for($i=$min;$i<=$max;$i++){
            echo "<tr>";
            echo "<td class='calendarTd'>".$i.":00</td>";
              for($y=0;$y<7;$y++){
                if($i % ($y+1) == 1 ||$i % ($y+1) == 2 ){
                  echo "<td class='indisponible calendarTd' id='td".$i."-".$y."'> </td>";
                }else if($i % ($y+1) == 3 ||$i % ($y+1) == 4  ){
                  echo "<td class='occupe calendarTd' id='td".$i."-".$y."'> </td>";
                }else{
                  echo "<td class='libre calendarTd' onclick='changeBg(\"td".$i."-".$y."\")' id='td".$i."-".$y."'> </td>";
                }
                
              }
            echo "</tr>";
          }
          echo "</tbody>";
          */

        ?>
       <!--</table>-->
       <?php
       echo '<button onclick="reserv(\''.utf8_encode($res3[0]["nameSpace"]).'\','.$_GET["choice"].')">Confirmer La reservation</button>';
       ?>
    </div>
    <script src="JS/reservation_script.js"></script>
</body>
</html>