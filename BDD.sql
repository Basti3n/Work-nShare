CREATE TABLE USERS(
	email varchar(80) PRIMARY KEY,
	nameUser varchar(80),
   	lastnameUser varchar(80),
    dateSignUp DATETIME,
    passwordUser varchar(80),
    isDeleted integer DEFAULT 0,
    statusUser integer,
    qrCode varchar(100),
    qrCodeToken varchar(80),
    accessToken varchar(80)
);


CREATE TABLE SUBSCRIPTIONS(
  	idSubscription INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    price REAL,
    listRights TEXT   
);

CREATE TABLE SPACES(
	idSpace char(7) PRIMARY KEY,
    nameSpace VARCHAR(80),
    isDeleted INTEGER DEFAULT FALSE

);


CREATE TABLE SERVICES(
	idService integer NOT NULL AUTO_INCREMENT,
	idSpace char(7) REFERENCES SPACES(idSpace),
    isBooked integer,
    nameService VARCHAR(80),
    compInfo TEXT,
    idDeleted INTEGER DEFAULT 0,
    PRIMARY KEY(idService,idSpace)
);



CREATE TABLE SPACEEVENTS(
	idEvent integer NOT NULL AUTO_INCREMENT primary Key,
    descriptionEvent TEXT,
    nameEvent VARCHAR(80),
    idDeleted INTEGER DEFAULT 0
);

CREATE TABLE TICKETSCATEGORIES(
	nameCategory varchar(80) PRIMARY KEY
);

CREATE TABLE TICKETS(
	idTicket INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    contentTicket TEXT,
    statusTicket VARCHAR(40),
    email varchar(80) REFERENCES USERS(email),
    ticketLinkDoc varchar(80),
    ticketCategory varchar(80) REFERENCES TICKETSCATEGORIES(nameCategory),
    idEquipment INTEGER REFERENCES EQUIPMENTS(idEquipment)
);


CREATE TABLE EQUIPMENTS(
	idEquipment INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    isDeleted INTEGER DEFAULT 0,
    equipmentName VARCHAR(80),
    isFree INTEGER,
    lastCheckDate DATETIME,
    idSpace char(7) REFERENCES SPACES(idSpace)
);

CREATE TABLE ISSUBSCRIBED(
	email VARCHAR(80) REFERENCES USERS(email),
    idSubscription integer REFERENCES SUBSCRIPTION(idSUBSCRIPTION),
    dateSubscription DATETIME,
    dateEndSubscription DATETIME,
    PRIMARY KEY(email,idSubscription)
);


CREATE TABLE RESERVATION(
	idReservation INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(80) REFERENCES USERS(email),
	idServiceContent INTEGER references service_content(idServiceContent),
	reservationStartDate DATETIME,
	reservationEndDate DATETIME
);

CREATE TABLE SERVICE_CONTENT(
	idServiceContent INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	informationServiceContent TEXT,
	nameServiceContent VARCHAR(80),
	isFree INTEGER,
	isDeleted INTEGER DEFAULT 0,
	idService char(7) REFERENCES SPACES(idSpace)
);

CREATE TABLE ACCESS(
	email VARCHAR(80) REFERENCES USERS(email),
    idSpace char(7) REFERENCES SPACES(idSpace),
    idAccess int,
    dateAccess DATETIME,
    PRIMARY KEY(email,idSpace,idAccess)

);


CREATE TABLE EXITSPACE(
	email VARCHAR(80) REFERENCES USERS(email),
    idSpace char(7) REFERENCES SPACES(idSpace),
    idExit int,
    dateExit DATETIME,
    PRIMARY KEY(email,idSpace,idExit)
);


CREATE TABLE isPlaned(
    idSpace char(7) REFERENCES SPACES(idSpace),
	idEvent INTEGER REFERENCES SPACEEVENTS(idEvent),
    eventStartDate DATETIME,
    eventEndDate DATETIME,
    PRIMARY KEY(idSpace,idEvent)
);

CREATE TABLE isEquiped(
    idSpace char(7) REFERENCES SPACES(idSpace),
	idEquipment INTEGER REFERENCES EQUIPMENTS(idEquipment),
    PRIMARY KEY(idSpace,idEquipment)
);