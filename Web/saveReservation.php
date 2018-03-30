<?php
	session_start();
	include "function.php";
	include "object/reservation.php";
	require_once "conf.inc.php";

	$date = json_decode($_GET["date"]);

	$db = connectDb();
	$mng = new ReservationMng($db);
	foreach ($date as $key => $value) {
		$day = explode(" ",$value)[0];
		$hours = explode(" ",$value)[1];
		$hours = date("H:i",strtotime($hours)+60*60).":00";
		echo "hours : ".$hours."     Day : ".$value."<br>";

		$data = array(
		"site" => $_GET["site"],
        "email" => $_SESSION["email"],
        "idServiceContent" => $_GET["serviceContent"],
        "reservationStartDate" => $value,
        "reservationEndDate" => $day." ".$hours
      );
		$reservation = new Reservation($data);
		$mng->add($reservation);
		//showArray($data);
	}

	header("Location: service.php?ok=1");
