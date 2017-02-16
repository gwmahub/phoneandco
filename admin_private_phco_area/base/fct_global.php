<?php
    // BASE/fct_global

    
// Cette fonction vérifie qu'une variable existe bien. 
// Si elle existe, la variable est retournée, si elle n'existe pas c'est la valeur "default" qui est retournée
// Sera fort utilisée dans le cas de $_POST & $_GET
function ifsetor(&$val, $default = null){
    return isset($val) ? $val : $default;
}

// Cette fonction va servir à récupérer les variables envoyées par POST ou par GET
function param($val){
    return ifsetor($_REQUEST[$val], false);
}

function print_q($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

function convert2DB($txt){
    global $connexion;
    return mysqli_real_escape_string($connexion,trim($txt));
}

function convertFromDB($txt){
    return stripslashes($txt);
}

/**
* Format date.
* @param $date date à reformater
* @return string date formatée aaaa-mm-jj
*/
function dateFr2Us($date) {
    list($jour, $mois, $annee) = explode('-', $date);
return ($annee . '-' . $mois . '-' . $jour);
}

/**
* Format date.
* @param $dat date à reformater
* @return string date formatée jj-mm-aaaa
*/
function dateUs2Fr($date) {
    list($annee, $mois, $jour) = explode('-', $date);
return ($jour . '-' . $mois . '-' . $annee);
}

//!!!!!!!! test avec - à vérifier !!!!!!!!!!!!!
function isGoodDateFR($date){
    $pattern = '/[0-9]{2}\-[0-9]{2}\-[0-9]{4}/';
    if(preg_match($pattern, $date)) {
        list($jour, $mois, $annee) = explode('-', $date);
        return(checkdate($mois, $jour, $annee)); //Vérifie la validité d'une date formée par les arguments. Une date est considérée comme valide si chaque paramètre est défini correctement. 
    } else {
    	echo "pas une goodDateFr :-(";
		
       return false;
	   
    }
}

/*function isGoodDateFR($date){
    $pattern = '/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/';

    if(preg_match($pattern, $date)) {
        list($jour, $mois, $annee) = explode('/', $date);
        return(checkdate($mois, $jour, $annee)); //Vérifie la validité d'une date formée par les arguments. Une date est considérée comme valide si chaque paramètre est défini correctement. 
    } else {
        return false;
    }
}*/


function is_txt($text){
	$pattern = "/^[a-zàâäçéèêëîïôöûü\-\s']{2,}$/i";
	return preg_match($pattern, $text);
}

function is_txtComplex($text){
	$pattern = "/^[a-zàâäçéèêëîïôöûü@&\,\:\-\s'-+.\w]{1,128}$/i";
	return preg_match($pattern, $text);
}

function is_pseudo($pseudo){
	$pattern = "/^[a-zàâäçéèêëîïôöûü\-\s'-+.\w]{1,64}$/i";
	return preg_match($pattern, $pseudo);
}


function is_new_pseudo($nPseudo){
	
	$sql_ckeck_pseudo = "SELECT COUNT('pseudo') AS 'nb_pseudo' FROM ".DB_PREFIXE."membre WHERE pseudo LIKE '".trim($nPseudo)."'";
	//echo $sql_ckeck_pseudo.";
	if($check_pseudo = requeteResultat($sql_ckeck_pseudo)){
		//var_dump (requeteResultat($sql_ckeck_pseudo));
		//var_dump($check_pseudo[0]["COUNT('pseudo')"]);
		if($check_pseudo[0]["nb_pseudo"] < 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

function is_email($email){
	$pattern = "/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i";
	return preg_match($pattern, $email);
}

function email_confirm($email1, $email2){
	if(trim($email1) != trim($email2)){
		return false;
	}else{
		return true;
	}
}


?>