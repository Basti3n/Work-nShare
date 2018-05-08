<?php
require_once "conf.inc.php";
include_once "function.php";
require_once 'object/subscription.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SUBSCRIBE</title>

    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div class="inner">
      <div class="container">
        &nbsp;
        <?php
        $db = connectDb();
        $mng = new SubscriptionMng($db);
        $subscriptions = $mng->getAll();
         ?>

         <table class="table table-striped">
           <thead class="thead-light">
             <tr>
               <th scope="col"></th>
             <?php
             $perm =[];
             foreach ($subscriptions as $key => $value) {
               foreach (array_keys($value->right("getAll")) as $keykey => $id) {
                 if(!in_array($id,$perm) )
                  array_push($perm,$id);
               }
               echo "<th scope='col'>".utf8_encode($value->name())."</th>\n";
             }
             print_r($perm);
              ?>
              </tr>
             <!--
             <tr>
               <th scope="col">#</th>
               <th scope="col">Jour</th>
               <th scope="col" class="col-md-8">Heures</th>
               <th scope="col" class="col-md-2">Facture</th>
             </tr>
           -->
           </thead>
           <tbody>
             <?php
             foreach ($perm as $key => $value) {
               echo "
               <tr>
                 <th scope='row'>".$value."</th>
                 <td>"."lol"."</td>
                 <td>Vous êtes allé à <b>"."lol"."</td>
               </tr>";
             }

              ?>
             <!--
             <tr>
               <th scope='row'>".$value["idAccess"]."</th>
               <td>".date('j\/m\/Y', strtotime($value["dateAccess"]))."</td>
               <td>Vous êtes allé à <b>".nameOfSpace($value["idSpace"])."</b> de ".date('G\h i', strtotime($value["dateAccess"]))." à ".date('G\h i', strtotime($value["dateExit"]))."</td>
             </tr>
           -->
           </tbody>
         </table>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
