<?php

include_once(PATH_LIBS."lib_admin_fabricant.php");

function getApCateg($ap_categ_id, $is_visible){
	if(!is_numeric($ap_categ_id)){
		return false;
	}
	
	$sql = "SELECT `ap_categ_id`, `ap_categ_fr`, `ap_categ_en`, `is_visible` 
			FROM `" .DB_PREFIXE . "appareil_categ` ";
	
	if($ap_categ_id != NULL){
		$sql .= " WHERE `ap_categ_id` = $ap_categ_id ";
		
		if($is_visible != NULL  ){
			$sql .= " AND `is_visible` = '$is_visible' ";	
		}
	}
	
	if($is_visible != NULL  ){
			$sql .= " WHERE `is_visible` = '$is_visible'";	
		}
	
	$sql .= " ORDER BY `ap_categ_fr` ASC";

	//echo "<p>".$sql."</p>";
	return requeteResultat($sql);
}

function insertApCateg($ap_categ_fr, $ap_categ_en){
	$ap_categ_fr = convert2DB($ap_categ_fr);
	$ap_categ_en = convert2DB($ap_categ_en);

	$sql = "INSERT INTO " .DB_PREFIXE ."appareil_categ (ap_categ_fr, ap_categ_en, is_visible) 
			VALUES ('$ap_categ_fr', '$ap_categ_en', '1')";
			
	echo $sql;
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}

function insertApCategAliasSect($ap_fab_id, $ap_categ_id){
	if(!is_numeric($ap_fab_id) || !is_numeric($ap_categ_id)){
		return false;
	}
		$sql = "INSERT INTO " .DB_PREFIXE ."ap_fab_categ_assoc (fab_id, ap_categ_id) 
				VALUES ('$ap_fab_id', '$ap_categ_id')";
		
	return ExecRequete($sql) ? TRUE:FALSE;
}



function updApCateg($ap_categ_id, $ap_categ_fr, $ap_categ_en){
	$ap_categ_fr = convert2DB($ap_categ_fr);
	$ap_categ_en = convert2DB($ap_categ_en);
	
	if(is_numeric($ap_categ_id) && $ap_categ_id > 0){
		$sql = "UPDATE ".DB_PREFIXE ."appareil_categ 
			SET 
			ap_categ_fr		=	'$ap_categ_fr', 
			ap_categ_en		=	'$ap_categ_en' 
			 
			WHERE ap_categ_id	=	$ap_categ_id
			";
	}
	
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}
}


function delReactApCateg($ap_categ_id, $visible){
	
	if(is_numeric($ap_categ_id) && $ap_categ_id > 0){
		
	$sql = "UPDATE ".DB_PREFIXE ."appareil_categ 
			SET 
			is_visible			= '$visible' 
			
			WHERE ap_categ_id	= '$ap_categ_id'
			";
	}		
			
	if(ExecRequete($sql)){
		return true;
	}else{
		return false;
	}	
}


?>