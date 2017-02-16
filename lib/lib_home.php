<?php

function getSlides($slide_id, $order , $limit_dbt, $limit_fin){
	if(!is_numeric($slide_id)){
		return false;
	}
	
	$sql_slide = "SELECT slide_id, slide_img, slide_txt_fr, slide_txt_en, is_visible, date_add FROM pac_slide_pub 
				  WHERE is_visible = '1'";
	
	//identification du slide pour la création éventuelle d'un lien vers...
	if($slide_id != null){
		$sql_slide .= " AND slide_id = '$slide_id'";
	}
	
	$sql_slide .= "ORDER BY slide_id $order ";
	
	$sql_slide .= "LIMIT $limit_dbt , $limit_fin ";
	
	//echo $sql_slide;
	
	if($display_slides = requeteResultat($sql_slide)){
		return $display_slides;
	}else{
		return false;
	}
}


//affichage des 4 derniers appareils enregistrés
function getLastAp($limit){
	$sql = "SELECT ap_id, ap_img_index, ap_titre_fr, ap_titre_en, is_visible, ap_date_add
			FROM pac_appareil
			WHERE pac_appareil.is_visible = '1'
			ORDER BY pac_appareil.ap_id DESC
			LIMIT $limit";
			
	$r 	= requeteResultat($sql);
	
	return $r;
}


//affichage des 4 derniers articles enregistrés
function getLastArt($lang, $limit){
	$sql = "SELECT article_id, langue, img_index, article_titre, date_debut, date_fin is_visible 
			FROM pac_article
			WHERE pac_article.is_visible = '1'
			AND langue = '$lang'
			AND (`date_debut` <= NOW()) AND (`date_fin` >= NOW())
			ORDER BY pac_article.date_debut DESC
			LIMIT $limit";
	//echo $sql;
	$r 		= requeteResultat($sql);
	return $r;
}

function getAndResizeImgForHome(){
	global $imgArt;
}












?>