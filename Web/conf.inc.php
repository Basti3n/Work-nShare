<?php

define("DB_USER","root");
define("DB_PWD","");
define("DB_HOST","localhost");
define("DB_NAME","worknshare");

$listOfErrors =
[
	1=>"Le nom doit faire entre 2 et 50 caractères",
	2=>"Le prénom doit faire entre 2 et 50 caractères",
	3=>"Le pseudo doit faire entre 2 et 50 caractères",
	4=>"Le mot de passe doit faire entre 8 et 64 caractères",
	5=>"Le mot de passe de confirmation ne correspond pas",
	6=>"L'email n'est pas valide",
	7=>"Le format de date n'est pas valide",
	8=>"Le format de date n'est pas valide",
	10=>"La date n'est pas valide",
	15=>"L'adresse email existe déja",
	16=>"Le type n'est pas valide",
	17=>"Les identifiants ne sont pas valides",
	18=>"Le psoeudo existe déja",
	19=>"Le compte a été supprimé",
	20=>"L'ancien mot de passe ne corespond pas",
	21=>"Le nouveau mot de passe et le mot de passe de confirmation ne correspondent pas",
	22=>"Le mot de passe a bien été modifié"
];
