<?php

//require(PATH_LIBS.'lib_fpdf/fpdf.php');
//includes
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_tools.php');
include_once(PATH_LIBS.'lib_admin_appareil_categ.php');
include_once(PATH_LIBS.'lib_admin_fabricant.php');
include_once(PATH_LIBS.'lib_admin_appareil.php');


//VARS
$var_page		= "admin_appareil";
$img_index		= "";
$no_pic			= "no_pic.jpg";
$checked 		= "";// checked='checked'
$selected 		= "";// selected='selected'

// Voir comment récupérer le lien après génération du PDF
$ap_fiche_tech_fr 	= "";
$ap_fiche_tech_en 	= "";

//$post_ap_fiche_tech_fr		= ifsetor($_POST["ap_fiche_tech_fr"],"");
//$post_ap_fiche_tech_en		= ifsetor($_POST["ap_fiche_tech_en"],"");


//GET
$get_action				=	ifsetor($_GET['action'], "view");
//ENGINE and ...
$get_ap_id				=	ifsetor($_GET["ap_id"], "");//case update slmt

//ENGINE -> récup de la catégorie d'appareil
$get_ap_categ_id		=	ifsetor($_GET["ap_categ_id"], "");
//ENGINE -> récup du fabricant
$get_ap_fab_id			=	ifsetor($_GET["ap_fab_id"], "");


//ENGINE -> menu group by
$get_group_by_categ		=	ifsetor($_GET["groupByCateg"], "");
$get_group_by_fab		=	ifsetor($_GET["groupByFab"], "");
$get_group_by_ap		=	ifsetor($_GET["groupByAp"], "");

//POST
//récupération id fabricant -> table pac_appareil_fab_assoc
$post_ap_fab				= ifsetor($_POST["ap_fab"], "");
//récupération ids categ -> table pac_appareil_categ_assoc
$post_ap_categ				= ifsetor($_POST["ap_categ"], "");// !! array
//var_dump($post_ap_categ);

$post_ap_titre_fr 			= ifsetor($_POST["ap_titre_fr"],"");
$post_ap_titre_en			= ifsetor($_POST["ap_titre_en"],"");//check insert ds table assoc
$post_ap_courte_desc_fr		= ifsetor($_POST["ap_courte_desc_fr"],"");
$post_ap_courte_desc_en		= ifsetor($_POST["ap_courte_desc_en"],"");
$post_ap_desc_fr			= ifsetor($_POST["ap_desc_fr"],"");
$post_ap_desc_en			= ifsetor($_POST["ap_desc_en"],"");

$post_is_visible			= ifsetor($_POST["is_visible"],"");//publié ou non
//ENGINE
$post_field					= ifsetor($_POST["apField"], "");
$post_user_data				= ifsetor($_POST["user_data"], "");
//END ENGINE

//FILES
$file_img_index 			= ifsetor($_FILES["src_fichier"],"");
//var_dump($file_img_index);
//affiche
/*
 * array
  'name' => string 'HTC-One-mini---silver---Smartphone.jpg' (length=38)
  'type' => string 'image/jpeg' (length=10)
  'tmp_name' => string 'C:\wamp\tmp\php9BAC.tmp' (length=23)
  'error' => int 0
  'size' => int 36237
 * */
$post_img_index_old			= ifsetor($_POST["img_index_old"],"");

$post_submit 				= ifsetor($_POST["submit"],"");


//CHECK vars
$is_empty_ap_categ				= "";
$is_empty_ap_fab				= "";

$is_empty_ap_titre_fr			= "";
$is_empty_ap_titre_en			= "";
$is_empty_img_index				= "";
$is_empty_ap_short_desc_fr		= "";
$is_empty_ap_short_desc_en		= "";
$is_empty_ap_desc_fr			= "";
$is_empty_ap_desc_en			= "";
$is_empty_ap_ft_fr				= ""; //??
$is_empty_ap_ft_en				= ""; //??
$is_empty_is_visible			= "";


$display_error_ap_categ				= "";
$display_error_ap_fab				= "";

$display_error_ap_titre_fr 			= "";
$display_error_ap_titre_en 			= "";
$display_error_img_index 			= "";
$display_error_ap_short_desc_fr 	= "";
$display_error_ap_short_desc_en 	= "";
$display_error_ap_desc_fr			= "";
$display_error_ap_desc_en			= "";
$display_error_is_visible 			= "";//publication ?


// Affichage 'publique' des champs de la table créée
$display_field_in_select = array(
	"ap_titre_fr"		=> "Dénomination fr",
	"ap_titre_en" 		=> "Dénomination en",
	"ap_courte_desc_fr" => "Courte description FR",
	"ap_courte_desc_en" => "Courte description EN",
	"ap_desc_fr" 		=> "Description FR",
	"ap_desc_en" 		=> "Description EN",	
	"ap_categ_fr" 		=> "Catégorie fr",
	"ap_categ_en" 		=> "Catégorie en",
	"fabricant"			=> "Fabricant"
);

switch ($get_action) {
	case 'view':
		$display_ap_list = getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
		//var_dump($display_ap_list);//ok
		
		$display_ap_categ 	= getApCateg(0,"1");
		//var_dump($display_ap_categ);//ok
		$display_ap_fab	 	= getFabricant(0,1,"ASC");
		//var_dump($display_ap_fab);//ok

		$page 			= "admin_appareil";
		$get_action 	= "view";

	break;
	
	case 'detail':// à compléter
		$display_the_ap = getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
	break;

	case 'add':
		//fonctions nécessaires à l'affichage ici
		
		$display_ap_categ 	= getApCateg(0,"1");
		//var_dump($display_ap_categ);//ok
		$display_ap_fab	 	= getFabricant(0,1,"ASC");
		//var_dump($display_ap_fab);//ok
		
		if(!$post_ap_categ || !$post_ap_fab || !$post_ap_titre_fr || !$post_ap_titre_en || !$post_ap_courte_desc_fr 
			|| !$post_ap_courte_desc_en || !$post_ap_desc_fr || !$post_ap_desc_en){
						
			if($post_submit){

				if(!$post_ap_categ){
					$is_empty_ap_fab 		.= " emptyField";
					$display_error_ap_fab 	.= "Vous devez sélectionner une catégorie.";
				}
				if(!$post_ap_fab){
					$is_empty_ap_fab 		.= " emptyField";
					$display_error_ap_fab 	.= "Vous devez sélectionner un fabricant.";
				}				
				if(!$post_ap_titre_fr){
					$is_empty_ap_titre_fr 		.= " emptyField";
					$display_error_ap_titre_fr 	.= "Le titre FR indiqué n'est pas valide. "; 
				}
				if(!$post_ap_titre_en){
					$is_empty_ap_titre_en 		.= " emptyField";
					$display_error_ap_titre_en 	.= "Le titre EN indiqué n'est pas valide."; 
				}
				
				if(!$post_ap_courte_desc_fr){
					$is_empty_ap_short_desc_fr 			.= " emptyField";
					$display_error_ap_short_desc_fr 	.= "La courte description FR indiquée n'est pas valide."; 
				}
				if(!$post_ap_courte_desc_en){
					$is_empty_ap_short_desc_en 			.= " emptyField";
					$display_error_ap_short_desc_en 	.= "La courte description EN indiquée n'est pas valide."; 
				}
				
				if(!$post_ap_desc_fr){
					$is_empty_ap_desc_fr 		.= " emptyField";
					$display_error_ap_desc_fr 	.= "La description FR indiquée n'est pas valide."; 
				}
				
				if(!$post_ap_desc_en){
					$is_empty_ap_desc_en 		.= " emptyField";
					$display_error_ap_desc_en 	.= "La description EN indiquée n'est pas valide."; 
				}
			}
		
			$page 			= "admin_appareil";
			$get_action 	= "add";
			
			//si tous les champs obli sont ok
		}else{
			$post_ap_titre_fr			= htmlentities($post_ap_titre_fr,ENT_QUOTES, "utf-8");
			$post_ap_titre_en 			= htmlentities($post_ap_titre_en,ENT_QUOTES, "utf-8");
			
			$post_ap_courte_desc_fr		= htmlentities($post_ap_courte_desc_fr,ENT_QUOTES, "utf-8");
			$post_ap_courte_desc_en		= htmlentities($post_ap_courte_desc_en,ENT_QUOTES, "utf-8");
			$post_ap_desc_fr			= htmlentities($post_ap_desc_fr,ENT_QUOTES, "utf-8");
			$post_ap_desc_en			= htmlentities($post_ap_desc_en,ENT_QUOTES, "utf-8");


			//MEMO -> check ext img via uploadImg
			
			if(!empty($file_img_index['name'])){
			$upload = uploadImg($_FILES, "appareils/");
			//var_dump($upload);//
				if(!$upload){
					$show_txt_page .= "&rarr;&nbsp; Pas d'image index uploadée.";
				}else{
					$img_index .= $upload['img'];
					
					//gestion de l'image index de l'article
					
					$img_index_path = "";
					
					$img_index_path .= WWW_UP."appareils/".$img_index;
					$check_img_ext = getimagesize($img_index_path);
					//var_dump($check_img_ext);
					
					if($check_img_ext[2] == 1){
						if(!resize_gif($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") || 
							!resize_gif($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb")){
							$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
						}
					}elseif($check_img_ext[2] == 2){
						if(!resize_jpg($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") ||
							!resize_jpg($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb/")){
							$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
						}
					}elseif($check_img_ext[2] == 3){
						if(!resize_png($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") ||
							!resize_png($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb/")){
							$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
						}
					}else{
						$show_txt_page .= ($get_lang=="fr")?"<h3>L'image envoyée n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The image you sent hasn't good format. Please try again !</h3>";
					}
					
										
				}
			}else{
				$img_index = $no_pic;
			}
					
									
//------------------------------------------------
//--------------------------------------------------					
//création des pdf ici
//---------------------
	require(PATH_LIBS.'pdf/html2pdf.class.php');
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			$html2pdf->setDefaultFont('Arial');
			$content='<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
							<page_header>
								<table style="width: 100%; border: dashed 1px lightblue;">
									<tr>
										<td style="text-align: left; width: 33%;">Phone And Co</td>
										<td style="text-align: center;    width: 34%"></td>
										<td style="text-align: right;    width: 33%">Phone And Co</td>
									</tr>
								</table>
							</page_header>
							<page_footer>
								<table style="width: 100%; border: dashed 1px lightblue;">
									<tr>
										<td style="text-align: left;    width: 33%">Phone And Co</td>
										<td style="text-align: center;    width: 34%"></td>
										<td style="text-align: right;    width: 33%"></td>
									</tr>
								</table>
							</page_footer>
								<div style="text-align: justify; width: 500px;">
									<p style="font-size: 20px; font-weight: bold">'.$post_ap_titre_fr.'</p>
									<br>
									<img src="'.WWW_UP.'appareils/resized/resized_'.$img_index.'" alt="'.$post_ap_titre_en.'" />
									'.htmlspecialchars_decode($post_ap_desc_fr,ENT_QUOTES).'
								</div>
							</page>';
			$html2pdf->writeHTML($content);
			$html2pdf->Output('upload/appareils/ft_pdf/'.date("ymdhis").$post_ap_titre_fr.'_fr.pdf', 'F');
//---------------------
//---------------------
	//require(PATH_LIBS.'pdf/html2pdf.class.php');
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			$html2pdf->setDefaultFont('Arial');
			$content='<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
							<page_header>
								<table style="width: 100%; border: dashed 1px lightblue;">
									<tr>
										<td style="text-align: left;  width: 33%;">
											Phone And Co
										</td>
										<td style="text-align: center;    width: 34%"></td>
										<td style="text-align: right;    width: 33%">Phone And Co</td>
									</tr>
								</table>
							</page_header>
							<page_footer>
								<table style="width: 100%; border: dashed 1px lightblue;;">
									<tr>
										<td style="text-align: left;    width: 33%">Phone and Co</td>
										<td style="text-align: center;    width: 34%"></td>
										<td style="text-align: right;    width: 33%"></td>
									</tr>
								</table>
							</page_footer>
							<div style="text-align: justify; width: 500px;">
								<p style="font-size: 20px; font-weight: bold">'.$post_ap_titre_en.'</p>
								<br>
								<img src="'.WWW_UP.'appareils/resized/resized_'.$img_index.'" alt="'.$post_ap_titre_en.'" />
								'.htmlspecialchars_decode($post_ap_desc_en,ENT_QUOTES).'
							</div>
							</page>';
			$html2pdf->writeHTML($content);
			$html2pdf->Output('upload/appareils/ft_pdf/'.date("ymdhis").$post_ap_titre_en.'_en.pdf', 'F');
//---------------------					

			//récupération des 2 noms de fichiers
			$ap_fiche_tech_fr .= date("ymdhis").$post_ap_titre_fr."_fr.pdf";
			$ap_fiche_tech_en .= date("ymdhis").$post_ap_titre_en."_en.pdf";
			
			//insertion de l'article dans la table article

			$new_ap = insertAp($img_index, $post_ap_titre_fr, $post_ap_titre_en, $post_ap_courte_desc_fr, $post_ap_courte_desc_en, $post_ap_desc_fr, $post_ap_desc_en, $ap_fiche_tech_fr, $ap_fiche_tech_en, $post_is_visible);
			
			if($new_ap){
				//récupération de l'id
				$new_ap_id = mysqli_insert_id($connexion);
				//var_dump($new_ap_id);
				
				//insertion dans APPAREIL_CATEG_ASSOC
				$new_ap_categ	= insertCategByAp($new_ap_id, $post_ap_categ);
				//insertion ds MEMBRE_ARTICLE
				$new_ap_fab 	= insertFabByAp($new_ap_id, $post_ap_fab);
			}
				
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>";
			
			
			$page 				= "admin_appareil";
			$get_action 		= "view";
			
			$display_ap_list 		= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
			$display_ap_categ 		= getApCateg(0,"1");
			$display_ap_fab	 		= getFabricant(0,1,"ASC");
		}

	break;
		
	case 'update':
	
		$display_ap_list 		= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
		$display_ap_categ 		= getApCateg(0,"1");
		$display_categ_by_ap 	= getCategsByAp($get_ap_id);
		$display_fab_by_ap		= getFabByAp($get_ap_id);
		
		$display_ap_fab	 		= getFabricant(0,1,"ASC");
		
		if(!$post_ap_categ || !$post_ap_fab || !$post_ap_titre_fr || !$post_ap_titre_en || !$post_ap_courte_desc_fr 
			|| !$post_ap_courte_desc_en || !$post_ap_desc_fr || !$post_ap_desc_en){
				
			if(!$post_submit){
				$display_ap_list 		= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, 0);
				//si submit mais champs problématiques
			}else{
				
				$post_ap_fab_id		= $_POST["ap_fab"];//ok
				$img_index			= $post_img_index_old;//ok
				
				if(!$post_ap_categ){
					$is_empty_ap_fab 		.= " emptyField";
					$display_error_ap_fab 	.= "Vous devez sélectionner une catégorie.";
				}
				if(!$post_ap_fab){
					$is_empty_ap_fab 		.= " emptyField";
					$display_error_ap_fab 	.= "Vous devez sélectionner un fabricant.";
				}				
				if(!$post_ap_titre_fr){
					$is_empty_ap_titre_fr 		.= " emptyField";
					$display_error_ap_titre_fr 	.= "Le titre FR indiqué n'est pas valide. "; 
				}
				if(!$post_ap_titre_en){
					$is_empty_ap_titre_en 		.= " emptyField";
					$display_error_ap_titre_en 	.= "Le titre EN indiqué n'est pas valide."; 
				}
				
				if(!$post_ap_courte_desc_fr){
					$is_empty_ap_short_desc_fr 			.= " emptyField";
					$display_error_ap_short_desc_fr 	.= "La courte description FR indiquée n'est pas valide."; 
				}
				if(!$post_ap_courte_desc_en){
					$is_empty_ap_short_desc_en 			.= " emptyField";
					$display_error_ap_short_desc_en 	.= "La courte description EN indiquée n'est pas valide."; 
				}
				
				if(!$post_ap_desc_fr){
					$is_empty_ap_desc_fr 		.= " emptyField";
					$display_error_ap_desc_fr 	.= "La description FR indiquée n'est pas valide."; 
				}
				
				if(!$post_ap_desc_en){
					$is_empty_ap_desc_en 		.= " emptyField";
					$display_error_ap_desc_en 	.= "La description EN indiquée n'est pas valide."; 
				}
			}

			$page 				= "admin_appareil";
			$get_action 		= "update";


		//si ts les champs obli sont ok
		}else{
			
			$post_ap_titre_fr			= htmlentities($post_ap_titre_fr,ENT_QUOTES, "utf-8");
			$post_ap_titre_en 			= htmlentities($post_ap_titre_en,ENT_QUOTES, "utf-8");
			
			$post_ap_courte_desc_fr		= htmlentities($post_ap_courte_desc_fr,ENT_QUOTES, "utf-8");
			$post_ap_courte_desc_en		= htmlentities($post_ap_courte_desc_en,ENT_QUOTES, "utf-8");
			$post_ap_desc_fr			= htmlentities($post_ap_desc_fr,ENT_QUOTES, "utf-8");
			$post_ap_desc_en			= htmlentities($post_ap_desc_en,ENT_QUOTES, "utf-8");



		//si une nouvelle image est envoyée
		$size_img_tmp[2] = "";
		if(!empty($file_img_index['name'])){
			$size_img_tmp = getimagesize($file_img_index['tmp_name']);
		}
		if(!empty($file_img_index['name']) && $size_img_tmp[2] < 4){
				
			$upload = uploadImg($_FILES, "appareils/");
			//var_dump($upload);
				if(!$upload){
					$show_txt_page .= "&rarr;&nbsp; Pas d'image index uploadée.";
				}else{
					$img_index .= $upload['img'];
					//var_dump($img_index);//		
				}
				
				//si une nouvelle image est envoyée -> gestion de l'image
				$img_index_path = "";
			
				$img_index_path 	.= WWW_UP."appareils/".$img_index;
				$check_img_ext 		= getimagesize($img_index_path);
				//var_dump($check_img_ext);
				
				if($check_img_ext[2] == 1){
					if(!resize_gif($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") || 
						!resize_gif($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb")){
						$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
					}
				}elseif($check_img_ext[2] == 2){
					if(!resize_jpg($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") ||
						!resize_jpg($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb/")){
						$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
					}
				}elseif($check_img_ext[2] == 3){
					if(!resize_png($img_index_path, 450, "resized_".$img_index, WWW_UP."appareils/resized/") ||
						!resize_png($img_index_path, 80, "thumb_".$img_index, WWW_UP."appareils/thumb/")){
						$display_error_img_index.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
					}
				}else{
					$show_txt_page .= ($get_lang=="fr")?"<h3>L'image envoyée n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The image you sent hasn't good format. Please try again !</h3>";
				}
				//Suppression de l'ancienne image
				if($del_img_index_old 	= delPicFile($post_img_index_old, "appareil/")){
					$del_img_resized 	= delPicFile("resized_".$post_img_index_old,"appareil/resized/");
					$del_img_thumb 		= delPicFile("thumb_".$post_img_index_old, "appareil/thumb/");
					$show_txt_page 		.= "<p>Ancienne image correctement effacée.</p>";
				}else{
					echo "<p>Echec de la suppression de l'ancienne image.</p>";
				}
				
			// si aucune nouvelle image n'est envoyée ou pas jpg - gif - png
			}else{
				
				if(empty($file_img_index['name'])){
					$show_txt_page .= "<p>Pas de nouvelle image envoyée.</p>";
				}
				if($size_img_tmp[2] > 3){
					$show_txt_page .= "<p>L'image envoyée n'est pas un jpg, gif ou png</p>";
				}
				if($post_img_index_old){
					$img_index .= $post_img_index_old;//sol 2 : $avatar = $post_old_avat
				}else{
					$img_index .= $no_pic;
				}					

				//$img_index .= $post_img_index_old;
			}
			
			$upd_ap = updateAp($get_ap_id, $img_index, $post_ap_titre_fr, $post_ap_titre_en, $post_ap_courte_desc_fr, $post_ap_courte_desc_en, $post_ap_desc_fr, $post_ap_desc_en, $ap_fiche_tech_fr, $ap_fiche_tech_en, $post_is_visible);
			
			if($upd_ap){
				//si l'update s'est bien déroulé ->
				//suppression des anciennes asociations categ
				$del_old_ap_categ = delOldCategByAp($get_ap_id);
				//insertion des nouvelles associations dans APPAREIL_CATEG_ASSOC
				$new_ap_categ = insertCategByAp($get_ap_id, $post_ap_categ);
				//suppression de l'ancienne association fab
				$del_old_ap_fab = delOldFabByAp($get_ap_id);
				//insertion dunouveau fournisseur
				$new_ap_fab = insertFabByAp($get_ap_id, $post_ap_fab);
			}
									
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>";
			
			$page 				= "admin_appareil";
			$get_action 		= "view";
			
			$display_ap_list 		= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, 0, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
			var_dump($get_ap_id);
			$display_ap_categ 		= getApCateg(0,"1");
			$display_ap_fab	 		= getFabricant(0,1,"ASC");
		}

	break;
		
	case 'delete'://ok
		$delete_ap 				= delReactiveAp($get_ap_id, 0);
		if($delete_ap){
			$page 				= "admin_appareil";
			$get_action 		= "view";
			$display_ap_list 	= getApList(0, 0, 0, 0, 0, 0, 0, 0, 0, "DESC");
			$display_ap_categ 	= getApCateg(0,"1");
			$display_ap_fab	 	= getFabricant(0,1,"ASC");
		}
		
	break;
	
	case 'reactive'://ok
		$reactive_ap 			= delReactiveAp($get_ap_id, 1);
		if($reactive_ap){
			$page 				= "admin_appareil";
			$get_action 		= "view";
			$display_ap_list 	= getApList(0, 0, 0, 0, 0, 0, 0, 0, 0, "DESC");
			$display_ap_categ 	= getApCateg(0,"1");
			$display_ap_fab	 	= getFabricant(0,1,"ASC");
		}
		
	break;
}
?>