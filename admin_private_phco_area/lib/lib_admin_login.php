<?php
function getUserAuth($login, $password){
    $login    = convert2DB($login);
    $password = convert2DB($password);
    
    // vérification de l'association login et password dans la DB
    $sql = "SELECT membre_id, prenom, nom, actif, statut 
            FROM ".DB_PREFIXE."membre 
            WHERE pseudo = '$login' 
                AND password = MD5('$password');
            ";
	//echo $sql;
			
    if($result = requeteResultat($sql)){
    	           
        if($actif=convertFromDB($result[0]["actif"])){
            $membre_id		= convertFromDB($result[0]["membre_id"]);
            $f_name         = convertFromDB($result[0]["prenom"]);
            $l_name       	= convertFromDB($result[0]["nom"]);
			//$avatar			= convertFromDB($result[0]["avatar"]);
            $statut      	= convertFromDB($result[0]["statut"]);

            $_SESSION["m_membre_id"]  = $membre_id;
            $_SESSION["m_nom"]        = $f_name;
            $_SESSION["m_prenom"]     = $l_name;
			//$_SESSION["m_avatar"]     = $avatar;
            $_SESSION["m_login"]      = $login;
            $_SESSION["m_statut"]     = $statut;
			
			//var_dump($_SESSION);
			
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



function createMail($email, $cle) {
    $destinataire = $email;

    $sujet = "ISL - Activation";
    $entete = "From:ISL EPS Liege<admin@isl.be>";
    $entete .='MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";


    // Le lien d'activation est compos? du login(log) et de la cl?(cle)
    $message = "<p>Bonjour,</p>
    <p>Nous avons bien reçu votre demande d'inscription notre site.</p>
    <p>Pour activer votre inscription, veuillez cliquer sur le lien ci dessous ou le copier/coller dans votre navigateur internet.
    <br/>" . PATH_SITE . "?p=login&action=validation&log=" . urlencode($email) . "&cle=" . urlencode($cle) . "</p>
    <p>---------------</br> Ceci est un mail automatique. Merci de ne pas y repondre.</p>";
    
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
    
    
    $sujet = "ISL - Activation effectuée avec succès";
    
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
    $sql = "SELECT cle, actif FROM ".DB_PREFIXE."personne WHERE
        email='$email' AND cle='$cle';";
    echo $sql;
    $resultat= requeteResultat($sql);
    
    return (!$resultat)? false : ($resultat);
}

function actifUser($email){
    $sql = "UPDATE ".DB_PREFIXE."personne SET actif='1' WHERE email='$email' ";
    echo $sql;
    return ExecRequete($sql)? mysql_insert_id():false;
}

function insertUser($nom, $prenom,$login, $pass, $cle){
    $passCrypte=md5($pass);
    
    $sql = "INSERT INTO ".DB_PREFIXE."personne (nom, prenom, email, password, add_date, cle, actif)
        VALUES('$nom','$prenom', '$login', '$passCrypte', NOW(), '$cle', 0)";
    
    echo $sql;
    
    return ExecRequete($sql)? mysql_insert_id():false;   
}

function is_email_exist($mail) {

    $sql = "SELECT membre_id from ".DB_PREFIXE."membre
                    WHERE email = '$mail'";
    echo $sql;
    $result = requeteResultat($sql);
    return (!$result ) ? false : ($result);
}


?>
