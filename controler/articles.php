<?php

//INCLUDES
include_once(PATH_LIBS.'lib_articles.php');

//VARS
$var_page = "articles";

//GET
$get_lang 		= ifsetor($_GET["lang"], "fr");
$get_action 	= ifsetor($_GET["action"], "view");
$get_art_id		= ifsetor($_GET["art_id"], "");
$get_art_sect	= ifsetor($_GET["id_sect"], "");
//var_dump($get_art_sect);
$get_art_categ	= ifsetor($_GET["categ_id"], "");//art_categ

//pagination
$get_num_p		= ifsetor($_GET["num_p"],"");

//POST
$post_comment	= ifsetor($_POST["art_comment"], "");
$post_art_cote	= ifsetor($_POST["art_cote"], "");
$post_submit	= ifsetor($_POST["submit"], "");

//CHECK
$is_empty_comment = "";
$is_empty_cote = "";

$display_error_comment 	= "";
$display_error_cote		= "";

switch($get_action){
	case 'view':
		$display_art_list 	= getArticleList($get_lang, 0, $get_art_sect, $get_art_categ, "DESC");
		
		// gestion du menu
		$display_art_section 	= getArtSect(0, 0, "ASC");
		$display_cat_by_sec 	= displayCategBySection(0,0);
		
		$page				= "articles";
		$get_action 		= "view";
	break;
		
	case 'detail':
		$display_article 	= getArticleList($get_lang, $get_art_id, 0, 0, "DESC");
		$coteByArt 			= getCotationByArt($get_art_id);
		$commentByArt 		= getCommentsByArt($get_art_id);
		$page 				= "articles";
		$get_action 		= "detail";
	break;
	
	case 'send_comment':
		$display_article 	= getArticleList($get_lang, $get_art_id, 0, 0, "DESC");
		$coteByArt 			= getCotationByArt($get_art_id);
		$commentByArt 		= getCommentsByArt($get_art_id);
		
		if(!$post_comment || !$post_art_cote){
			if($post_submit){
				
				if(!$post_comment){
					$is_empty_comment 		.= " emptyField";
					$display_error_comment 	.= $get_lang == "fr"? "Pas de commentaire ?!":"No comments ?!";
				}
				if(!$post_art_cote){
					$is_empty_cote 			.= " emptyField";
					$display_error_cote 	.= $get_lang == "fr"? "Merci de donner une note à l'article":"Thanks give a score to the article.";
				}				
			}
			

			$page 				= "articles";
			$get_action 		= "detail";
			
		}else{
			$post_comment 		= htmlentities($post_comment, ENT_QUOTES, "utf-8");
			$new_comment 		= insertMyComment($post_comment);
			$last_id_comment 	= mysql_insert_id();
			
			if($new_comment){
				$new_mbre_comment 	= insertMembreComment($_SESSION["m_membre_id"], $last_id_comment);
				$new_art_comment 	= insertArticleComment($get_art_id, $last_id_comment);
				$new_art_cote		= insertArtCote($get_art_id, $_SESSION["m_membre_id"], $post_art_cote);
			}
			
			$display_art_list 		= getArticleList($get_lang, 0, 0, 0, "DESC");
			$display_art_section 	= getArtSect(0, 0, "ASC");
			$display_cat_by_sec 	= displayCategBySection(0,0);
			$page 					= "articles";
			$get_action 			= "detail"; //avant view
			$commentByArt 			= getCommentsByArt($get_art_id);
		}
		

	break;
}
?>
