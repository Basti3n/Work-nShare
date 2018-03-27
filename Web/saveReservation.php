<?php
	session_start();
	include "function.php";
	include "object/reservation.php";
	require_once "conf.inc.php";
	$dateS = explode(" ",$_POST["inputDate"]);
	$startDate = $dateS[0]." ".$_POST["startTime"].":00";
	$dateE = explode(" ",$_POST["inputDate1"]);
	$endDate = $dateE[0]." ".$_POST["endTime"].":00";
	$data = $arrayName = array(
		"site" => $_GET["site"],
        "email" => $_SESSION["email"],
        "idServiceContent" => $_GET["serviceContent"],
        "reservationStartDate" => $startDate,
        "reservationEndDate" => $endDate
      );

	showArray($data);

	$db = connectDb();
	$mng = new ReservationMng($db);
	$reservation = new Reservation($data);
	$reservation->speak();
	$mng->add($reservation);

	header("Location: service.php?ok=1");