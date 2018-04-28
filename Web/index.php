<?php
	require "object/spaces.php";

 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Work'n Share</title>
		<link rel="stylesheet" type="text/css" href="CSS/index_style.css">
		<script type="text/javascript" src="JS/index_script.js"></script>

    <?php require "head.php" ?>
	</head>
	<body>
		<?php require "header.php"; ?>
		<div class="home_top">
      <div class="home_top_text">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						 <h1>Work'n Share</h1>
					</div>
					<div class="col-lg-4"></div>
				</div>

				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						   <p>Bienvenue sur Work'n Share , nous vous proposons des sites de coworking.</p>
					</div>
					<div class="col-lg-4"></div>
				</div>


				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<div class="home_top_link">
							<span class="home_top_link1">Nous rejoindre</span>
							<a class="home_top_link2" href="propos.php">En apprendre plus</a>
						</div>
					</div>
					<div class="col-lg-4"></div>
				</div>

      </div>
    </div>

		<div class="home_description">
				 <div class="container">
					 <div class="row">
						 <div class="col-sm-12">
							 <div class="home_description_title">
								 <center><h2>Ce que nous proposons</h2><center>
							 </div>
						 </div>
					 </div>
					 <center>
						 <div class="row">
							 <div class="col-sm-4">
								 <img class="home_description_icon" src="img/work.PNG">
								 <div  class="home_description_content_title">
									 <h3>Travailler</h3>
								 </div>
								 <p class="home_description_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
							 </div>
							 <div class="col-sm-4">
							 <img class="home_description_icon" src="img/share.png">
								 <div  class="home_description_content_title">
									 <h3>S'entraider</h3>
								 </div>
								 <p class="home_description_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
							 </div>
							 <div class="col-sm-4">
								 <img class="home_description_icon" src="img/service.png">
								 <div  class="home_description_content_title">
									 <h3>Partager</h3>
								 </div>
								 <p class="home_description_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
							 </div>
						 </div>
					 </center>
				 </div>
			 </div>


			 <section id="portfolio">
				 <div class="row">
 					<div class="col-sm-12">
 						<div class="home_description_title">
 							<center><h2>Nos sites</h2><center>
 						</div>
 					</div>
 				</div>
 				<div class="container">
 					<div class="row">
 						<ul class="sites-wrapper wow animated fadeInUp">
							<?php
								$db = connectDb();
								$spaceMng = new SpaceMng($db);
								$spaces = $spaceMng->getAllSpaces(1);



								foreach ($spaces as $key => $space) {
									if($spaces != 1){
										echo ($key%3==0?'<div class="row">':'').'<li class="col-sm-4 site">
						 								<img src="IMG/'.$space->idSpace().'.jpg" class="img-responsive" alt="'.utf8_encode($space->nameOfSpace()) .'">
						 								<figcaption class="mask">
						 									<h3>'.utf8_encode($space->nameOfSpace()).'</h3>
						 								</figcaption>
						 							</li>'.($key%3==2?'</div>':'');
									}
								}
							?>
<!--
 							<li class="site">
 								<img src="IMG/bastille.jpg" class="img-responsive" alt="Bastille">
 								<figcaption class="mask">
 									<h3>Bastille</h3>
 								</figcaption>
 							</li>

 							<li class="site">
 								<img src="IMG/republique.jpg" class="img-responsive" alt="République">
 								<figcaption class="mask">
 									<h3>République</h3>
 								</figcaption>

 							</li>

 							<li class="site">
 								<img src="IMG/odeon.jpg" class="img-responsive" alt="Odéon">
 								<figcaption class="mask">
 									<h3>Odéon</h3>
 								</figcaption>

 							</li>

 							<li class="site">
 								<img src="IMG/placeditalie.jpg" class="img-responsive" alt="Place d'Italie">
 								<figcaption class="mask">
 									<h3>Place d'Italie</h3>
 								</figcaption>

 							</li>
 							<li class="site">
 								<img src="IMG/ternes.jpg" class="img-responsive" alt="Ternes">
 								<figcaption class="mask">
 									<h3>Ternes</h3>
 								</figcaption>
 							</li>

 							<li class="site">
 								<img src="IMG/beaubourg.jpg" class="img-responsive" alt="Beaubourg">
 								<figcaption class="mask">
 									<h3>Beaubourg</h3>
 								</figcaption>
 							</li>
-->
						</ul>

				</div>
			</section>


		<?php require "footer.php"; ?>
	</body>
</html>
