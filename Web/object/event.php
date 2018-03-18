<?php
date_default_timezone_set('UTC');

class Event
{
  private $_name = "name";
  private $_description = "empty";
  private $_dateStart;
  private $_dateEnd;
  private $_val = 2;

  public function setName($name){
    if (strlen($name) > 50) {
      trigger_error("Le nom saisie est trop long", E_USER_ERROR);
      return;
    }
    $this->_name = $name;
  }

  public function startDate($day,$month,$year){
    $this->_dateStart = mktime(0,0,0,$month,$day,$year);
  }

  public function endDate($day,$month,$year){
    $this->_dateEnd = mktime(0,0,0,$month,$day,$year);
  }

  public function speak(){
    echo  "<br>\$_name : ".$this->_name.
          "<br>\$_dateStart : ".date('d \/ m \/ Y',$this->_dateStart).
          "<br>\$_dateEnd : ".date('l \/ F \/ y',$this->_dateEnd).
          "<br>\$_val : ".$this->_val;
  }

}
?>
