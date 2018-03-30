<?php
  require "conf.inc.php";
  require "function.php";
  include "object/spaces.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ABOUT</title>
    <?php require "head.php" ?>
		<link rel="stylesheet" type="text/css" href="CSS/about.css">
  </head>
  <body>
    <?php require "header.php" ?>
      <div class="inner" style="margin-top: 20px;">
        <div class="container">
          <div class="row">
            <?php
            $db = connectDb();
            $mng = new SpaceMng($db);
            $spaces = $mng->getAllSpaces();
            foreach ($spaces as $key => $space) {
              if ($space->isDeleted()==0) {
                $name = preg_replace('/[\s\']+/', '', $space->nameOfSpace());
                echo '
                  <div class="col-lg-4">
                    <img class="tinimg" src="IMG/'.noAccents(utf8_encode ($name)).'.jpg" alt="Generic placeholder image" width="140" height="140">
                    <h2>'.utf8_encode ($space->nameOfSpace()).'</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
                    <p><a class="btn btn-secondary" href="#'.utf8_encode ($space->nameOfSpace()).'" role="button">View details »</a></p>
                  </div>
                ';
              }
            }
            ?>
          </div>

          <?php
          foreach ($spaces as $key => $space) {
            if ($space->isDeleted()==0) {
              $name = preg_replace('/[\s\']+/', '', $space->nameOfSpace());
              echo '
              <hr>

              <div class="row" id="'.noAccents(utf8_encode ($name)).'">
                <div class="col-md-7">
                  <h2 class="featurette-heading">'.utf8_encode ($space->nameOfSpace()).'. <span class="text-muted">It\'ll blow your mind.</span></h2>
                  <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
                <div class="col-md-5">
                  <img class="img-fluid mx-auto bigimg" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px;" src="IMG/'.noAccents(utf8_encode ($name)).'.jpg" data-holder-rendered="true">
                </div>
              </div>
              ';
            }
          }
          ?>



        </div>
      </div>
    <?php require "footer.php"; ?>
  </body>
</html>
