<?php

class Size{
  private $_name = 50;
  private $_description = 500;

  function setSize($choice, $number){
     switch ($choice) {
       case 'name':
         $this->_name = $number;
         break;
       case 'description':
         $this->_description = $number;
         break;

       default:
         trigger_error("La donnée saisie n'est pas modifiable", E_USER_ERROR);
         break;
     }
  }

  function getSize($choice){
    switch ($choice) {
      case 'name':
        return $this->_name;
        break;
      case 'description':
        return $this->_description;
        break;

      default:
        trigger_error("La donnée saisie n'existe pas", E_USER_ERROR);
        break;
    }
  }



}

?>
