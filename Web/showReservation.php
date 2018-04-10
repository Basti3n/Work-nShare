<?php
	include "function.php";
	include "object/reservation.php";
	require_once "conf.inc.php";
	require "head.php";
	?>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"> </script>
	<script type="text/javascript" src="js/bootstrap.min.js"> </script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/reservation_style.css">
	<script src="JS/reservation_script.js"></script>

	<?php
	$db = connectDb();
	$date = json_decode($_GET["date"]);
	$query = $db->prepare("SELECT * FROM `reservation` WHERE (reservationStartDate BETWEEN :startD AND :endD ) AND idServiceContent =:idServiceContent");
	$query->execute([
		"startD"=>$date[0],
		"endD"=>date("Y-m-d",strtotime($date[6].'+1 day')),
		"idServiceContent"=>$_GET["site"]
	]);
	//showArray($date);


	//echo " date :".date("Y-m-d",strtotime($_GET["date6"].'+1 day'))."<br>";
	$data = $query->fetchAll(PDO::FETCH_ASSOC);
	//showArray($data);
	?>
	<!--<div class="row">
            <div class="col-sm-6 form-group">
              <div class="input-group" id="DateDemo">
                <input type='text' id='weeklyDatePicker' class="form-control" placeholder="Select Week" />
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
          </div>
    -->
	<table id="calendar">
        <?php
	        //horaire
	        $json = array(
	              0=>array(
	                          "debut"=>"13",
	                          "fin"=>"20",
	                          "jour"=>"Lundi"
	              ),
	              1=>array(
	                          "debut"=>"18",
	                          "fin"=>"24",
	                          "jour"=>"Mardi"
	              ),
	              2=>array(
	                          "debut"=>"01",
	                          "fin"=>"05",
	                          "jour"=>"Mercredi"
	              ),
	              3=>array(
	                          "debut"=>"09",
	                          "fin"=>"12",
	                          "jour"=>"Jeudi"
	              ),
	              4=>array(
	                          "debut"=>"09",
	                          "fin"=>"20",
	                          "jour"=>"Vendredi"
	              ),
	              5=>array(
	                          "debut"=>"11",
	                          "fin"=>"23",
	                          "jour"=>"Samedi"
	              ),
	              6=>array(
	                          "debut"=>"14",
	                          "fin"=>"20",
	                          "jour"=>"Dimanche"
	              )
	          );
	       	//calendrier
			echo "<thead>";
			echo "<th class='calendarTh'> </th>";
			$max = 0;
			$min = 100;
			foreach ($json as $key => $value) {
				echo "<th class='calendarTh'>".$value["jour"]."</th>";
				if($value["debut"]<$min){
				  $min = $value["debut"];
				}
				if($value["fin"]>$max){
				  $max = $value["fin"];
				}
			}
			echo "</thead>";
			echo "<tbody>";
			for($i=$min;$i<=$max;$i++){
	            echo "<tr>";
	            echo "<td class='calendarTd'>".$i.":00</td>";
	              for($y=0;$y<7;$y++){
	              		$time = test($i,$data,$json,$y,$date);
		                if($time == 1){
		                  echo "<td class='occupe calendarTd' id='td".$i."-".$y."' title='occupe'> </td>";
		                }else if($time == 2){
		                  echo "<td class='indisponible calendarTd' id='td".$i."-".$y."' title='indisponible'> </td>";
		                }else{
		                  echo "<td class='libre calendarTd' onclick='changeBg(\"td".$i."-".$y."\")' id='td".$i."-".$y."' title='libre'> </td>";
		                }
	              	}
	            echo "</tr>";
	        }
          echo "</tbody>";
        ?>
       </table>
		<!--<button onclick="ajaxReserv()">Confirmer La reservation</button>-->
       <?php

	/* function */
	function test($i,$data,$json,$y,$date){
		foreach ($json as $key => $index) {
			if(intval($json[$y]["debut"]) > intval($i) || intval($json[$y]["fin"]) < intval($i)){
				return 2;
			}
		}
		foreach ($data as $key => $index) {
            $time = explode(" ",$index["reservationStartDate"])[1];
            $day = explode(" ",$index["reservationStartDate"])[0];
            //echo $time." ";
            //echo $time." == ".$i.":00:00 ///  jour : ".$day."==".$date[$y]."<br>";
            if($time == $i.":00:00" && $day == $date[$y]){
            	//echo "1 ";
            	return 1;
            }
        }
        return 0;

	}


	/*$date2 = array(
		0=>"2018-03-26",
		1=>"2018-03-27",
		2=>"2018-03-28",
		3=>"2018-03-29",
		4=>"2018-03-30",
		5=>"2018-03-31",
		5=>"2018-04-01"
	);
	echo json_encode($date2);*/
