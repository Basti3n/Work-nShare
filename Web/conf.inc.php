<?php

define("DB_USER","root");
define("DB_PWD","");
define("DB_HOST","localhost");
define("DB_NAME","worknshare");


$listOfErrors = [
	1=>"Le nom doit faire entre 2 et 50 caractères",
	2=>"Le prénom doit faire entre 2 et 50 caractères",
	3=>"Le mot de passe doit faire entre 8 et 64 caractères",
	4=>"Le mot de passe de confirmation ne correspond pas",
	5=>"L'email n'est pas valide",
	6=>"L'email de confirmation ne correspond pas.",
	7=>"Le captcha n'est pas valide.",
	8=>"Une erreur est survenue lors de la création du compte.",
	9=>"L'adresse email existe déja",
	10=>"La date n'est pas valide",
	11=>"Le type n'est pas valide",
	12=>"Les identifiants ne sont pas valides",
	13=>"Le compte a été supprimé",
	14=>"L'ancien mot de passe ne corespond pas",
	15=>"Le nouveau mot de passe et le mot de passe de confirmation ne correspondent pas",
	16=>"Le mot de passe a bien été modifié",
	17=>"L'id de l'espace doit être composé de 7 caractères",
	18=>"Le nom de l'espace doit être composé de 25 caractères au maximum",
	19=>"Le nom du service doit être composé de 80 caractère au maximum",
	20=>"Le nom du content service doit être composé de 80 caractères au maximum",
	21=>"Vous devez valider votre email en cliquant sur le lien envoyé à celle-ci"
];

$ts = [
	1=>"Nouveau",
	2=>"En cours",
	3=>"Résolu",
	4=>"En attente",
	5=>"En retard"
];

$tc = [
	4=>"Réservation",
	1=>"Matériel",
	2=>"Réseau",
	3=>"Alimentaire",
	5=>"Autre",
	6=>"Administratif"
];

$statusUserArray =[
		0=>"Super admin",
		1=>"Admin",
		2=>"Employé",
		3=>"Utilisateur"
];

$statusTicket =[
	0=>"Ouvert",
	1=>"Nouveau",
	2=>"En cours",
	3=>"Résolue",
	4=>"En attente",
	5=>"En retard"
];

$nameSpace =[
	0=>"Bastille",
	1=>"République",
	2=>"Odéon",
	3=>"Place d'Italie",
	4=>"Beaubourg",
	5=>"Ternes"
];
