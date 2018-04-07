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
	20=>"Le nom du content service doit être composé de 80 caractères au maximum"
];

$ts = [
	1=>"Nouveau",
	2=>"En cours",
	3=>"Résolu",
	4=>"En attente",
	5=>"En retard"
];

$tc = [
	1=>"Matériel",
	2=>"Réseau",
	3=>"Alimentaire",
	4=>"Réservation",
	5=>"Autre"
];
