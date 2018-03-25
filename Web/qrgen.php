<?php
	function showArray($array){
 		echo "<pre>";
 		print_r($array);
 		echo "</pre>";
 	}
 	if(!empty($_POST["data"]) ){
 		showArray($_POST);
 		exec('QRcodegen\bin\Debug\QRcodegen.exe '.$_POST["data"]);
 	}else
 		echo "not ok";
 header("Location: index.php?data=".$_POST["data"]);