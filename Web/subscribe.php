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
              ?>
              </tr>
           </thead>
           <tbody>
             <?php
             foreach ($perm as $key => $value) {
               echo "
               <tr>
                 <th scope='row'>".$value."</th>";
                 foreach ($subscriptions as $keykey => $id) {
                  echo "<td><i class='fas fa-".($id->right("has",$value)?"check":"times")."'></i></td>";
                 }
                 echo"
               </tr>";
             }
             echo "<tr></tr>";
             foreach ($subscriptions as $keykey => $id) {
              echo "
              <tr>
                <td><i class='fas fa-".($id->right("has",$value)?"check":"times")."'></i></td>";
                echo"
              </tr>";
             }

              ?>
           </tbody>
         </table>
      </div>
    </div>
    <?php require "footer.php"; ?>
  </body>
</html>
