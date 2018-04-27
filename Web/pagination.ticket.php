<?php
session_start();
require_once "conf.inc.php";
include_once "function.php";
include_once "object/ticket.php";
include_once "object/pagination.php";
$db = connectDb();

$page=1;
if(!empty($_GET["page"]))
  $page = $_GET["page"];
$limit=10;//number of data
$limit1 = $page*$limit; //calculate the limit
$start = $limit1-$limit; //calculate the start point

//table
$mng = new TicketMng($db);
if(isset($tickets)) unset($tickets);
$tickets = $mng->getParse($start,$limit,$_SESSION["email"]);

//pagination
$nb = new PerPage();

$out ='
        <table class="table table-striped table-bordered ">
          <thead>
            <tr>
              <th scope="col" class="col-md-1 text-center">ID</th>
              <th scope="col" class="col-md-6 text-center">Message</th>
              <th scope="col" class="col-md-2 text-center">Date</th>
              <th scope="col" class="col-md-2 text-center">Category</th>
              <th scope="col" class="col-md-3 text-center">Correspondant</th>
              <th scope="col" class="col-md-1 text-center">Etat</th>
            </tr>
          </thead>
          <tbody>';
if($tickets != 1){
  foreach ($tickets as $key => $ticket) {
    $out = $out."
              <tr>
                <th scope='row' class='text-center'>".$ticket->idTicket()."</th>
                <td> ".$ticket->contentTicket()."</td>
                <td> Le ".$ticket->dateTicket()."</td>
                <td> ".$ticket->ticketCategory()."</td>
                <td> ".$ticket->ticketSenderStatus()."</td>
                <td class='text-center'>".$ticket->statusTicket()."</td>
              </tr>
    ";
  }
  $out = $out.'
          </tbody>
        </table>
        <ul class="pagination">';
  $result = $nb->pagination($mng->getLine($_SESSION["email"]), "pagination.ticket.php?page=");
  $out = $out . $result;
  $out = $out."</ul>";

  print $out;
}

/*
                      $page=$_POST['page'];//page number
                      $limit=$_POST['limit'];//number of data

                      $limit1 = $page_no*$limit; //calculate the limit
                      $start = $limit1-$limit; //calculate the start point

                      $sql = "select * from Messages  limit $start,$limit";// query
*/
?>
