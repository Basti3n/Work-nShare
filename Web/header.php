<?php
  session_start();
  require_once "function.php";
  require_once "conf.inc.php";
  $db = connectDb();
?>

<header>
  <nav>
		<div class="container-fluid header_libart">
			<div class="row">

				<div class="col-sm-1 headerLogo">
					<a href="index.php"><img id="logo" src="IMG/logo.png" ></a>
				</div>

				<div class="header_list row col-sm-8">
					<a class="col-xs-2 headerButton" href="index.php" >Accueil</a>
					<a class="col-xs-2 headerButton" href="service.php">Services</a>
					<a class="col-xs-2 headerButton" href="event.php">Evènement</a>
          <a class="col-xs-2 headerButton" href="subscribe.php">Abonnement</a>
          <a class="col-xs-2 headerButton" href="about.php">À propos</a>
				</div>

				<div class="header_signup_login col-sm-3 text-right" id="perso">
					<?php if(isConnected()):?>
            <div class="col-sm-12">
						  <a class="headerButton" href="profil.php?id=<?php echo $_SESSION["email"]?>"><?php echo $_SESSION["email"]?></a>
            </div>
            <div class="col-sm-12">
              <a class="headerButton" id="leave" href="logout.php">Deconnexion</a>
            </div>
					<?php else:?>
						<a  class="col-xs-6 headerButton" href="signup.php">S'inscrire</a>
						<a  class="col-xs-6 headerButton" href="login.php">Se connecter</a>
					<?php endif;?>
				</div>
			</div>
		</div>
	</nav>
</header>
