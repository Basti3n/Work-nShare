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
    <div class="container">
      <div>
        <?php
          $y = 0;
          echo "<div>";
          echo "<h2> Choissisez votre site: </h2>";
          foreach ($site as $key => $value) {
            echo "<button onclick='showService()' class='Ligne".$y." btn btn-primary' aria-pressed='true'>".$key."</button>";
            $y++;
          }
          echo "</div>";
          $y=0;
          $i=0;
          echo "<div id='divService'>";
          echo "<h2> Choissisez votre service: </h2>";
          foreach ($service as $key => $value) {
            if($y ==0)
                echo "<button onclick='showPc(0)' class='btn btn-primary' aria-pressed='true'>".$value."</button>";
            else
             echo "<button  onclick='showPc(1)'class='btn btn-primary' aria-pressed='true'>".$value."</button>";
             $y++;
          }
          echo "</div>";
          echo "<div id='divMatos'>";
          echo "<h2> Choissisez votre matériel: </h2>";
          $y=0;
          $i=0;
          foreach ($site as $key => $value) {
            if($y !=0)
              echo "<div id='".$y."' class='sites Ligne".$y."'>";
            else
              echo "<div id='".$y."' class='sites first Ligne".$y."'>";

            foreach ($value as $key => $value2) {
                echo "<button onclick='clicked(\"".$value2."\")' class='pc btn btn-primary' aria-pressed='true'>".$value2."</button>";
            }
            echo "</div>";
            $y++;
          }
          echo "</div>";
        ?>
      </div>
      <div id='model'>
      </div>

      <div id='carac'>
        <ul>
          <li>Modèle : </li>
          <li>Processeur : </li>
          <li>Stockage : </li>
          <li>Mémoire vive : </li>
          <li>Poids : </li>
          <li>Dimension : </li>
          <li>Autonomie : </li>
          <li><a href="https://www.microsoft.com/fr-fr/store/d/surface-pro/8nkt9wttrbjk?activetab=pivot:techspecstab" target="_blank">Lien vers le site officiel</a></li>
        </ul>

      </div>





      <script src="js/three.js"></script>
      <script src="js/OrbitControls.js"></script>
      <script type="text/javascript" src="js/DDSLoader.js"></script>
      <script type="text/javascript" src="js/MTLLoader.js"></script>
      <script type="text/javascript" src="js/OBJLoader.js"></script>
      <script type="text/javascript" src="js/3dmodel.js"></script>
      <script type="text/javascript" src="js/service_script.js"></script>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
