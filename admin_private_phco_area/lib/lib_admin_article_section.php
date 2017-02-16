<?php

function getArtSect($art_sect_id, $is_visible, $order){
	if(!is_numeric($art_sect_id)){
		return false;
	}
	
	$sql = "SELECT `article_section_id`, `article_section_fr`, `article_section_en`, `is_visible` 
			FROM `" .DB_PREFIXE . "article_section` ";
	
	if($art_sect_id != NULL){
		$sql .= " WHERE `article_section_id` = $art_sect_id ";
		
		if($is_visible != NULL  ){
			$sql .= " AND `is_visible` = '$is_visible'";	
		}
	}
	
	if($is_visible != NULL  ){
			$sql .= " WHERE `is_visible` = '$is_visible'";	
		}
	
	if($order != null){
		$sql .= " ORDER BY article_section_fr $order";
	}

	//echo $sql;
	return requeteResultat($sql);
}

//affichage des catégories par section -> view

function getCategBySection($section_id){
	if(!is_numeric($section_id)){
		return false;
	}
	
	$sql = "SELECT article_categ_fr, article_categ_en FROM ". DB_PREFIXE ."article_categ
			INNER JOIN ".DB_PREFIXE."art_sec_categ_assoc 
			ON (".DB_PREFIXE."article_categ.article_categ_id = ".DB_PREFIXE."art_sec_categ_assoc.article_categ_id)
			WHERE article_section_id = '$section_id'
			AND is_visible = '1'
			ORDER BY article_categ_fr ASC";
			
	if(is_array(requeteResultat($sql)) && count($sql)){
		$categ_tab = requeteResultat($sql);
		return $categ_tab;
		}
}


function insertArtSect($art_sect_fr, $art_sect_en){
	$art_sect_fr = convert2DB($art_sect_fr);
	$art_sect_en = convert2DB($art_sect_en);
	
	
	$sql = "INSERT INTO " .DB_PREFIXE ."article_section (article_section_fr, article_section_en) 
			VALUES ('$art_sect_fr', '$art_sect_en')";
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}

//insertion de plusieurs nouvelles catégories en 1X et récup des id pour utilisation ds insertCategBySection()
function insertMultiArtCateg($new_art_categ_tab){
	
	if(is_array($new_art_categ_tab) && $new_art_categ_tab != null){
		$last_categ_id_tab = array();
		
		$cpt = 1;
		for($i=0, $c=(count($new_art_categ_tab)-1); $i<$c; $i=$i+2){
			
			$sql_categ = "INSERT INTO " .DB_PREFIXE ."article_categ (article_categ_fr, article_categ_en) 
					VALUES ('".convert2DB($new_art_categ_tab[$i])."', '".convert2DB($new_art_categ_tab[$cpt])."')";
			//echo "sql_categ<br/>".$sql_categ;
			ExecRequete($sql_categ);
			$last_categ_id_tab[] = mysql_insert_id();
			$cpt=$cpt+2;
		}
		//var_dump($last_categ_id_tab);	
		return $last_categ_id_tab;
	}else{
		return false;
	}
	
}

function insertCategBySection($art_sect_id, $art_categ_tab){//$art_categ_tab = (1, 24, 36, 2);
	if(!is_numeric($art_sect_id)){
		return false;
	}
	if(is_array($art_categ_tab) && $art_categ_tab != null){
		foreach($art_categ_tab AS $catId){
			$catId = convert2DB($catId);
			$sql = "INSERT INTO " .DB_PREFIXE ."art_sec_categ_assoc (article_section_id, article_categ_id) 
					VALUES ('$art_sect_id', '$catId')";
			ExecRequete($sql);
			//echo $sql."<br />";
		}
		return true;
	}else{
		return false;
	}
}



function updArtSect($art_sect_id, $art_sect_fr, $art_sect_en){
	$art_sect_fr = convert2DB($art_sect_fr);
	$art_sect_en = convert2DB($art_sect_en);
	
	if(is_numeric($art_sect_id) && $art_sect_id > 0){
		$sql = "UPDATE ".DB_PREFIXE ."article_section 
			SET 
			article_section_fr		=	'$art_sect_fr', 
			article_section_en		=	'$art_sect_en' 
			 
			WHERE article_section_id	=	$art_sect_id
			";
	}
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}


function delReactArtSect($art_sect_id, $visible){
	
	if(is_numeric($art_sect_id) && $art_sect_id > 0){
		
	$sql = "UPDATE ".DB_PREFIXE ."article_section 
			SET 
			is_visible	=	'$visible' 
			
			WHERE article_section_id	=	'$art_sect_id'
			";
	}		
			
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}	
}


?>