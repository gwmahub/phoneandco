<?php
//gestion du profil -> affichage des données dans les champs
function getUserPub($user_id){
	if(!is_numeric($user_id)){
		return false;
	}
	
	$sql = "SELECT `membre_id`, `langue`, `prenom`, `nom`, `pseudo`,`email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `is_visible`, `actif`,`date_add` 
			FROM `".DB_PREFIXE."membre` ";
			
	if($user_id != null){
		$sql .= " WHERE `membre_id` = $user_id ";
	}
	
	//echo "getUserPub ->".$sql;
	
	return requeteResultat($sql);
}


function updateMembre($membre_id, $lang, $f_name, $l_name, $pseudo, $email, $password, $avatar, $city, $birthday, $nlet_inscr){
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
                newsletter_inscript = '$nlet_inscr'
                               
            WHERE membre_id = '$membre_id'
            ";
			
	//echo $sql;
	
    if(ExecRequete($sql)){
        return true;
    }else{
        return false;
    }
}








?>