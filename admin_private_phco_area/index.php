<?php
session_start();
include_once('base/config.php');

// récupération de la page de destination via $_GET
$page = ifsetor($_GET["p"], "login_admin");

//choix de la langue
$get_lang = ifsetor($_GET["lang"], "fr");

if($get_lang){
	$_SESSION["langue"] = $get_lang;
}

// on initialise la variable $show_txt_page
$show_txt_page = "";

// on va rechercher la page du controler où sont stockées les fonctions relatives à la page

if(file_exists(PATH_CONTROLER.$page.".php")){
    include_once(PATH_CONTROLER.$page.".php");
}else{
    include_once(PATH_CONTROLER."404.php");
}

include_once('includes/head.php');

include_once('includes/header.php');

?>

   <div id="content">
                <?php
                    // 
                    if(file_exists(PATH_VIEW.$page.".php")){
                        include_once(PATH_VIEW.$page.".php");
                    }else{
                        include_once(PATH_VIEW."404.php");
                    }
                ?>
            <div class="clearboth"></div>
	</div><!--END #content-->
<?php

	include_once('includes/footer.php');

?>
<script type="text/javascript" src="js/tcal.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>



</body>
</html>