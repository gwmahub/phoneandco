<?php

include_once(PATH_LIBS."lib_admin_article_section.php");

function getArtCateg($art_categ_id, $is_visible){
	if(!is_numeric($art_categ_id)){
		return false;
	}
	
	$sql = "SELECT `article_categ_id`, `article_categ_fr`, `article_categ_en`, `is_visible` 
			FROM `" .DB_PREFIXE . "article_categ` ";
	
	if($art_categ_id != NULL){
		$sql .= " WHERE `article_categ_id` = $art_categ_id ";
		
		if($is_visible != NULL  ){
			$sql .= " AND `is_visible` = '$is_visible'";	
		}
	}
	
	if($is_visible != NULL  ){
			$sql .= " WHERE `is_visible` = '$is_visible'";	
		}
	
	$sql .= "ORDER BY `article_categ_fr` ASC";

	//echo $sql;
	return requeteResultat($sql);
}

function insertArtCateg($art_categ_fr, $art_categ_en){
	$art_categ_fr = convert2DB($art_categ_fr);
	$art_categ_en = convert2DB($art_categ_en);

	$sql = "INSERT INTO " .DB_PREFIXE ."article_categ (article_categ_fr, article_categ_en) 
			VALUES ('$art_categ_fr', '$art_categ_en')";
			
	//echo $sql;
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}

function insertArtCategAliasSect($art_categ_id, $art_sect_id){
	if(!is_numeric($art_categ_id) || !is_numeric($art_sect_id)){
		return false;
	}
		$sql = "INSERT INTO " .DB_PREFIXE ."art_sec_categ_assoc (article_categ_id, article_section_id) 
				VALUES ('$art_categ_id', '$art_sect_id')";
		
	return ExecRequete($sql) ? TRUE:FALSE;
}



function updArtCateg($art_categ_id, $art_categ_fr, $art_categ_en){
	$art_categ_fr = convert2DB($art_categ_fr);
	$art_categ_en = convert2DB($art_categ_en);
	
	if(is_numeric($art_categ_id) && $art_categ_id > 0){
		$sql = "UPDATE ".DB_PREFIXE ."article_categ 
			SET 
			article_categ_fr	=	'$art_categ_fr', 
			article_categ_en		=	'$art_categ_en' 
			 
			WHERE article_categ_id	=	$art_categ_id
			";
	}
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}


function delReactArtCateg($art_categ_id, $visible){
	
	if(is_numeric($art_categ_id) && $art_categ_id > 0){
		
	$sql = "UPDATE ".DB_PREFIXE ."article_categ 
			SET 
			is_visible	=	'$visible' 
			
			WHERE article_categ_id	=	'$art_categ_id'
			";
	}		
			
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}	
}


?>