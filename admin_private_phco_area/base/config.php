<?php
//BASE/config

// DB

define("DB_NOM","phoneandco");
define("DB_PASS","123");
define("DB_SERVEUR","localhost");
define("DB_BASE","phoneandco");
define("DB_PREFIXE","pac_");

//define("DB_NOM", "root");
//define("DB_PASS", "");
//define("DB_SERVEUR", "localhost");
//define("DB_BASE", "phoneandco");
//define("DB_PREFIXE", "pac_");

// PAGES
define("PATH_CONTROLER","controler/");
define("PATH_VIEW","view/");
define("PATH_LIBS","lib/");
define("PATH_BASE","base/");

//CSS
define("PATH_CSS", "css/");
//IMAGES
define("WWW_IMG", "img/");
//UPLOAD
define("WWW_UP", "upload/");

//DOCS
define("WWW_DOC", "upload_docs/");



// PATH server isl
define("PATH_ISL","http://minimir.isl.be/gasquyn/projet_mvc_php/index.php");

//debug
define("DEBUG",false);

// acces aux fonctions
include_once('fct_db.php');
include_once('fct_global.php');

// connexion à la base de donnnées
$connexion = Connexion(DB_NOM, DB_PASS, DB_BASE, DB_SERVEUR);
?>