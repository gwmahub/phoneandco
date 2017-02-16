<?php

//INCLUDES
include_once(PATH_LIBS."lib_home.php");

//VARS
$var_page = "home";
$display_slides = getSlides(0, "DESC", 0, 10);
$displayLastAp 	= getLastAp(4); 
$displayLastArt = getLastArt($get_lang, 4);// getArticleList($get_lang, 0, 0, 0, 0);

//GET
$get_lang 		= ifsetor($_GET['lang'], "fr");



?>



