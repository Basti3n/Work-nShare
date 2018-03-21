<?php
	require "conf.inc.php";
	require "function.php";

	if(!empty($_GET["service"])){
		$db = connectDb();
		$query = $db->prepare("SELECT * FROM `SERVICE_CONTENT` WHERE idService=?");
		$query->execute(array($_GET["service"]));
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($res)){
			$y=0;
			echo "<h2> Choissisez votre matériel: </h2>";
			foreach ($res as $key => $value) {
	             	 echo "<button onclick='clicked(\"".utf8_encode($value['nameServiceContent'])."\")' class='pc btn btn-primary' aria-pressed='true'>".utf8_encode($value['nameServiceContent'])."</button>";
          	}
        }else 
			echo "error";
	}else{
		//header("Location: index.php");
	}	
