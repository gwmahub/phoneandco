<?php
function getApList($is_visible, $categ_id, $fab_id, $ap_id, $groupByCateg, $groupByFab, $groupByAp, $field, $user_data, $order){//MEMO: $groupby=1 à tester si probl de stats (COUNT...SUM)
	if((!empty($categ_id) && !is_numeric($categ_id)) || (!empty($fab_id) && !is_numeric($fab_id)) || (!empty($ap_id) && !is_numeric($ap_id))){
		return false;
	}
	
	$user_data = trim($user_data);
	
	$sql = " SELECT ".DB_PREFIXE."appareil.ap_id, ap_img_index, ap_titre_fr, ap_titre_en, ap_courte_desc_fr, ap_courte_desc_en, ap_desc_fr,
			ap_desc_en, ap_fiche_tech_fr, ap_fiche_tech_en, ".DB_PREFIXE."appareil.is_visible, ".DB_PREFIXE."appareil.ap_date_add,

			 ".DB_PREFIXE."appareil_categ.ap_categ_id, ap_categ_fr, ap_categ_en,

			 ".DB_PREFIXE."fabricant.fab_id, fab_logo, fabricant

			FROM ".DB_PREFIXE."appareil

			LEFT JOIN ".DB_PREFIXE."appareil_categ_assoc ON (".DB_PREFIXE."appareil.ap_id = ".DB_PREFIXE."appareil_categ_assoc.ap_id)
			LEFT JOIN ".DB_PREFIXE."appareil_categ ON (".DB_PREFIXE."appareil_categ_assoc.ap_categ_id = ".DB_PREFIXE."appareil_categ.ap_categ_id)
			
			LEFT JOIN ".DB_PREFIXE."appareil_fab_assoc ON (".DB_PREFIXE."appareil.ap_id = ".DB_PREFIXE."appareil_fab_assoc.ap_id)
			LEFT JOIN ".DB_PREFIXE."fabricant ON (".DB_PREFIXE."appareil_fab_assoc.fab_id = ".DB_PREFIXE."fabricant.fab_id)

			";

		if($is_visible != null && $field == null && $user_data == null && $ap_id == null){
			$sql .= " WHERE ".DB_PREFIXE."appareil.is_visible = '$is_visible'";
		}
		
		if($is_visible != null && $field != null && $user_data != null){
			$sql .= " WHERE ".DB_PREFIXE."appareil.is_visible = '$is_visible' AND $field LIKE '%$user_data%'";
		}
		
		if($is_visible == null && $field != null && $user_data != null){
			$sql .= " WHERE $field LIKE '%$user_data%'";
		}

		if(($is_visible == null  || $is_visible != null)  && $field == null && $user_data != null){//$is_visible < 2 ?
			$sql .= " WHERE ap_titre_fr 	LIKE '%$user_data%'
					  OR ap_titre_en 		LIKE '%$user_data%'
					  OR ap_courte_desc_fr 	LIKE '%$user_data%'
					  OR ap_courte_desc_en 	LIKE '%$user_data%'
					  OR ap_desc_fr 		LIKE '%$user_data%'
					  OR ap_desc_en 		LIKE '%$user_data%'
					  OR ap_date_add 		LIKE '%$user_data%'
					  OR ap_categ_fr 		LIKE '%$user_data%'
					  OR ap_categ_en 		LIKE '%$user_data%'
					  OR fabricant 			LIKE '%$user_data%'
					";
		}
		
		// a vérifier -> ok
		if($categ_id != null){
			$sql .= " WHERE  ".DB_PREFIXE."appareil_categ.ap_categ_id = $categ_id";
		}
		
		if($fab_id != null){
			$sql .= " WHERE ".DB_PREFIXE."fabricant.fab_id = $fab_id";
		}
		
		
		if($is_visible != null && $ap_id != null){
			$sql .= " WHERE ".DB_PREFIXE."appareil.is_visible = '$is_visible' AND ".DB_PREFIXE."appareil.ap_id = $ap_id";
		}
		//UPDATE !!			
		if($ap_id != null && $is_visible == null){
			$sql .= " WHERE ".DB_PREFIXE."appareil.ap_id = $ap_id ";//GROUP BY ".DB_PREFIXE."appareil.ap_id
		}

		if($groupByCateg != null){
			$sql .= " GROUP BY ".DB_PREFIXE."appareil_categ_assoc.ap_categ_id";
		}
		
		if($groupByFab != null){
			$sql .= " GROUP BY ".DB_PREFIXE."fabricant.fab_id";
		}
		
		/*if($groupByAp != null){*/
			$sql .= " GROUP BY  ".DB_PREFIXE."appareil.ap_id";
		/*}*/
		
		if($order != null){
			$sql .= " ORDER BY ".DB_PREFIXE."appareil.ap_id $order";
		}
	
	//echo "<br />".$sql;
	
	$ap_list = requeteResultat($sql);

	return $ap_list;
}

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


function getFabByAp($ap_id){
	if(!is_numeric($ap_id)){
			return false;
		}
	
	$sql = "SELECT ".DB_PREFIXE."fabricant.fab_id, fabricant, fab_logo 
			FROM ".DB_PREFIXE."fabricant
			LEFT JOIN ".DB_PREFIXE."appareil_fab_assoc ON ( ".DB_PREFIXE."fabricant.fab_id = ".DB_PREFIXE."appareil_fab_assoc.fab_id)
			WHERE ap_id = '$ap_id'";
			
	return requeteResultat($sql);
}

/*Appareil par fabricant*/
function getApByFab($fab_id){
	if(!is_numeric($fab_id)){
		return false;
	}
	$sql = "SELECT ap_id, fab_id FROM ".DB_PREFIXE." appareil_fab_assoc WHERE fab_id = $fab_id";
	//echo $sql;
	return requeteResultat($sql);
}

/*Liste des catégories associée à un appareil donné*/
function getCategsByAp($ap_id){
	if(!is_numeric($ap_id)){
		return false;
	}
	$sql = "SELECT ap_categ_id FROM ".DB_PREFIXE."appareil_categ_assoc WHERE ap_id = $ap_id";
	//echo "<h1>".$sql."</h1>";
	return requeteResultat($sql);
}
?>