<?php

//test
function getUserId($email){

	$sql = "SELECT `membre_id`, `langue`, `prenom`, `nom`, `pseudo`,`email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `is_visible`, `actif`,`date_add`  FROM ".DB_PREFIXE."membre WHERE email LIKE '%$email%'";
	
	$result = requeteResultat($sql);
	
	//echo "<p>+++++++++++++++++</p>".var_dump($result);
	return $result;
	
}

//enregistrement d'un nouveau membre
function insertUser($lang, $f_name, $l_name, $pseudo, $email, $password, $avatar, $city, $birthday, $nlet_inscr, $cle){
	
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
	$cle 		= convert2DB($cle);
	

	$sql_membre = "INSERT INTO ".DB_PREFIXE."membre (`langue`, `prenom`, `nom`, `pseudo`, `email`, `password`, `avatar`, `ville`, `date_naiss`, `newsletter_inscript`, `cle_inscript`, `date_add`)
	VALUES
	('$lang', '$f_name', '$l_name',  '$pseudo', '$email', md5($password), '$avatar', '$city', '$birthday', '$nlet_inscr','$cle', NOW() )";
	
	//echo $sql_membre;
	
	if(ExecRequete($sql_membre)){
		$last_membre_id = mysql_insert_id();
		return true;
	}else{
		return false;
	}
}


//gestion gréation du nouveaux compte: 1.envoi email pour activation 2.validation

//New register
function createMail($email, $cle, $lang) {
    $destinataire = $email;
	
    $sujet 	= $lang == 'fr'?"Phone&amp;Co - Activation": "Phone&amp;Co - Activation";
    $entete = "From:Phone&amp;Co <info@phoneandco.be>";
    $entete .='MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";


    // Le lien d'activation est compos&eacute; du login(log) et de la cl&eacute;(cle)
    $message = $lang == 'fr'?"<p>Bonjour,</p>
    <p>Nous avons bien reçu votre demande d'inscription sur notre site.</p>
    <p>Pour activer votre inscription, veuillez cliquer sur le lien ci dessous ou le copier/coller dans votre navigateur internet.
    <br/><a href='". PATH_SITE . "?lang=".$lang."&p=index_forms&typ_form=validation&email=".urlencode($email)."&cle=" . urlencode($cle) . "'>Activation</a></p>
    <p>---------------</br>Ceci est un mail automatique. Merci de ne pas y repondre.</p>":
	"<p>Hello,</p>
    <p>We received you registration demand.</p>
    <p>To activate your account, please click on the link below or copy / paste it into your browser.
    <br/><a href='". PATH_SITE . "?lang=".$lang."&p=index_forms&typ_form=validation&email=".urlencode($email)."&cle=" . urlencode($cle) . "'>Activation</a></p>
    <p>---------------</br>This is an automatic email. Thank you not to answer.</p>"
	;
    
    //$message=utf8_encode($message);

	if (mail($destinataire, $sujet, $message, $entete)) {
	    return true;
	} else {
	    return false;
	}
   
}
//-----------------------------------------


function createMailConfirmation($email) {
    $destinataire = $email;
    
    
    $sujet = "Phone&amp;Co - Activation effectuée avec succès";
    
    //Problème avec le serveur de l'école
    $sujet=utf8_encode($sujet);
    
    $entete .='MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    

    // Le lien d'activation est composé du login(log) et de la cl?(cle)
    $message = "<p>Bonjour,</p>
    <p>Votre compte est actif.</p>
    

    <p>---------------</br>
    Ceci est un mail automatique. Merci de ne pas y repondre.</p>";
      


if (mail($destinataire, $sujet, $message, $entete)) {
    return true;
} else {
    return false;
}
   
}

function verifUser($email, $cle){
    $sql = "SELECT cle_inscript, actif FROM ".DB_PREFIXE."membre WHERE
        email='$email' AND cle_inscript='$cle';";
    //echo $sql;
    $resultat= requeteResultat($sql);
    
    return (!$resultat)? false : ($resultat);
}

function actifUser($email){
    $sql = "UPDATE ".DB_PREFIXE."membre SET actif='1' WHERE email='$email' ";
    //echo $sql;
    return ExecRequete($sql)? mysql_insert_id():false;
}
//fin gestion creation nouveau compte


//newsletter
function insertEmail($lang, $email){
	$lang 		= convert2DB($lang);
	$email 		= convert2DB($email);
	
	$sql_email = "INSERT INTO ".DB_PREFIXE."membre (`langue`, `email`, `newsletter_inscript`, `date_add`)
	VALUES
	('$lang', '$email', '1', NOW() )";
	
	//echo $sql_email;
	
	if(ExecRequete($sql_email)){
		$last_membre_id = mysql_insert_id();
		//var_dump($last_membre_id); 
		return true;
	}else{
		return false;
	}
}

//gestion du profil -> affichage des données dans les champs
function getUserPub($user_id, $order, $limit){
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
	
	//echo "getUserPub ->".$sql;
	
	return requeteResultat($sql);
}

//compte personnel du membre -> modification
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
	//echo $sql;
	
    if(ExecRequete($sql)){
        return true;
    }else{
        return false;
    }
}

?>