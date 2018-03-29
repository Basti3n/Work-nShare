<?php

date_default_timezone_set('Europe/Paris');


class Reservation{
	private $_site= "empty";
	private $_email = "empty";
	private $_idServiceContent = 0;
	private $_reservationStartDate;
	private $_reservationEndDate;

	//Constructreur
	function __construct($data){
	    if ($data != null)
	      $this->hydrate($data);
  	}

  	//Insertion de valeur à partir d'un tableau
  	public function hydrate(array $data){
	    foreach ($data as $key => $value){
	      switch ($key) {
	        case 'email':
	          	$this->SetEmail($value);
	          	break;
	        case 'idServiceContent':
	          	$this->SetIdServiceContent($value);
	          	break;
	        case 'reservationStartDate':
	          	$this->SetReservationStartDate($value);
	         	 break;
	        case 'reservationEndDate':
				$this->SetReservationEndDate($value);
				break;
	        case 'site':
	        	$this->SetSite($value);

	      }
	    }
	  }
	//email
	public function SetEmail($email = '0'){
		if($email == '0')
			return $this->_email;
		else 
	    	return $this->_email = $email;  
    }

    //idServiceContent
	public function SetIdServiceContent($idServiceContent= '0'){
		if($idServiceContent == '0')
			return $this->_idServiceContent;
		else
	    	return $this->_idServiceContent = $idServiceContent;  
    }

    //reservationStartDate
	public function SetReservationStartDate($date = '0'){
	    if($date == '0')
	      	return $this->_reservationStartDate;
	    else	
	      	return $this->_reservationStartDate = $date;
    }	

    //reservationEndDate
	public function SetReservationEndDate($date = '0'){
	    if($date == '0')
	      	return $this->_reservationEndDate;
	    else
	    	return $this->_reservationEndDate = $date;  
    }

    //site
	public function SetSite($site = '0'){
	    return $this->_site = $site ;  
    }

    //afficher les informations
    public function speak(){
		echo  	"<br>\$_site : ".$this->_site.
				"<br>\$_idServiceContent : ".$this->_idServiceContent.
				/*"<br>\$_reservationStartDate : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_reservationStartDate).
				"<br>\$_reservationEndDate : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_reservationEndDate).*/
				"<br>\$_reservationStartDate : ".$this->_reservationStartDate.
				"<br>\$_reservationEndDate : ".$this->_reservationEndDate.
				"<br>\$_email : ".$this->_email;
  }

}	

class ReservationMng
{
  	private $_db;

  	//Constructeur
	function __construct($db){
    	$this->setDb($db);
  	}
  	//Information database
  	public function setDb(PDO $db){
		$this->_db = $db;
  	}

  	//Recuperer les informations de le BDD
  	public function get($id){
	    try {
	      	$query = $this->_db->prepare('SELECT * FROM RESERVATION WHERE id:id');
	      	$query->execute( ["id"=>$id]);
	    } catch(Exception $e) {
	        echo "PDOException : " . $e->getMessage();
	    }
	    $data = $query->fetch(PDO::FETCH_ASSOC);
	    return new Reservation($data);
  	}

  	public function add($id){
  		$query = $this->_db->prepare("INSERT INTO RESERVATION (email,idServiceContent,reservationStartDate,reservationEndDate)
                                  VALUES (:email,:idServiceContent,:reservationStartDate,:reservationEndDate);");
		$query->execute( [
			"idServiceContent"=>$id->SetIdServiceContent(),
			"email"=>$id->SetEmail(),
			"reservationStartDate"=>$id->SetReservationStartDate(),
			"reservationEndDate"=>$id->SetReservationEndDate()
			]);
  	}
}
