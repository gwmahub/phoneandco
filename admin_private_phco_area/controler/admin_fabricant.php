<?php
//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_admin_fabricant.php');
include_once(PATH_LIBS.'lib_admin_appareil_categ.php');
include_once(PATH_LIBS."lib_tools.php");

//VARS
$var_page 	= "admin_fabricant";
$logo 		= "";
$no_logo 	= "no_logo.jpg";

//GET
$get_fab_id		= ifsetor($_GET["fab_id"], "");
$get_action		= ifsetor($_GET["action"], "");

//POST
$post_fab_nom		= ifsetor($_POST["fab_nom"],"");
$post_ap_fab_id 	= ifsetor($_POST["ap_fab"],"");
$post_is_visible 	= ifsetor($_POST["is_visible"], "");

//récupération des id des catégories d'appareil
$post_ap_categ		= ifsetor($_POST["ap_categ"],"");

$post_submit		= ifsetor($_POST["submit"],"");
//case update
$post_old_logo	 	= ifsetor($_POST["old_logo"], "");

//FILES
$file_logo	 		= ifsetor($_FILES["src_fichier"],"");

//CHECK
$is_empty_fab_nom	= "";
$is_empty_cat_fab 	= "";
$is_empty_ap_categ	= "";
$is_empty_logo		= "";

$display_error_fab_nom  	= "";
$display_error_logo	 		= "";
$display_error_ap_categ		= "";



switch ($get_action) {
	case 'view':
		//affichage des fournisseurs déjà enregistrés
		$display_fab	= getFabricant(0, 0, "ASC");
		$page 		= "admin_fabricant";
		$get_action = "view";
	break;
	
	case 'add':
		//Affichage des catégories d'appareil déjà existantes...
		$display_ap_categ = getApCateg(0, "1");

		if(!$post_fab_nom || !is_txt($post_fab_nom) || empty($file_logo["name"]) || !$post_ap_categ){
			if($post_submit){

				if(!$post_fab_nom || is_txt($post_fab_nom)){
					$is_empty_fab_nom		.= " emptyField";
					$display_error_fab_nom 	.= "Le texte indiqué n'est pas valide ou le champs est vide";
				}
				if(empty($file_logo["name"])){
					$is_empty_logo		 	.= " emptyField";
					$display_error_logo  	.= "Vous devez choisir une image. !! Dimensions: width: 1000px; height: 300px;";
				}
				if(!$post_ap_categ){
					$is_empty_ap_categ .= " emptyField";
					$display_error_ap_categ .= "Vous devez sélectionner les types d'appareils que ce fabricant propose.";
				}
			}
			$page 		= "admin_fabricant";
			$get_action = "add";
			
		}else{

			if(!empty($file_logo['name'])){
				$upload = uploadImg($_FILES, "fabricants/");
					if(!$upload){
						$show_txt_page .= "Problème : Votre logo n'a pas été uploadé.";
					}else{
						$logo .= $upload['img'];
					}
				}else{
					$logo .= $no_logo;
				}

						
			$new_fab = insertFab($logo, $post_fab_nom, $post_is_visible);
			
			if($new_fab){
				
				$new_fab_id = mysqli_insert_id($connexion);
				
				$new_fab_ap_categ_assoc = insertApCategByFab($new_fab_id, $post_ap_categ);
				
				//debug
				if($new_fab_ap_categ_assoc){
					$show_txt_page .= "<p style='color: green;'><b>Les catégories d'appareils ont bien été associées à ce fabricant.</b></p>";
				}else{
					$show_txt_page .= "<p style='color: red;'><b>Les catégories d'appareils n'ont pas été associées à ce fabricant. Réessayez.</b></p>";
				}
				
				//gestion de l'image
				$logo_path = "";
				
				$logo_path .= WWW_UP."fabricants/".$logo;
				$check_img_ext = getimagesize($logo_path);
				
				if($check_img_ext[2] == 1){
					if(!resize_gif($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
						$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}elseif($check_img_ext[2] == 2){
					if(!resize_jpg($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
						$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}elseif($check_img_ext[2] == 3){
					if(!resize_png($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
						$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}else{
					$show_txt_page .= "<h3>Le logo envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>";
				}
			
			}
			$display_fab 				= getFabricant(0, 0, "ASC");
			$display_ap_categ_by_fab 	= getApCategByFab($get_fab_id);
			$page 						= "admin_fabricant";
			$get_action 				= "view";
		}

	break;
	
	case 'update':
		$display_fab 				= getFabricant($get_fab_id,0, 0);
		//affichage des categ d'appareil -> nouvelle association pour ce fabricant
		$display_ap_categ			= getApCateg(0, "1");
		//ap_categ de ce fabricant
		$display_ap_categ_by_fab 	= getApCategByFab($get_fab_id);
		//si un des champs obli est vide...
		//MEMO ici pas d'input file ou ap_categ obli car un logo existe déjà et les catégories associées d'appareils existent déjà
		if(!$post_fab_nom || !is_txt($post_fab_nom)){
			
			if(!$post_submit){
				
				if(is_array($display_fab) && !empty($display_fab)){
					foreach($display_fab AS $df){
						$fab_id			= $df["fab_id"];
						$logo 			= $df["fab_logo"];
						$fab_is_visible	= $df["fab_is_visible"];
					}
					
					if(is_array($display_ap_categ_by_fab) && !empty($display_ap_categ_by_fab)){
						foreach($display_ap_categ_by_fab AS $dacbf){
							$ap_categ_id	= $dacbf["ap_categ_id"];
							$ap_categ_fr	= $dacbf["ap_categ_fr"];//type d'appareil -> tablettes, ...
							$is_visible		= $dacbf["is_visible"];
						}
					}
				}
			
			}else{
				if(!$post_fab_nom || !is_txt($post_fab_nom)){
					$is_empty_fab_nom			.= " emptyField";
					$display_error_fab_nom  	.= "Le texte indiqué n'est pas valide";
				}
			}
			
			$page 		= "admin_fabricant";
			$get_action = "update";
			
		}else{
				//si des catégories d'appareil sont sélectionnées
				if($post_ap_categ){
					// si des catégories étaient déjà associées
					if($old_categ = getApCategByFab($get_fab_id)){
						print_q($old_categ);
						//suppression des anciennes associations
						$del_old_ap_categ_by_fab = delOldApCategByFab($get_fab_id);
						var_dump($del_old_ap_categ_by_fab);
						// si la suppression à été effectuée...
						if($del_old_ap_categ_by_fab){
							//insertion des nouvelles associations
							$new_fab_ap_categ_assoc = insertApCategByFab($get_fab_id, $post_ap_categ);
							//debug
							if($new_fab_ap_categ_assoc){
								$show_txt_page .= "<p style='color: green;'><b>Les catégories d'appareils ont bien été associées à ce fabricant.</b></p>";
							}else{
								$show_txt_page .= "<p style='color: red;'><b>Les catégories d'appareils n'ont pas été associées à ce fabricant. Réessayez.</b></p>";
							}
						}else{
								$show_txt_page .= "<p style='color: red;'><b>Les catégories d'appareils n'ont pas été supprimées. Réessayez.</b></p>";
						}
					}else{
						// si aucune catégoriés associées avant
						// insertion somple ds la table
						$new_fab_ap_categ_assoc = insertApCategByFab($get_fab_id, $post_ap_categ);
					}
				}

			//si un logo est envoyé et qu'il est différent de l'ancien...
			if(!empty($file_logo["name"]) && ($file_logo["name"] != $post_old_logo)){
					
				//upload du nouveau logo	
				$upload = uploadImg($_FILES, "fabricants/");
					if(!$upload){
						$show_txt_page .= "<p style='color: red; font-weight: bolder;'>&rarr;Le logo envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</p>";
					}else{
								
						//var_dump($upload);	

						//si l'upload s'est bien déroulé...
						$logo .= $upload['img'];
						
						$logo_path = "";
						
						//définition du lien
						$logo_path .= WWW_UP."fabricants/".$logo;
						//var_dump($logo_path);//ok
						$check_img_ext = getimagesize($logo_path);
						//resizing pour le thumb
						if($check_img_ext[2] == 1){
							if(!resize_gif($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
								$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}elseif($check_img_ext[2] == 2){
							if(!resize_jpg($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
								$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}elseif($check_img_ext[2] == 3){
							if(!resize_png($logo_path, 85, "thumb_".$logo, WWW_UP."fabricants/fab_thumb/")){
								$display_error_logo .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}else{
							$show_txt_page .= "<h3>Le logo envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>";
						}
						
						//suppression de l'ancien logo et du thumb
						if($del_old_logo = delPicFile($post_old_logo,"fabricants/")){
							//echo "<p>Fichier supprimé avec succès</p>";//ok
							$del_old_logo  	= delPicFile($post_old_logo, "fabricants/fab_thumb/thumb_");//ok
							
						}else{
							echo "<p>Echec de la suppresion des fichiers</p>";
						}
					}
				//si pas de nouveau logo ...	
				}else{
					$logo .= $post_old_logo;
				}
			
			//update des données
			$upd_fab = updateFab($get_fab_id, $logo, $post_fab_nom);
			
			if($upd_fab){
				$page 			= "admin_fabricant";
				$get_action 	= "view";
				$display_fab 	= getFabricant(0, 0, "ASC");
				
			}else{
				$show_txt_page .= "Une erreur est survenue. Contactez l'administrateur.";
			}		
		}
	break;
	
	case 'delete':
		$delete_fab = delReactiveFab($get_fab_id, "0");
		if($delete_fab){
			$page 			= "admin_fabricant";
			$get_action 	= "view";
			$display_fab 	= getFabricant(0, 0, "ASC");
		}
		
	break;
		
	case 'reactive':
		$reactive_fab = delReactiveFab($get_fab_id, "1");
		if($reactive_fab){
			echo "BONJOUR";
			$page 			= "admin_fabricant";
			$get_action 	= "view";
			$display_fab 	= getFabricant(0, 0, "ASC");
		}
	break;
}


?>