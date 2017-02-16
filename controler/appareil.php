<?php

include_once(PATH_LIBS.'lib_appareil.php');


$var_page				= "appareil";
//GET
$get_action				=	ifsetor($_GET['action'], "view");
//ENGINE and ...
$get_ap_id				=	ifsetor($_GET["ap_id"], "");

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
		$display_ap_list 	= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");

		$display_ap_categ 	= getApCateg(0,"1");
		$display_ap_fab	 	= getFabricant(0,1,"ASC");

		$page 			= "appareil";
		$get_action 	= "view";	
	
	break;
	
	case 'detail':
		$display_ap_list 	= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
		$display_ap_categ 	= getApCateg(0,"1");
		$display_ap_fab	 	= getFabricant(0,1,"ASC");
		
		if(is_array($display_ap_list) && !empty($display_ap_list)){
		//var_dump($display_ap_list);
		$img_index			= $display_ap_list[0]["ap_img_index"];
		$fab_logo			= $display_ap_list[0]["fab_logo"];
		$fab				= $display_ap_list[0]["fabricant"];
		$ap_titre_fr		= $display_ap_list[0]["ap_titre_fr"];
		$ap_titre_en		= $display_ap_list[0]["ap_titre_en"];
		$ap_courte_desc_fr 	= html_entity_decode($display_ap_list[0]["ap_courte_desc_fr"], ENT_QUOTES, "utf-8");
		$ap_courte_desc_en 	= html_entity_decode($display_ap_list[0]["ap_courte_desc_en"], ENT_QUOTES, "utf-8");
		$ap_desc_fr			= html_entity_decode($display_ap_list[0]["ap_desc_fr"], ENT_QUOTES, "utf-8");
		$ap_desc_en			= html_entity_decode($display_ap_list[0]["ap_desc_en"], ENT_QUOTES, "utf-8");
		$ft_fr				= $display_ap_list[0]["ap_fiche_tech_fr"];
		$ft_en				= $display_ap_list[0]["ap_fiche_tech_en"];
		$is_visible 		= $display_ap_list[0]["is_visible"];
		
		}//END is_array($display_ap_list)
		$page 			= "appareil";
		$get_action 	= "detail";		
	break;
	
}

?>