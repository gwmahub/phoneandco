<?php
include_once(PATH_LIBS.'lib_admin_appareil_categ.php');

function getFabricant($fab_id, $is_visible, $order){
	if(!is_numeric($fab_id)){
		return false;
	}
	
	$sql_fab = "SELECT fab_id, fab_logo, fabricant, fab_is_visible FROM " .DB_PREFIXE ."fabricant ";
	
	if($fab_id != null){
		$sql_fab .= " WHERE fab_id = '$fab_id' ";
	}
	
	if($is_visible != null){
		$sql_fab .= " WHERE fab_is_visible = '$is_visible' ";
	}
	
	if($order != null){
		$sql_fab .= " ORDER BY fabricant $order ";
	}
	
	
	//echo "<br />".$sql_fab;
	
	if($display_fab = requeteResultat($sql_fab)){
		return $display_fab;
	}else{
		return false;
	}
}

//affichage des catégories d'appareils proposé par un fournisseur donné
function getApCategByFab($fab_id){
	if(!is_numeric($fab_id)){
		return false;
	}
	
	$sql = "SELECT " .DB_PREFIXE ."appareil_categ.ap_categ_id, ap_categ_fr, ap_categ_en, is_visible FROM " .DB_PREFIXE ."appareil_categ
			INNER JOIN " .DB_PREFIXE ."ap_fab_categ_assoc ON (" .DB_PREFIXE ."appareil_categ.ap_categ_id = " .DB_PREFIXE ."ap_fab_categ_assoc.ap_categ_id)
			
			WHERE fab_id = '$fab_id'";
			
	//print_q($sql);
			
	return requeteResultat($sql);
}

function insertFab($fab_logo, $fab_nom, $fab_is_visible){
	$fab_logo 			= convert2DB($fab_logo);
	$fab_nom 			= convert2DB($fab_nom);
	$fab_is_visible 	= convert2DB($fab_is_visible);
	
	$sql_insert_fab = "INSERT INTO pac_fabricant (fab_logo, fabricant, fab_is_visible)
						VALUES ('$fab_logo','$fab_nom','$fab_is_visible')";
	
	echo $sql_insert_fab;
	return ExecRequete($sql_insert_fab)?true:false;
}

//association des catégories d'appareil à un fabricant
function insertApCategByFab($fab_id, $ap_categ_tab){//$ap_categ_tab = (1, 24, 36, 2); -> les id des categ d'ap
	if(!is_numeric($fab_id)){
		return false;
	}
	if(is_array($ap_categ_tab) && $ap_categ_tab != null){
		foreach($ap_categ_tab AS $actId){
			$actId = convert2DB($actId);
			$sql = "INSERT INTO " .DB_PREFIXE ."ap_fab_categ_assoc (fab_id, ap_categ_id) 
					VALUES ('$fab_id', '$actId')";
			ExecRequete($sql);
			echo $sql."<br />";
		}
		return true;
	}else{
		return false;
	}
}
// Suppression des ancienne catégories d'appareils associées à ce fabricant
function delOldApCategByFab($fab_id){
	if(!is_numeric($fab_id)){
		return false;
	}
	
	$sql = "DELETE FROM `phoneandco`.`pac_ap_fab_categ_assoc` WHERE `pac_ap_fab_categ_assoc`.`fab_id` = $fab_id";

	echo $sql;
	
	return ExecRequete($sql)?true:false;
}

function updateFab($fab_id, $fab_logo, $fab_nom){
	if(!is_numeric($fab_id)){
		return false;
	}
	
	$fab_logo 		= convert2DB($fab_logo);
	$fab_nom	 	= convert2DB($fab_nom);
	
	$sql_upd_fab = " UPDATE `pac_fabricant`
					 SET
					  `fab_logo` 		= '$fab_logo',
					  `fabricant` 		= '$fab_nom'
					  
					  WHERE `fab_id` 	= '$fab_id'";
					  
	return ExecRequete($sql_upd_fab)?true:false;
}

function delReactiveFab($fab_id, $fab_is_visible){
	if(!is_numeric($fab_id)){
		return false;
	}
	$fab_is_visible	 	= convert2DB($fab_is_visible);
	
	$sql = "UPDATE `pac_fabricant`
		  	SET
			`fab_is_visible` = '$fab_is_visible'
		  
		 	  WHERE `fab_id` 	= '$fab_id'";
	echo $sql;
	return ExecRequete($sql)?true:false;
}








?>