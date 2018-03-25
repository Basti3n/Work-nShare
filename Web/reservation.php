<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Work'n Share - Reservation</title>

    <?php require "head.php" ?>
    <link rel="stylesheet" type="text/css" href="CSS/profil.css">
  </head>
  <body>
    <?php 
      require "header.php"; 
      if(isConnected()==false)
        //header("Location: index.php");
    ?>
    <div> 
        <h2>Recapitulatif de votre commande: </h2>
        <?php
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

          echo "<p> Vous avez choisis ".$res[0]["nameServiceContent"]." pour le site de ".$res3[0]["nameSpace"];

        ?>
        <br>
        <button>Confirmer la reservation</button>
    </div>

</body>
</html>