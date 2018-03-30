<?php

date_default_timezone_set('Europe/Paris');

class Reservation{
	private $_site= "empty";
	private $_email = "empty";
	private $_idServiceContent = 0;
	private $_reservationStartDateSignup;
	private $_reservationEndDateSignup;

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
	          	$this->email($value);
	          	break;
	        case 'idServiceContent':
	          	$this->idServiceContent($value);
	          	break;
	        case 'reservationStartDate':
	          	$this->reservationStartDateSignup($value);
	         	 break;
	        case 'reservationEndDate':
				$this->reservationEndDateSignup($value);
				break;
	        case 'site':
	        	$this->site($value);

	      }
	    }
	  }
	//email
	public function email($email = '0'){
		if($email == '0')
			return $this->_email;
		else
	    	return $this->_email = $email;
    }

    //idServiceContent
	public function idServiceContent($idServiceContent= '0'){
		if($idServiceContent == '0')
			return $this->_idServiceContent;
		else
	    	return $this->_idServiceContent = $idServiceContent;
    }

    //reservationStartDateSignup
	public function reservationStartDateSignup($date = '0'){
	    if($date == '0')
	      	return $this->_reservationStartDateSignup;
	    else
	      	return $this->_reservationStartDateSignup = $date;
    }

    //reservationEndDateSignup
	public function reservationEndDateSignup($date = '0'){
	    if($date == '0')
	      	return $this->_reservationEndDateSignup;
	    else
	    	return $this->_reservationEndDateSignup = $date;
    }

    //site
	public function site($site = '0'){
	    return $this->_site = $site ;
    }

    //afficher les informations
    public function speak(){
		echo  	"<br>\$_site : ".$this->_site.
				"<br>\$_idServiceContent : ".$this->_idServiceContent.
				/*"<br>\$_reservationStartDateSignup : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_reservationStartDateSignup).
				"<br>\$_reservationEndDateSignup : le ".date('j \/ m \/ Y \à G \h i \: s',$this->_reservationEndDateSignup).*/
				"<br>\$_reservationStartDateSignup : ".$this->_reservationStartDateSignup.
				"<br>\$_reservationEndDateSignup : ".$this->_reservationEndDateSignup.
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
  		$query = $this->_db->prepare("INSERT INTO RESERVATION (email,idServiceContent,reservationStartDateSignup,reservationEndDateSignup)
                                  VALUES (:email,:idServiceContent,:reservationStartDateSignup,:reservationEndDateSignup);");
		$query->execute( [
			"idServiceContent"=>$id->idServiceContent(),
			"email"=>$id->email(),
			"reservationStartDateSignup"=>$id->reservationStartDateSignup(),
			"reservationEndDateSignup"=>$id->reservationEndDateSignup()
			]);
  	}
}
