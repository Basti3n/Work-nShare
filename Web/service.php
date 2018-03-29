<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SERVICE</title>

    <?php require "head.php" ?>
    <link rel="stylesheet" type="text/css" href="CSS/service_style.css">
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="container">
        <div>
          <?php
            $y = 0;
            echo "<div>";
            if(isset($_GET["ok"]) && $_GET["ok"]==1){
              echo '<div id="ok"> Votre réservation a été effectué. Vous pouvez allez la consulter sur votre <a href="profil.php">profil</a></div>';
            }
              echo "<h2> Choissisez votre site: </h2>";

              $db = connectDb();
              $findSites = $db->query("SELECT * FROM `SPACES`;");
              $sites = $findSites->fetchAll(PDO::FETCH_ASSOC);

              foreach ($sites as $key => $value) {
                echo "<button onclick='ajaxServices(".$value["idSpace"].")' class='Ligne".$y." btn btn-primary' aria-pressed='true'>".utf8_encode($value['nameSpace'])."</button>";
                $y++;
              }

            echo "</div>
                  <hr>";

            $y=0;
            $i=0;
            echo "<div id='divService'>
                  </div>";

            echo "<div id='divMatos'>
                  </div>";
          ?>
        </div>
        <div id='model' class="">
        </div>

        <input type="button" class="btn btn-success" id="cmd" onclick="command();" value="Commander"></>

        <script src="js/three.js"></script>
        <script src="js/OrbitControls.js"></script>
        <script type="text/javascript" src="js/DDSLoader.js"></script>
        <script type="text/javascript" src="js/MTLLoader.js"></script>
        <script type="text/javascript" src="js/OBJLoader.js"></script>
        <script type="text/javascript" src="js/3dmodel.js"></script>
        <script type="text/javascript" src="js/service_script.js"></script>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
