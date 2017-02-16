<?php

//Reste à faire : 
// possibilité de changer les catégories associées à cette section -> UPDATE pac_art_sec_categ_assoc
// possibilité de supprimer les catégories associées à cette section -> UPDATE pac_art_sec_categ_assoc


//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_tools.php');
include_once(PATH_LIBS.'lib_admin_article_categorie.php');
include_once(PATH_LIBS.'lib_admin_article_section.php');


//vars
$var_page		=	"admin_article_section";
$display_form	=	false;
//get
$get_sect_id	=	ifsetor($_GET["art_sect_id"], "");
$get_action		=	ifsetor($_GET['action'], "view");

//post
$post_sect_fr	= 	ifsetor($_POST['art_sect_fr'], "");
$post_sect_en	= 	ifsetor($_POST['art_sect_en'], "");
$post_submit	= 	ifsetor($_POST['submit'],"");

//array des catégories existantes associées à la section
$post_sect_cat_ass = ifsetor($_POST["sect_cat_ass"],"");//récupère les id des catégories associées à la section
//var_dump($post_sect_cat_ass);

// array des nouvelles catégories 
$post_new_categ = ifsetor($_POST["new_art_categ"],"");//récupère les intitulés des catégories
//var_dump($post_new_categ);

//array des nouvelles catégories associées à la section
$post_sect_new_cat_ass = ifsetor($_POST["sect_cat_ass"],"");//récupère les id des nouvelles catégories



$is_empty_sect_fr = "";
$is_empty_sect_en = "";

$display_error_art_sect_en = "";
$display_error_art_sect_fr = "";

/*if(isset($get_sect_id) && !is_numeric($get_sect_id)){
	header("location:?p=admin_article_section");
	exit;
}*/

switch ($get_action) {
	case 'view':
		$display_art_sect = getArtSect(0, 0, 0);
		$page = "admin_article_section";
		break;
		
	case 'add':
		//affichage des catégories déjà existantes
		$display_art_categ = getArtCateg(0, 1);
				
		if(!$post_sect_fr || !is_txtComplex($post_sect_fr) || !$post_sect_en || !is_txtComplex($post_sect_en)){
			if($post_submit){
				
				if(!$post_sect_fr || !is_txtComplex($post_sect_fr)){
					$is_empty_sect_fr .= " emptyField";
					$display_error_art_sect_fr .= "<p>La catégorie FR indiquée n'est pas valide. Exemple: Smartphones.</p>";
				}
				if(!$post_sect_en || !is_txtComplex($post_sect_en)){
					$is_empty_sect_en .= " emptyField";
					$display_error_art_sect_en .= "<p>La catégorie EN indiquée n'est pas valide. Exemple: Smartphones.</p>";
				}
			}
			$display_form = true;
			$page = "admin_article_section";
			$get_action = "add";
			
		}else{
			$new_art_sect 		= insertArtSect($post_sect_fr, $post_sect_en);

			if($new_art_sect){
				//Récupération de la l'id de la section  
				$id_new_art_sect 	= mysql_insert_id();
				//si des catégories existantes sont sélectionnées
				if($post_sect_cat_ass != null){
					//association à la section
					$categ_by_sect 	= insertCategBySection($id_new_art_sect, $post_sect_cat_ass);
					//var_dump($categ_by_sect);
				}

				//si de nouvelles catégories sont créées
				if(!empty($post_new_categ)){
					//vérification de l'envoi de champs vides -> filtrage
					if(in_array("", $post_new_categ)){
						$post_new_categ = array_filter($post_new_categ);
						//var_dump($post_new_categ);
					}
					//insertion des nouvelles catégories et récupération des id
					$new_categ_tab_id = insertMultiArtCateg($post_new_categ);//return new created id
					//si les id sont bien récupérés
					if($new_categ_tab_id){
						//association à la section
						$new_categ_by_sect 	= insertCategBySection($id_new_art_sect, $new_categ_tab_id);
					}
				}
				
				$display_form = false;
				$display_art_sect = getArtSect(0,0,0); 
				$page = "admin_article_section";
				$get_action = "view";		
			}
		}

		break;
		
	case 'update':
		$display_art_sect = getArtSect($get_sect_id,0,0);
		//var_dump($display_art_sect);//ok
		if(!$post_sect_fr || !is_txt($post_sect_fr) || !$post_sect_en || !is_txt($post_sect_en)){
				
			if(!$post_submit){
				
				foreach ($display_art_sect AS $artSect) {
					$art_sect_id	=	$artSect['article_section_id'];
					$art_sect_fr	=	$artSect['article_section_fr'];
					$art_sect_en	=	$artSect['article_section_en'];
				}
				
			}else{
				if(!$post_sect_fr || !is_txt($post_sect_fr)){
					$is_empty_sect_fr .= " emptyField";
				}
				if(!$post_sect_en || !is_txt($post_sect_en)){
					$is_empty_sect_en .= " emptyField";
				}
			}
			
			$display_form = true;
			$page = "admin_article_section";
			$get_action = "update";
			
		}else{
			$upd_art_sect = updArtSect($get_sect_id, $post_sect_fr, $post_sect_en);
			$display_form = false;
			$display_art_sect = getArtSect(0,0,0); 
			$page = "admin_article_section";
			$get_action = "view";		

		}

		break;
		
	case 'delete':
		$delete_art_sect = delReactArtSect($get_sect_id, 0);
		$display_art_sect = getArtSect(0,0,0);
		$page = "admin_article_section";
		$get_action = "view";
		
		break;
		
	case 'reactive':
		$reactive_art_sect = delReactArtSect($get_sect_id, 1);
		$display_art_sect = getArtSect(0,0,0);
		$page = "admin_article_section";
		$get_action = "view";
		break;
}

?>