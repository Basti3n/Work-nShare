<?php
	session_start();
	include "function.php";
	include "object/reservation.php";
	require_once "conf.inc.php";

	$startDate = $_POST["inputDate"]." ".$_POST["startTime"].":00";
	$endDate = $_POST["inputDate1"]." ".$_POST["endTime"].":00";
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