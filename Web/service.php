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
          foreach ($site as $key => $value) {
            echo "<button onclick='showPc(".$y.")' class='Ligne".$y."' >".$key."</button>";
            $y++;
          }
          echo "</div>";
          $y=0;
          $i=0;
          echo "<div>";
          foreach ($site as $key => $value) {
            if($y !=0)
              echo "<div id='".$y."' class='sites Ligne".$y."'>";
            else
              echo "<div id='".$y."' class='sites first Ligne".$y."'>";
            $i=0;
            foreach ($value as $key => $value2) {
              if($i!=0)
                echo "<button onclick='clicked(\"".$value2."\")' class='pc'>".$value2."</button>";
              else
                echo "<button onclick='clicked(\"".$value2."\")' class='pc active'>".$value2."</button>";
              $i++;
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
