<?php
//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_admin_article_categorie.php');
include_once(PATH_LIBS.'lib_admin_article_section.php');
include_once(PATH_LIBS.'lib_tools.php');

//vars
$var_page		=	"admin_article_categorie";
$display_form	=	false;
//get
$get_categ_id	=	ifsetor($_GET["categ_id"], "");
$get_action		=	ifsetor($_GET['action'], "view");

//post
$post_categ_fr	= 	ifsetor($_POST['art_categ_fr'], "");
$post_categ_en	= 	ifsetor($_POST['art_categ_en'], "");
$post_art_sect_id = ifsetor($_POST["art_sect"],"");
$post_submit	= 	ifsetor($_POST['submit'],"");

$is_empty_categ_fr = "";
$is_empty_categ_en = "";
$is_empty_cat_sect = "";

$msg_error_cat_sect = "";



/*if(isset($get_categ_id) && !is_numeric($get_categ_id)){
	header("location:?p=admin_article_categorie");
	exit;
}*/

switch ($get_action) {
	case 'view':
		$display_art_categ = getArtCateg(0, 0);
		$page = "admin_article_categorie";
		break;
		
	case 'add':
		//affichage des sections existantes
		$display_art_sect = getArtSect(0, 0, "ASC");
		if(!$post_categ_fr || !is_txt($post_categ_fr) || !$post_categ_en || !is_txt($post_categ_en) || !$post_art_sect_id){
			if($post_submit){
				
				if(!$post_categ_fr || !is_txt($post_categ_fr)){
					$is_empty_categ_fr .= " emptyField";
				}
				if(!$post_categ_en || !is_txt($post_categ_en)){
					$is_empty_categ_en .= " emptyField";
				}
				
				if(!$post_art_sect_id){
					$is_empty_cat_sect 	.= " emptyField"; 
					$msg_error_cat_sect .= "<span style='font-weight: bolder; color: red;'>Le choix de la section est obligatoire.</span>";
				}
			}
			$display_form = true;
			$page = "admin_article_categorie";
			$get_action = "add";
			
		}else{
			$new_art_categ = insertArtCateg($post_categ_fr, $post_categ_en);
			$new_art_categ_id = mysql_insert_id();
			
			if($new_art_categ){
				$categ_sect_assoc = insertArtCategAliasSect($new_art_categ_id, $post_art_sect_id);
				if($categ_sect_assoc){
					$display_form = false;
					$display_art_categ = getArtCateg(0,0); 
					$page = "admin_article_categorie";
					$get_action = "view";
				}
			}
		}

		break;
		
	case 'update':
		$display_art_categ = getArtCateg($get_categ_id,0);
		if(!$post_categ_fr || !is_txt($post_categ_fr) || !$post_categ_en || !is_txt($post_categ_en)){
				
			if(!$post_submit){
				
				foreach ($display_art_categ AS $artCat) {
					$art_categ_id	=	$artCat['article_categ_id'];
					$art_categ_fr	=	$artCat['article_categ_fr'];
					$art_categ_en	=	$artCat['article_categ_en'];
				}
				
			}else{
				if(!$post_categ_fr || !is_txt($post_categ_fr)){
					$is_empty_categ_fr .= " emptyField";
				}
				if(!$post_categ_en || !is_txt($post_categ_en)){
					$is_empty_categ_en .= " emptyField";
				}
			}
			
			$display_form = true;
			$page = "admin_article_categorie";
			$get_action = "update";
			
		}else{
			$upd_art_categ = updArtCateg($get_categ_id, $post_categ_fr, $post_categ_en);
			$display_form = false;
			$display_art_categ = getArtCateg(0,0); 
			$page = "admin_article_categorie";
			$get_action = "view";		

		}

		break;
		
	case 'delete':
		$delete_art_categ 	= delReactArtCateg($get_categ_id, 0);
		$display_art_categ 	= getArtCateg(0,0);
		$page 				= "admin_article_categorie";
		$get_action 		= "view";
		break;
		
	case 'reactive':
		$reactive_art_categ 	= delReactArtCateg($get_categ_id, 1);
		$display_art_categ 		= getArtCateg(0,0);
		$page 					= "admin_article_categorie";
		$get_action 			= "view";
		break;
}

?>