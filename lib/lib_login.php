<?php
//
function getUserAuth($login, $password){
    $login    = convert2DB($login);
    $password = convert2DB($password);
    
    // vérification de l'association login et password dans la DB
    $sql = "SELECT membre_id, langue, prenom, nom, avatar, pseudo, actif, statut 
            FROM ".DB_PREFIXE."membre 
            WHERE pseudo = '$login' 
                AND password = MD5('$password'); 
            ";
	//echo $sql;
			
    if($result = requeteResultat($sql)){
    	           
        if($actif=convertFromDB($result[0]["actif"])){
            $membre_id		= convertFromDB($result[0]["membre_id"]);
			$langue        	= convertFromDB($result[0]["langue"]);
            $f_name         = convertFromDB($result[0]["prenom"]);
            $l_name       	= convertFromDB($result[0]["nom"]);
			$pseudo       	= convertFromDB($result[0]["pseudo"]);
			$avatar       	= convertFromDB($result[0]["avatar"]);
            $statut      	= convertFromDB($result[0]["statut"]);
			$actif      	= convertFromDB($result[0]["actif"]);

            $_SESSION["m_membre_id"]  = $membre_id;
			$_SESSION["m_langue"]     = $langue;
            $_SESSION["m_prenom"]     = $f_name;
            $_SESSION["m_nom"]        = $l_name;
			$_SESSION["m_pseudo"]     = $pseudo;
			$_SESSION["m_avatar"]     = $avatar;
            $_SESSION["m_login"]      = $login;
            $_SESSION["m_statut"]     = $statut;
            $_SESSION["m_actif"]	  = $actif;
			
			//echo $_SESSION;
			
        }else{
            return false; // membre non actif
        }
        
        return true;
    }else{
        return false;
    }
}

function unlog(){
    // destruction des variables de session en ré-initialisant le array $_SESSION
    $_SESSION = array();
    // on détruit la session et le cookie de session
    return session_destroy() ? true : false;    
}

?>