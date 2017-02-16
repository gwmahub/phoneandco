<?php

function getUser($user_id, $order, $limit){
	if(!is_numeric($user_id)){
		return false;
	}
	
	$sql = "SELECT `membre_id`, `langue`, `prenom`, `nom`, `pseudo`,`email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `is_visible`, `actif`,`date_add` 
			FROM `".DB_PREFIXE."membre` ";
			
	if($user_id != null){
		$sql .= " WHERE `membre_id` = $user_id ";
	}
	if($order != null){
		$sql .= " ORDER BY `date_add` $order ";
	}
	if($limit != null){
		$sql .= "LIMIT $limit";
	}
	
	//echo "getUser ->".$sql;
	
	return requeteResultat($sql);
}



/**
 * @param $_filter_1 = is_visible
 * @param $_filter_2 = champ de la table
 * @param $_filter_3 = filtre contient commence par ou égal
 * @param $user_data = saisie de l'utilisateur
*/

function engine_user($_filter_1, $_filter_2, $_filter_3, $user_data, $order, $limit){
	$user_data = trim($user_data);
	$sql = "SELECT `membre_id`, `langue`, `prenom`, `nom`, `pseudo`,`email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `is_visible`, `actif`,`date_add` 
			FROM `".DB_PREFIXE."membre` ";
			
	
	if($_filter_1 == null && $_filter_2 == null && $_filter_3 != null && $user_data == null && $order != null){
		$sql .= " ORDER BY prenom $order";
	}
			
		
	if($_filter_1 == '0' && $_filter_2 == null && $_filter_3 != null && $user_data == null){
		$sql .= " WHERE is_visible = '$_filter_1' "	;
		$sql .= " ORDER BY prenom";
			if($order){
				$sql .= " $order";
			}
			if($limit){
				$sql .= " LIMIT $limit";
			}
	}
		
	if($_filter_1 == '1' && $_filter_2 == null && $user_data == null){
		$sql .= "WHERE is_visible = '$_filter_1' ";
	}
	
	if($_filter_1 != null && $_filter_2 != null && $user_data == null){
		$sql .= " WHERE is_visible = '$_filter_1' ORDER BY `$_filter_2` ";
			if($order){
				$sql .= "$order";
			}
			if($limit){
				$sql .= " LIMIT $limit";
			}
	}
	
	if($_filter_1 != null && $_filter_2 != null && $user_data != null){
		
		switch($_filter_3){
			case "contient":
				$sql .= " WHERE is_visible = '$_filter_1' AND $_filter_2 LIKE '%$user_data%' ";
			break;
			case "commence":
				$sql .= " WHERE is_visible = '$_filter_1' AND $_filter_2 LIKE '%$user_data' ";
			break;
			case "egal":
				$sql .= "WHERE is_visible = '$_filter_1' AND $_filter_2 = '$user_data' ";
			break;
		}
		
		$sql .= "ORDER BY '$_filter_2' ";
		if($order){
			$sql .= " $order ";
			}
		if($limit){
			$sql .= " LIMIT $limit";
		}
	}
	
	if($_filter_1 == null && $_filter_2 != null && $user_data == null){
		$sql .= " ORDER BY `$_filter_2` ";
			if($order){
				$sql .= " $order";
			}
			if($limit){
				$sql .= " LIMIT $limit";
			}
	}
	
	if($_filter_1 == null && $_filter_2 != null && $user_data != null){		
		switch($_filter_3){
			case "contient":
				$sql .= "WHERE `$_filter_2` LIKE '%$user_data%' ";
			break;
			case "commence":
				$sql .= "WHERE `$_filter_2` LIKE '$user_data%' ";
			break;
			case "egal":
				$sql .= "WHERE `$_filter_2` = '$user_data' ";
			break;
		}
		
		if($order){
			$sql .= " ORDER BY `$_filter_2` $order";
		}
		if($limit){
			$sql .= " LIMIT $limit";
		}
	}
	
	if($_filter_1 != null && $_filter_2 == null && $user_data != null){
		$sql .= " WHERE `is_visible` = '$_filter_1' AND ";
		
			switch($_filter_3){
				case "contient":
					$sql .= " `langue` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `langue` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `langue` = '$user_data' ";
				break;
			}
			
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `prenom` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `prenom` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `prenom` = '$user_data' ";
				break;
			}
		
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `nom` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `nom` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `nom` = '$user_data' ";
				break;
			}
			
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `pseudo` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `pseudo` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `pseudo` = '$user_data' ";
				break;
			}
		
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `email` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `email` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `email` = '$user_data' ";
				break;
			}
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `avatar` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `avatar` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `avatar` = '$user_data' ";
				break;
			}
		
		$sql .= " OR ";
			switch($_filter_3){
				case "contient":
					$sql .= " `ville` LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " `ville` LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " `ville` = '$user_data' ";
				break;
			}
		
		
		if($order){
			$sql .= " ORDER BY `$_filter_2` $order";
		}
		if($limit){
			$sql .= " LIMIT $limit";
		}
	}
	
	if($_filter_1 == null && $_filter_2 == null && $user_data != null){
		
		$sql .= "WHERE `langue` ";
			switch($_filter_3){
				case "contient":
					$sql .= " LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " = '$user_data' ";
				break;
			}
		$sql .= "OR `prenom` ";
			switch($_filter_3){
				case "contient":
					$sql .= " LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " = '$user_data' ";
				break;
			}
			
		$sql .= "OR `nom` ";
			switch($_filter_3){
				case "contient":
					$sql .= " LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " = '$user_data' ";
				break;
			}
			
		$sql .= "OR `pseudo` ";
			switch($_filter_3){
				case "contient":
					$sql .= " LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " = '$user_data' ";
				break;
			}
			
		$sql .= "OR `email` ";
			switch($_filter_3){
				case "contient":
					$sql .= " LIKE '%$user_data%' ";
				break;
				case "commence":
					$sql .= " LIKE '$user_data%' ";
				break;
				case "egal":
					$sql .= " = '$user_data' ";
				break;
			}
			
		//test	
		if($order){
			$sql .= " ORDER BY prenom $order";
		}
		if($limit){
			$sql .= " LIMIT $limit";
		}
		//end test
	}
	
	//echo "engine_user -> // <br />".$sql."<br />";
	return requeteResultat($sql);
}	
//enregistrement d'un nouveau membre
function insertUser($lang, $f_name, $l_name, $pseudo, $email, $password, $avatar, $city, $birthday, $nlet_inscr){
	
	$lang 		= convert2DB($lang);
	$f_name 	= convert2DB($f_name);
	$l_name 	= convert2DB($l_name);
	$pseudo 	= convert2DB($pseudo);
	$email 		= convert2DB($email);
	$password	= convert2DB($password);
	$avatar 	= convert2DB($avatar);
	$city 		= convert2DB($city);
	$birthday 	= convert2DB($birthday);
	$nlet_inscr = convert2DB($nlet_inscr);

	$sql_membre = "INSERT INTO ".DB_PREFIXE."membre (`langue`, `prenom`, `nom`, `pseudo`, `email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `date_add`)
	VALUES
	('$lang', '$f_name', '$l_name',  '$pseudo', '$email', MD5('$password'), '$avatar', '$city', '$birthday', '$nlet_inscr', NOW() )";
	
	//echo $sql_membre;
	
	if(ExecRequete($sql_membre)){
		$last_membre_id = mysql_insert_id();
		return true;
	}else{
		return false;
	}
}

function updateMembre($membre_id, $lang, $f_name, $l_name, $pseudo, $email, $password, $avatar, $city, $birthday, $nlet_inscr, $is_visible){
	$lang			= convert2DB($lang);
    $f_name         = convert2DB($f_name);
    $l_name         = convert2DB($l_name);
    $pseudo         = convert2DB($pseudo);
    $email          = convert2DB($email);
    $password       = convert2DB($password);
    $avatar         = convert2DB($avatar);
    $city           = convert2DB($city);
    $birthday       = convert2DB($birthday);
    $nlet_inscr     = convert2DB($nlet_inscr);
    $is_visible     = convert2DB($is_visible);

    $new_pswd       = "";
    if(!empty($password)){
        $new_pswd = " password = MD5('$password'), ";
    }
    
    $sql = "UPDATE ".DB_PREFIXE."membre 
            SET 
            	langue				= '$lang', 
            	prenom      		= '$f_name', 
                nom         		= '$l_name', 
                pseudo      		= '$pseudo', 
                email         		= '$email', 
                $new_pswd
                avatar          	= '$avatar', 
                ville       		= '$city', 
                date_naiss          = '$birthday', 
                newsletter_inscript = '$nlet_inscr',
                is_visible			= '$is_visible' 
               
            WHERE membre_id = '$membre_id'
            ";
	echo $sql;
	
    if(ExecRequete($sql)){
        return true;
    }else{
        return false;
    }
}

function delReact_membre($membre_id, $is_visible){
    if(!is_numeric($membre_id)){
        return false;
    }
    $membre_id = convert2DB($membre_id);
	$is_visible = convert2DB($is_visible);
	
    if($membre_id > 0){
        $sql = "UPDATE ".DB_PREFIXE."membre  
                SET 
                    is_visible = '$is_visible' 
                WHERE membre_id = $membre_id;";
        //echo $sql;
        return ExecRequete($sql) ? true : false;
	}
}

?>