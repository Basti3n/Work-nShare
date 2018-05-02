<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - EVENT</title>
    <link rel="stylesheet" type="text/css" href="CSS/event.css">
    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="container">
        &nbsp;

        <div id="eventList">
          <?php
          $db = connectDb();
          $query = $db->query("SELECT * FROM `spaceevents` WHERE idDeleted=0");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($res)){
            //showArray($res);
            $query3 = $db->prepare("SELECT * FROM `SPACES` WHERE idSpace=?");
            foreach ($res as $key => $value) {
              $query3->execute(array($value["idSpaceEvent"]));
              $resSpace = $query3->fetchAll(PDO::FETCH_ASSOC);
              $start = explode(" ",$value["dateStart"]);
              $end = explode(" ",$value["dateEnd"]);
              $heureDebut=explode(":",$start[1])[0]."h".explode(":",$start[1])[1];
              $heureFin=explode(":",$end[1])[0]."h".explode(":",$end[1])[1];
              $dateFin=date('d-m-Y', strtotime($end[0]));
              $dateDebut=date('d-m-Y', strtotime($start[0]));
              echo '<div class="event">
                      <h2>'.$value["nameEvent"].'</h2>
                      <div class="description">
                        <p class="descr">
                          '.$value["descriptionEvent"].'
                        </p>
                        <img src="IMG/'.$resSpace[0]["idSpace"].'.jpg" height="200" width="200">

                      </div>
                        <div class="fin">
                          <p class="heureFin dateDesc">Heure de fin : '.$heureFin.'</p>
                          <p class="dateFin dateDesc">Date de fin : '.$dateFin.'</p>
                        </div>
                        <div class="debut">
                          <p class="heureDebut dateDesc">Heure de debut : '.$heureDebut.'</p>
                          <p class="dateDebut dateDesc">Date de debut : '.$dateDebut.'</p>
                        </div>
                    </div>';
            }
          }else{
            echo "<p> Pas d'evenement en ce moment</p>";
          }
        ?>
          <!--<div class="event">
            <h2>Nom de l'evenement</h2>
            <div class="description">
              <p>
                Ceci est une description longue <br>Et sans interet certain <br>Elle est la, elle decrit mais personne ne sait quoi
              </p>
              <img src="IMG/01basti.jpg" height="200" width="200">
            </div>
              <div class="fin">
                <p class="heureFin dateDesc">Heure de fin : 15h30</p>
                <p class="dateFin dateDesc">Date de fin : 25-08-2018</p>
              </div>
              <div class="debut">
                <p class="heureDebut dateDesc">Heure de debut : 11h20</p>
                <p class="dateDebut dateDesc">Date de debut : 19-06-2018</p>
              </div>
          </div>-->

        </div>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
