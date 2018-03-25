<!DOCTYPE html>
<html>
	<head>
		<title>Create QRCODE</title>
	</head>
	<body>
		<h1>QRCODEGEN</h1>
		<form action="qrgen.php" method="post">
			<input type="text" name="data">
			<input type="submit">
		</form>
		<?php
			if(!empty($_GET["data"]))
				if(file_exists("Qrcode_".$_GET["data"].".bmp"))
					echo '<img src="Qrcode_'.$_GET["data"].'.bmp" height="500" width="500">';
		?>
	</body>
</html>