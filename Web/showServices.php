<?php
	require "conf.inc.php";
	require "function.php";
	if(!empty($_GET["space"])){
		$db = connectDb();
		$query = $db->prepare("SELECT * FROM `SERVICES` WHERE idSpace=?");
		$query->execute(array($_GET["space"]));
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($res)){
			$y=0;
			echo "<h2> Choissisez votre service: </h2>";
			foreach ($res as $key => $value) {
				if(utf8_encode($value['nameService'])=="Matériel informatique")
				    echo "<button onclick='ajaxServicesContent(".$value["idService"].")' class='btn btn-primary' aria-pressed='true'>".utf8_encode($value['nameService'])."</button>";
				else
				 	echo "<button  onclick='ajaxServicesContent(".$value["idService"].")' class='btn btn-primary' aria-pressed='true'>".utf8_encode($value['nameService'])."</button>";
				}
		}else
				echo "error";
	}else{
		header("Location: index.php");
	}
