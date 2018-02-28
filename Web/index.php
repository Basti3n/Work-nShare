<!DOCTYPE html>
<html>
	<head>
		<title>Work'n Share</title>
		<link rel="stylesheet" type="text/css" href="CSS/index_style.css">
		<script type="text/javascript" src="JS/index_script.js"></script>

    <?php require "link.php" ?>
	</head>
	<body>
		<h1 id="titre" class="animated fadeInDown">En construction !!!!</h1>
		<div class="container">
			&nbsp;
		<?php
			echo "_____________";
			$hentai = new Event;
			$hentai->setName("kawaiii");
			$hentai->startDate(12,02,1998);
			$hentai->endDate(12,02,1999);
			$hentai->speak();

			echo "<br>_____________";
			$user = new User;
			$user->setName("Benjamin");
			$user->setLastname("Rousval");
			$user->setDate();
			$user->setEmail("salope@gmail.com");
			$user->setPassword(password_hash("apple",PASSWORD_DEFAULT));
			$user->speak();

		?>
		</div>
		<?php require "footer.php"; ?>
	</body>
</html>
