<?php
//BASE/config

define("DB_NOM","phoneandco");
define("DB_PASS","123");
define("DB_SERVEUR","localhost");
define("DB_BASE","phoneandco");
define("DB_PREFIXE","pac_");

// DB
//define("DB_NOM", "root");
//define("DB_PASS", "");
//define("DB_SERVEUR", "localhost");
//define("DB_BASE", "phoneandco");
//define("DB_PREFIXE", "pac_");

// upload
define("WWW_UP", "admin_private_phco_area/upload/");

//IMG
define("WWW_IMG", "img/");

// pages
define("PATH_CONTROLER","controler/");
define("PATH_VIEW","view/");
define("PATH_LIBS","lib/");
define("PATH_BASE","base/");

//minimir -> pour info.
//define("PATH_SITE","http://minimir.isl.be/gasquyn/project_phone_and_co/");

//debug
define("DEBUG",false);

// acces aux fonctions
include_once('fct_db.php');
include_once('fct_global.php');

// connexion à la base de donnnées
$connexion = Connexion(DB_NOM, DB_PASS, DB_BASE, DB_SERVEUR);
//$connexion = new PDO('mysql:host='.DB_SERVEUR.';dbname='.DB_BASE.';charset=utf8',DB_NOM,DB_PASS);
?>