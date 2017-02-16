<?php
//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_admin_slides.php');
include_once(PATH_LIBS."lib_tools.php");

//VARS
$var_page 	= "admin_slides";
$slide 		= "";
$no_slide 	= "no_slide.jpg";

//GET
$get_slide_id		= ifsetor($_GET["slide_id"], "");
$get_action			= ifsetor($_GET["action"], "");

//POST
$post_txt_fr		= ifsetor($_POST["txt_fr"],"");
$post_txt_en		= ifsetor($_POST["txt_en"],"");
$post_is_visible 	= ifsetor($_POST["is_visible"], "");
$post_submit		= ifsetor($_POST["submit"],"");
//case update
$post_old_slide 	= ifsetor($_POST["old_slide"], "");

//FILES
$file_slide 		= ifsetor($_FILES["src_fichier"],"no_slide.jpg");
//var_dump($file_slide);//ok

//CHECK
$is_empty_txt_fr 		= "";
$is_empty_txt_en 		= "";
$is_empty_slide_img		= "";

$display_error_txt_fr  		= "";
$display_error_txt_en  		= "";
$display_error_slide_img  	= "";



switch ($get_action) {
	case 'view':
		$display_slides = getSlides(0, "DESC" , 0, 0);
		//var_dump($display_slides);
		$page 		= "admin_slides";
		$get_action = "view";
	break;
	
	case 'add':
		if(!$post_txt_fr || !$post_txt_en || empty($file_slide["name"])){
			if($post_submit){
				if(!$post_txt_fr){
					$is_empty_txt_fr 		.= " emptyField";
					$display_error_txt_fr  	.= "Le texte indiqué n'est pas valide ou le champs est vide";
				}
				if(!$post_txt_en){
					$is_empty_txt_fr 		.= " emptyField";
					$display_error_txt_en  	.= "Le texte indiqué n'est pas valide ou le champs est vide";
				}
				if(empty($file_slide["name"])){
					$is_empty_slide_img 		.= " emptyField";
					$display_error_slide_img  	.= "Vous devez choisir une image. !! Dimensions: width: 1000px; height: 300px;";
				}

			}
			$page = "admin_slides";
			$get_action = "add";
			
		}else{
			$post_txt_fr = htmlentities($post_txt_fr);
			$post_txt_en = htmlentities($post_txt_en);

			if(!empty($file_slide['name'])){
				$upload = uploadImg($_FILES, "slides/");
					if(!$upload){
						$display_error_slide_img .= "Problème : Votre slide n'a pas été uploadé.";
					}else{
						$slide .= $upload['img'];
					}
				}else{
					$slide .= $no_slide;
				}

						
			$new_slide = insertSlide($slide, $post_txt_fr, $post_txt_en, $post_is_visible);
			
			if($new_slide){

				$slide_path = "";
				
				$slide_path .= WWW_UP."slides/".$slide;
				$check_img_ext = getimagesize($slide_path);
				
				if($check_img_ext[2] == 1){
					if(!resize_gif($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
						$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}elseif($check_img_ext[2] == 2){
					if(!resize_jpg($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
						$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}elseif($check_img_ext[2] == 3){
					if(!resize_png($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
						$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
					}
					
				}else{
					$show_txt_page .= "<h3>Le slide envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>";
				}
			
			}
			$display_slides = getSlides(0, "DESC" , 0, 0);
			$page 			= "admin_slides";
			$get_action 	= "view";
		}

	break;
	
	case 'update':
		$display_slides = getSlides($get_slide_id, 0 , 0, 0);
		//si un des champs obli est vide...
		//MEMO ici pas d'input file obli car un slide existe déjà
		if(!$post_txt_fr || !$post_txt_en){
			
			if(!$post_submit){
				
				if(is_array($display_slides) && !empty($display_slides)){
					foreach($display_slides AS $ds){
						$slide_id		= $ds["slide_id"];
						$slide_img  	= $ds["slide_img"];
						$slide_txt_fr	= html_entity_decode($ds["slide_txt_fr"], ENT_QUOTES, "UTF-8");
						$slide_txt_en	= html_entity_decode($ds["slide_txt_en"],ENT_QUOTES, "UTF-8");	
						$is_visible		= $ds["is_visible"];
						$date_add		= dateUs2Fr($ds["date_add"]);
					}
				}
			
			}else{
				if(!$post_txt_fr){
					$is_empty_txt_fr 		.= " emptyField";
					$display_error_txt_fr  	.= "Le texte indiqué n'est pas valide";
				}
				if(!$post_txt_en){
					$is_empty_txt_fr 		.= " emptyField";
					$display_error_txt_en  	.= "Le texte indiqué n'est pas valide";
				}
			}
			
			$page 		= "admin_slides";
			$get_action = "update";
			
		}else{

			//si un slide est envoyé et qu'il est différent de l'ancien et jpg - gif - png...
			$size_img_tmp[2] = "";
			
			if(!empty($file_slide['name'])){
				$size_img_tmp = getimagesize($file_slide['tmp_name']);
			}
			if(!empty($file_slide["name"]) && ($file_slide["name"] != $post_old_slide) && $size_img_tmp[2] < 4){
					
				//upload du nouveau slide	
				$upload = uploadImg($_FILES, "slides/");
					if(!$upload){
						$display_error_slide_img .= "Problème : Votre slide n'a pas été uploadé.";
					}else{
								
						//var_dump($upload);	

						//si l'upload s'est bien déroulé...
						$slide .= $upload['img'];
						
						$slide_path = "";
						
						//définition du lien
						$slide_path .= WWW_UP."slides/".$slide;
						//var_dump($slide_path);//ok
						$check_img_ext = getimagesize($slide_path);
						//resizing pour le thumb
						if($check_img_ext[2] == 1){
							if(!resize_gif($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
								$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}elseif($check_img_ext[2] == 2){
							if(!resize_jpg($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
								$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}elseif($check_img_ext[2] == 3){
							if(!resize_png($slide_path, 200, "thumb_".$slide, WWW_UP."slides/slides_thumb/")){
								$display_error_slide_img .= "Une erreur est survenue. Contactez l'administrateur";
							}
							
						}else{
							$show_txt_page .= "<h3>Le slide envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>";
						}
						
						//suppression de l'ancien slide et du thumb
						if($del_old_slide = delPicFile($post_old_slide,"slides/")){
							//echo "<p>Fichier supprimé avec succès</p>";//ok
							$del_old_slide_thumb  	= delPicFile($post_old_slide, "slides/slides_thumb/thumb_");//ok
							
						}else{
							//echo "<p>Echec de la suppresion des fichiers</p>";
						}
					}
				//si pas de nouveau slide alors ou slide pas jpg - gif - png ...	
				}else{
					
					if(empty($file_slide['name'])){
						$show_txt_page .= "<p>Pas de nouveau slide envoyé.</p>";
					}
					if($size_img_tmp[2] > 3){
						$show_txt_page .= "<p>Le slide envoyé n'est pas un jpg, gif ou png</p>";
					}
					if($post_old_slide){
						$slide .= $post_old_slide;
					}else{
						$slide .= $no_slide;
					}					
				}
			
			//update des données
			$upd_slide = updateSlide($get_slide_id, $slide, $post_txt_fr, $post_txt_en);
			
			if($upd_slide){
				$page 				= "admin_slides";
				$get_action 		= "view";
				$display_slides 	= getSlides(0, "DESC", 0, 0);
				
			}else{
				$show_txt_page .= "Une erreur est survenue. Contactez l'administrateur.";
			}		
		}
	break;
	
	case 'delete':
		$delete_slide = delReactiveSlide($get_slide_id, "0");
		if($delete_slide){
			$page 			= "admin_slides";
			$get_action 	= "view";
			$display_slides = getSlides(0, "DESC", 0, 0);
		}
		
	break;
		
	case 'reactive':
		$reactive_slide = delReactiveSlide($get_slide_id, "1");
		if($reactive_slide){
			$page 			= "admin_slides";
			$get_action 	= "view";
			$display_slides = getSlides(0, "DESC", 0, 0);
		}
	break;
}












?>