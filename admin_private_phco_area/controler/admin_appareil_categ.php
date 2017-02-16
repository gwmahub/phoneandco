<?php

//MEMO les filtres 'fabricant' et 'catégorie' (type d'appareil) sont au même niveau -> différent des sections d'articles qui contiennent des catégories

//includes
include_once(PATH_BASE.'protect_admin.php');
//include_once(PATH_LIBS.'lib_admin_fabricant.php');
include_once(PATH_LIBS.'lib_admin_appareil_categ.php');
include_once(PATH_LIBS.'lib_tools.php');

//vars
$var_page		=	"admin_appareil_categ";
$display_form	=	false;

//get
$get_categ_id	=	ifsetor($_GET["categ_id"], "");
$get_action		=	ifsetor($_GET['action'], "view");

//post
$post_categ_fr	= 	ifsetor($_POST['ap_categ_fr'], "");
$post_categ_en	= 	ifsetor($_POST['ap_categ_en'], "");
$post_submit	= 	ifsetor($_POST['submit'],"");
//var_dump($post_submit);

$is_empty_categ_fr 	= "";
$is_empty_categ_en 	= "";

//$msg_error_cat_fab 	= "";
$display_error_categ_fr 	= "";
$display_error_categ_en 	= "";

/*if(isset($get_categ_id) && !is_numeric($get_categ_id)){
	header("location:?p=admin_appareil_categ");
	exit;
}*/

switch ($get_action) {
	case 'view': //ok
		$display_ap_categ = getApCateg(0, 0);
		//var_dump($display_ap_categ);
		$page = "admin_appareil_categ";
		break;
		
	case 'add': //ok
		//affichage des fabricants existantes
		if(!$post_categ_fr || !is_txt($post_categ_fr) || !$post_categ_en || !is_txt($post_categ_en)){
			if($post_submit){
				
				if(!$post_categ_fr || !is_txt($post_categ_fr)){
					$is_empty_categ_fr 		.= " emptyField";
					$display_error_categ_fr .= "Le texte indiqué est incorrect ou le champ est vide";
				}
				if(!$post_categ_en || !is_txt($post_categ_en)){
					$is_empty_categ_en 		.= " emptyField";
					$display_error_categ_en .= "Le texte indiqué est incorrect ou le champ est vide";
				}

			}
			$display_form 	= true;
			$page 			= "admin_appareil_categ";
			$get_action 	= "add";
			
		}else{
			
			$new_ap_categ = insertApCateg($post_categ_fr, $post_categ_en);
			if($new_ap_categ){
				$page 				= "admin_appareil_categ";
				$get_action 		= "view";
				$display_ap_categ 	= getApCateg(0, 0);
			}else{
				$show_txt_page 	.= "<p style='color: red;'><b>Une erreur s'est produite. Contactez l'administrateur.</b></p>"; 
			}
		}

		break;
		
	case 'update': //ok
		$display_ap_categ = getApCateg($get_categ_id, 0);
		
		if(!$post_categ_fr || !is_txt($post_categ_fr) || !$post_categ_en || !is_txt($post_categ_en)){//if(!$post_categ_fr || !is_txt($post_categ_fr) || !$post_categ_en || !is_txt($post_categ_en)){
				
			if(!$post_submit){
				//affichage des catégories d'appareil
				foreach ($display_ap_categ AS $apCat) {
					$ap_categ_id	=	$apCat['ap_categ_id'];
					$ap_categ_fr	=	$apCat['ap_categ_fr'];
					$ap_categ_en	=	$apCat['ap_categ_en'];
				}
				
			$display_form 	= true;
			$page 			= "admin_appareil_categ";
			$get_action 	= "update";
				
			}else{
				if(!$post_categ_fr || !is_txt($post_categ_fr)){
						//test
					if(!is_txt($post_categ_fr)){
						$display_error_categ_fr .= "Le texte indiqué est incorrect. ";
					}
					//end test
					$is_empty_categ_fr 		.= " emptyField";
					$display_error_categ_fr .= "Le texte indiqué est incorrect ou le champ est vide";
				}
				if(!$post_categ_en || !is_txt($post_categ_en)){
					$is_empty_categ_en 		.= " emptyField";
					$display_error_categ_en .= "Le texte indiqué est incorrect ou le champ est vide";
				}
			}
			
			echo "<br />BONOJUR";
			
		}else{
			$upd_ap_categ 		= updApCateg($get_categ_id, $post_categ_fr, $post_categ_en);
			$display_form 		= false;
			$display_ap_categ 	= getApCateg(0,0); 
			$page 				= "admin_appareil_categ";
			$get_action 		= "view";		
		}

		break;
		
	case 'delete': //ok
		$delete_ap_categ 	= delReactApCateg($get_categ_id, 0);
		$display_ap_categ 	= getApCateg(0,0);
		$page 				= "admin_appareil_categ";
		$get_action 		= "view";
		
		break;
		
	case 'reactive': //ok
		$reactive_ap_categ 	= delReactApCateg($get_categ_id, 1);
		$display_ap_categ 	= getApCateg(0,0);
		$page 				= "admin_appareil_categ";
		$get_action 		= "view";
		break;
}

?>