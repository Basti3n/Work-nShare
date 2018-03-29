<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ABOUT</title>
    <?php require "head.php" ?>
  </head>
  <body>
    <?php require "header.php" ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <div class="inner">
        <div class="container">
          <div class="row">
            <?php for ($i=0; $i < 3; $i++) {
              echo '
                <div class="col-lg-4">
                  <img style="border-radius:50%;" src="IMG/bastille.jpg" alt="Generic placeholder image" width="140" height="140">
                  <h2>Bastille</h2>
                  <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
                  <p><a class="btn btn-secondary" href="about.php#bastille" role="button">View details »</a></p>
                </div>
              ';
            } ?>
          </div>

          <?php for ($i=0; $i < 3; $i++) {
            echo '
            <hr>

            <div class="row">
              <div class="col-md-7">
                <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It\'ll blow your mind.</span></h2>
                <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
              </div>
              <div class="col-md-5">
                <img class="img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px;" src="IMG/bastille.jpg" data-holder-rendered="true">
              </div>
            </div>
            ';
          } ?>



        </div>
      </div>
    <?php require "footer.php"; ?>
  </body>
</html>
