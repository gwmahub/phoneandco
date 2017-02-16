<?php
//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_tools.php');
include_once(PATH_LIBS.'lib_admin_article_categorie.php');
include_once(PATH_LIBS.'lib_admin_article_section.php');
include_once(PATH_LIBS.'lib_admin_article.php');


//VARS
$var_page		= "admin_article";
$display_form	= false;
$img_index		= "";
$no_pic			= "no_pic.jpg";

//GET
$get_art_id		=	ifsetor($_GET["art_id"], "");
$get_art_categ	=	ifsetor($_GET["art_categ"], "");
$get_action		=	ifsetor($_GET['action'], "view");

//POST
$post_lang 				= ifsetor($_POST["lang"],"");
$post_d_publi 			= ifsetor($_POST["d_publi"],"");
$post_d_expi 			= ifsetor($_POST["d_expi"],"");
$post_art_titre 		= ifsetor($_POST["art_titre"],"");
$post_art_categ			= ifsetor($_POST["art_categ"],"");//check insert ds table assoc
$post_art_short_desc	= ifsetor($_POST["art_short_desc"],"");
$post_art_desc 			= ifsetor($_POST["art_desc"],"");
$post_is_visible		= ifsetor($_POST["is_visible"],"");//publié ou non
//var_dump($post_is_visible);
$post_submit 			= ifsetor($_POST["submit"],"");

//$FILES
$file_img_index 		= ifsetor($_FILES["src_fichier"],"");
//var_dump($file_img_index);
$post_img_index_old		= ifsetor($_POST["img_index_old"],"");
//var_dump($post_img_index_old);

//CHECK vars
$is_empty_lg				= "";
$is_empty_d_publi			= "";
$is_empty_d_expi			= "";
$is_empty_titre				= "";
$is_empty_art_categ			= "";
$is_empty_art_short_desc	= "";
$is_empty_art_desc			= "";
$is_empty_is_visible		= "";

$display_error_d_publi 			= "";
$display_error_d_expi 			= "";
$display_error_art_titre 		= "";
$display_error_img_index 		= "";
$display_error_art_categ		= "";
$display_error_art_short_desc 	= "";
$display_error_art_desc 		= "";
$display_error_is_visible 		= "";


switch ($get_action) {
	case 'view':
		$display_articles 	= getArticleList(0, 0, 0, "DESC");
		$page 				= "admin_article";
		$get_action 		= "view";
	break;
	
	case 'detail':
		$display_article 	= getArticleList($get_art_id, $get_art_categ, 0, 0);
		$coteByArt 			= getCotationByArt($get_art_id);
		$commentByArt 		= getCommentsByArt($get_art_id);
		$page 				= "admin_article";
		$get_action 		= "detail";
	break;
	
	case 'add':
		
		$display_art_section 	= getArtSect(0, 0, "ASC");
		$display_cat_by_sec 	= displayCategBySection(0,0);
		$display_art_categ 		= getArtCateg(0,0);
		//var_dump($display_art_categ);
		
		if(!$post_lang || !$post_d_publi || !isGoodDateFR($post_d_publi) || !$post_d_expi || !isGoodDateFR($post_d_expi) 
		|| !$post_art_titre  || !$post_art_categ || !$post_art_short_desc || !$post_art_desc){
			
			$display_form = true;
			
			if($post_submit){
				if(!$post_lang){
					$is_empty_lg = " emptyField";
				}
				if(!$post_d_publi || !isGoodDateFR($post_d_publi)){
					$is_empty_d_publi .= " emptyField";
					$display_error_d_publi .= "Le format de date n'est pas valide. Ex.: 01-01-2013";
				}
				if(!$post_d_expi || !isGoodDateFR($post_d_expi) ){
					$is_empty_d_expi .= " emptyField";
					$display_error_d_expi .= "Le format de date n'est pas valide. Ex.: 01-01-2013";
				}
				if(!$post_art_titre){
					$is_empty_titre .= " emptyField";
					$display_error_art_titre .= "Le titre indiqué n'est pas valide. Ex.: Test : Samsung Galaxy Note 3";
				}
				if(!$post_art_categ){
					$is_empty_art_categ .= " emptyField";
					//test avec alert
					$display_error_art_categ .= "<script>alert('Vous devez de choisir une catégorie pour cet article.');</script>";
				}
				if(!$post_art_short_desc){
					$is_empty_art_short_desc .= " emptyField";
					$display_error_art_short_desc .= "Vous n'avez pas complété la description courte";
				}
				if(!$post_art_desc){
					$is_empty_art_desc .= " emptyField";
					$display_error_art_desc .= "Vous n'avez pas complété la description";
				}
			}
		
			$page = "admin_article";
			$get_action = "add";
			
		}else{
			$post_art_titre			= htmlentities($post_art_titre, ENT_QUOTES, "utf-8");
			$post_art_short_desc 	= htmlentities($post_art_short_desc, ENT_QUOTES, "utf-8");
			$post_art_desc 			= htmlentities($post_art_desc, ENT_QUOTES, "utf-8");
			
			if($post_is_visible != "1"){
				$display_error_is_visible .= "<script>alert('Souhaitez-vous publier l\'article maintenant ?');</script>";
				$post_is_visible = "0";
			}else{
				$post_is_visible = "1";
			}
			
			//MEMO -> check ext img via uploadImg
			if(!empty($file_img_index['name'])){
			$upload = uploadImg($_FILES, "articles/");
			//var_dump($upload);//ok
				if(!$upload){
					$display_error_img_index .= "&rarr;&nbsp; Pas d'image index envoyée.";
				}else{
					$img_index .= $upload['img'];
					//var_dump($img_index);//ok				
				}
			}else{
				$img_index = $no_pic;
			}

			//insertion de l'article dans la table article
			$new_art = insertArticle($post_lang, $img_index, $post_art_titre, $post_art_short_desc, $post_art_desc, $post_is_visible, $post_d_publi, $post_d_expi);
			
			if($new_art){
				//récupération de l'id
				$new_art_id = mysql_insert_id();
				//var_dump($new_art_id);
				
				//insertion dans ARTICLE_CATEG_ASSOC
				$new_art_categ = insertCategByArt($new_art_id, $post_art_categ);
				//insertion ds MEMBRE_ARTICLE
				$art_by_membre = insertAuthorByArt($_SESSION["m_membre_id"], $new_art_id);
			}
			
			//gestion de l'image index de l'article
			
			$img_index_path = "";
			
			$img_index_path .= WWW_UP."articles/".$img_index;
			$check_img_ext = getimagesize($img_index_path);
			//var_dump($check_img_ext);
			
			if($check_img_ext[2] == 1){
				if(!resize_gif($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") || 
					!resize_gif($img_index_path, 80, "thumb_".$img_index, WWW_UP."articles/thumb")){
					$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 2){
				if(!resize_jpg($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") ||
					!resize_jpg($img_index_path, 80, "thumb_".$img_index, WWW_UP."articles/thumb/")){
					$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 3){
				if(!resize_png($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") ||
					!resize_png($img_index_path, 80, "thumb_".$img_index, WWW_UP."articles/thumb/")){
					$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}else{
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'image envoyée n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The image you sent hasn't good format. Please try again !</h3>";
			}
						
					
			$display_form = false;
			
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>";
			
			$page 				= "admin_article";
			$get_action 		= "view";
			$display_articles 	= getArticleList(0,0,0,"DESC");
		}

	break;
		
	case 'update':
	
	//MEMO: modif partie traitmt image +  delpicfile

		if(!$post_lang || !$post_d_publi || !isGoodDateFR($post_d_publi) || !$post_d_expi || !isGoodDateFR($post_d_expi) 
		|| !$post_art_titre  || !$post_art_short_desc || !$post_art_desc){
			if(!$post_submit){
				
				$display_the_article = getArticleList($get_art_id, 0, 0, "DESC");
				//var_dump($display_the_article);
				if(is_array($display_the_article) && !empty($display_the_article)){
					foreach ($display_the_article AS $dta) {
						$art_id 			= $dta["article_id"];
						$art_lang 			= $dta["langue"];
						$art_img_index 		= $dta["img_index"];
						$art_titre 			= $dta["article_titre"];
						$art_short_desc 	= $dta["courte_description"];
						$art_desc 			= $dta["description"];
						$art_visible 		= $dta["is_visible"];
						$art_d_publi 		= dateUs2Fr($dta["date_debut"]);
						$art_d_expi 		= dateUs2Fr($dta["date_debut"]);
						$art_d_crea 		= dateUs2Fr($dta["date_add"]);
					}
				}
				
				//si submit
			}else{
				
				if(!$post_lang){
					$is_empty_lg .= " emptyField";
				}
				if(!$post_d_publi || !isGoodDateFR($post_d_publi)){
					$is_empty_d_publi .= " emptyField";
					$display_error_d_publi .= "Le format de date n'est pas valide. Ex.: 01-01-2013";
				}
				if(!$post_d_expi || !isGoodDateFR($post_d_expi)){
					$is_empty_d_expi .= " emptyField";
					$display_error_d_expi .= "Le format de date n'est pas valide. Ex.: 01-01-2013";
				}
				if(!$post_art_titre){
					$is_empty_titre .= " emptyField";
					$display_error_art_titre .= "Le titre indiqué n'est pas valide. Ex.: Test : Samsung Galaxy Note 3";
				}

				if(!$post_art_short_desc){
					$is_empty_art_short_desc .= " emptyField";
					$display_error_art_short_desc .= "Vous n'avez pas complété la description courte.";
				}
				if(!$post_art_desc){
					$is_empty_art_desc .= " emptyField";
					$display_error_art_desc .= "&rarr;&nbsp; La description ne peut être vide.";
				}
			}

				$display_form 	= true;
				$page 			= "admin_article";
				$get_action 	= "update";

		//si ts les champs obli sont ok
		}else{
			
			$post_art_titre			= htmlentities($post_art_titre, ENT_QUOTES, "utf-8");
			$post_art_short_desc 	= htmlentities($post_art_short_desc, ENT_QUOTES, "utf-8");
			$post_art_desc 			= htmlentities($post_art_desc, ENT_QUOTES, "utf-8");
						
			if(!$post_is_visible){
				$display_error_is_visible .= "<script>alert('Pas publier ??');</script>";
				$post_is_visible = "0";
			}else{
				$post_is_visible = "1";
			}
			
			//update de l'image dans la table article
		$size_img_tmp[2] = "";
		if(!empty($file_img_index['name'])){
			$size_img_tmp = getimagesize($file_img_index['tmp_name']);
		}

		
		
			if(!empty($file_img_index['name']) && $size_img_tmp[2] < 4){
				$upload = uploadImg($_FILES, "articles/");
				//var_dump($upload);//ok
					if(!$upload){
						$display_error_img_index .= "&rarr;&nbsp; Pas d'image index envoyée.";
					}else{
						$img_index .= $upload['img'];
						//var_dump($img_index);
					}
				}else{
					if(empty($file_img_index['name'])){
						$show_txt_page .= "<p>Pas de nouvel image envoyée.</p>";
					}
					if($size_img_tmp[2] > 3){
						$show_txt_page .= "<p>L'image envoyée n'est pas un jpg, gif ou png</p>";
					}
					if($post_img_index_old){
						$img_index .= $post_img_index_old;
					}else{
						$img_index .= $no_pic;
					}

				}
						
				if($upd_art = updateArticle($get_art_id, $post_lang, $img_index, $post_art_titre, $post_art_short_desc, $post_art_desc, $post_is_visible, $post_d_publi, $post_d_expi)){
						//si l'upload de la nouvelle image s'est bien déroulé -> gestion de l'image
						$img_index_path = "";
						
						$img_index_path .= WWW_UP."articles/".$img_index;
						//var_dump($img_index_path);
						$check_img_ext = getimagesize($img_index_path);
						//var_dump($check_img_ext);
						
						if($check_img_ext[2] == 1){
							if(!resize_gif($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") || 
								!resize_gif($img_index_path, 60, "thumb_".$img_index, WWW_UP."articles/thumb")){
								$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
							}
						}elseif($check_img_ext[2] == 2){
							if(!resize_jpg($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") ||
								!resize_jpg($img_index_path, 60, "thumb_".$img_index, WWW_UP."articles/thumb/")){
								$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
							}
						}elseif($check_img_ext[2] == 3){
							if(!resize_png($img_index_path, 450, "resized_".$img_index, WWW_UP."articles/resized/") ||
								!resize_png($img_index_path, 60, "thumb_".$img_index, WWW_UP."articles/thumb/")){
								$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
							}
						}else{
							$show_txt_page .= ($get_lang=="fr")?"<h3>L'image envoyée n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The image you sent hasn't good format. Please try again !</h3>";
						}
						
						if($post_img_index_old != $no_pic && $post_img_index_old != $post_img_index_old){
							$del_img_index_old 	= delPicFile($post_img_index_old, "articles/");
							echo "<p>Ancienne image supprimée avec sucès</p>";
							$del_img_resized 	= delPicFile("resized_".$post_img_index_old,"articles/resized/");
							$del_img_thumb 		= delPicFile("thumb_".$post_img_index_old, "articles/thumb/");
							$show_txt_page 		.= "<p>Ancienne image correctement effacée.</p>";
						}
						
					
					}
					
				$display_form 		= false;
				$display_articles 	= getArticleList(0,0,0,"DESC");
				$page 				= "admin_article";
				$get_action 		= "view";
				
			}//END else check champs oblis

	break;
		
	case 'delete':
		$delete_article = delReactiveArticle($get_art_id, 0);
		if($delete_article){
			$page 				= "admin_article";
			$get_action 		= "view";
			$display_articles 	= getArticleList(0, 0, 0, "DESC");
		}
		
	break;
	
	case 'reactive':
		$reactive_article = delReactiveArticle($get_art_id, 1);
		if($reactive_article){
			$page 				= "admin_article";
			$get_action 		= "view";
			$display_articles 	= getArticleList(0, 0, 0, "DESC");
		}
		
	break;
}
?>