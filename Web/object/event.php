<?php
date_default_timezone_set('UTC');

class Event
{
  private $_name = "name";
  private $_description = "empty";
  private $_hourStart;
  private $_dateStart;
  private $_hourEnd;
  private $_dateEnd;
  private $_idSpace;

  function __construct($data){
    if ($data != null)
      $this->hydrate($data);
  }

  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      switch($key){
        case 'nameEvent':
          $this->nameEvent($value);
          break;
        case 'descriptionEvent':
          $this->descriptionEvent($value);
          break;
        case 'dateStart':
          //ajout de l'heure
          $this->hourStart($value);
          //ajout de la date
          $this->dateStart($value);
          break;
        case 'dateEnd':
          //ajout de l'heure
          $this->hourEnd($value);
          //ajout de la date
          $this->dateEnd($value);
          break;
        case 'idSpaceEvent':
          $this->idSpace($value);
          break;
        default:
          break;
      }
    }
  }

  public function nameEvent($nameEvent = "0"){
    if($nameEvent == "0")
      return $this->_name;
    else
      $this->_name= $nameEvent;
    return 0;
  }

  public function descriptionEvent($descriptionEvent = "0"){
    if($descriptionEvent == "0")
      return $this->_description;
    else
      $this->_description= $descriptionEvent;
    return 0;
  }

  public function dateStart($date = "0"){
    if($date == "0")
      return $this->_dateStart;
    else
      $this->_dateStart = date('d-m-Y', strtotime(explode(" ",$date)[0]));
    return 0 ;
  }

  public function dateEnd($date = "0"){
    if($date == "0")
      return $this->_dateEnd;
    else
      $this->_dateEnd = date('d-m-Y', strtotime(explode(" ",$date)[0]));
    return 0 ;
  }

  public function hourStart($date = "0"){
    if($date == "0")
      return $this->_hourStart;
    else
      $this->_hourStart = explode(":",explode(" ",$date)[1])[0]."h".explode(":",explode(" ",$date)[1])[1];
    return 0 ;
  }

  public function hourEnd($date = "0"){
    if($date == "0")
      return $this->_hourEnd;
    else
      $this->_hourEnd = explode(":",explode(" ",$date)[1])[0]."h".explode(":",explode(" ",$date)[1])[1];
    return 0 ;
  }

  public function idSpace($id = "0"){
    if($id == "0")
      return $this->_idSpace;
    else
      $this->_idSpace = $id;
    return 0;
  }





  public function setName($name){
    if (strlen($name) > 50) {
      trigger_error("Le nom saisie est trop long", E_USER_ERROR);
      return;
    }
    $this->_name = $name;
  }

  public function startDateSignup($day,$month,$year){
    $this->_dateStart = mktime(0,0,0,$month,$day,$year);
  }

  public function endDateSignup($day,$month,$year){
    $this->_dateEnd = mktime(0,0,0,$month,$day,$year);
  }

  public function speak(){
    echo  "<br>\$_name : ".$this->_name.
          "<br>\$_description : ".$this->_description.
          "<br>\$_dateStart : ".date('d \/ m \/ Y',$this->_dateStart).
          "<br>\$_hourStart : ".$this->_hourStart.
          "<br>\$_dateEnd : ".date('l \/ F \/ y',$this->_dateEnd).
          "<br>\$_hourEnd : ".$this->_hourEnd.
          "<br>\$_idSpace : ".$this->_idSpace;
  }
}

class EventMng{
  private $_db;

  function __construct($db){
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }

  public function getAll(){
    try{
        $query = $this->_db->query("SELECT * FROM `spaceevents` WHERE isDeleted=0 AND dateEnd>NOW()");
    }catch(Exception $e){
      echo "PDOException : " . $e->getMessage();
    }
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if($data != null){
      $events = [];
      foreach ($data as $key => $value) {
        array_push($events,new Event($value));
        //$value.speak();
      }
      foreach ($events as $key => $value) {
        $this->writeText($value);
      }
      //return $events;
    }else
      echo "<p> Pas d'evenement en ce moment</p>";
    return 1;

  }

  public final function writeText($event){
    echo '<div class="event">
      <h2>'.$event->nameEvent().'</h2>
      <div class="description row">
          <p class="descr">
            '.$event->descriptionEvent().'
          </p>
          <img src="IMG/'.$event->idSpace().'.jpg" height="150" width="200">      
      </div>
        <div class="fin">
          <p class="heureFin dateDesc">Heure de fin : '.$event->hourEnd().'</p>
          <p class="dateFin dateDesc">Date de fin : '.$event->dateEnd().'</p>
        </div>
        <div class="debut">
          <p class="heureDebut dateDesc">Heure de debut : '.$event->hourStart().'</p>
          <p class="dateDebut dateDesc">Date de debut : '.$event->dateStart().'</p>
        </div>
    </div>';
  }
}
?>
