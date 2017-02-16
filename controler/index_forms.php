<?php

include_once(PATH_LIBS."lib_membres_pub.php");
include_once(PATH_LIBS."lib_tools.php");

$var_page = "index_forms";

//flag d'affichage de formulaire
$display_form 	= false;
$display_error 	= "";
$avatar			= "";
$no_avatar 		= "no_avatar.jpg";

//GET
$get_lang 		= ifsetor($_GET["lang"], "fr");
$get_typ_form 	= ifsetor($_GET["typ_form"], "");
$get_membre_id 	= ifsetor($_GET['id'], "");
$get_email		= ifsetor($_GET['email'], "");

//POST
$post_lg			= ifsetor($_POST["lang"], "");
$post_membre_id		= ifsetor($_POST["membre_id"], "");
$post_first_name 	= ifsetor($_POST["first_name"], "");
$post_last_name 	= ifsetor($_POST["last_name"], "");
$post_pseudo 		= ifsetor($_POST["pseudo"], "");
$post_email 		= ifsetor($_POST["email"], "");
$post_email_2		= ifsetor($_POST["email_confirm"], "");

$post_password 		= ifsetor($_POST["password"], "");
$post_src_fichier	= ifsetor($_FILES["src_fichier"], "");
$post_old_avat	= ifsetor($_FILES["old_file"], "");

//var_dump($post_src_fichier);
//var_dump(getimagesize($post_src_fichier['tmp_name']));

$post_city			= ifsetor($_POST["city"], "");

//BIRTHDAY
$post_day		= ifsetor($_POST["b_day"], "");
$post_month		= ifsetor($_POST["b_month"], "");
$post_year		= ifsetor($_POST["b_year"], "");
//initialisation de la variable complète
$post_birthday_comp = "";

//NEWSLETTER
$post_nl_regist = ifsetor($_POST["nl_regist"], "");

$post_submit	= ifsetor($_POST["submit"], "");

//check empty
$is_empty_fname 	= "";
$is_empty_lname 	= "";
$is_empty_pseudo 	= "";
$is_empty_email 	= "";
$is_empty_psw 		= "";
$is_empty_avatar 	= "";
$is_empty_city 		= "";

$is_empty_day 		= "";
$is_empty_month 	= "";
$is_empty_year 		= "";
$is_empty_nl_reg	= "";

//message d'erreur pour l'utilisateur
$display_error_fname	= "";
$display_error_lname	= "";
$display_error_pseudo	= "";
$display_error_email	= "";
$display_error_email_2	= "";
$display_error_psw		= "";
$display_error_avatar	= "";
$display_error_city		= "";

switch($get_lang){
	case "en":
		
switch($get_typ_form){

	case "new_register":
	
	if(!$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || !$post_pseudo || !is_pseudo($post_pseudo) 
		|| !$post_email || !is_email($post_email)  || !$post_email_2 || !is_email($post_email_2)  || !email_confirm($post_email, $post_email_2) || !$post_password 
		|| !$post_day || !$post_month || !$post_year){ //champs obligatoires
			
	$display_form = true;
	
	if($post_submit){

		if(!$post_first_name || !is_txt($post_first_name)){
			$display_error_fname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le nom n'est pas valide ou le champ est vide. Modèle: Dupont.":"&rarr;&nbsp;Invalid first name or empty field. Model: Dupont.";
			$is_empty_fname .= " emptyField";
		}
		
		if(!$post_last_name || !is_txt($post_last_name)){
			$display_error_lname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le nom n'est pas valide ou le champ est vide. Modèle: Nicolas.":"&rarr;&nbsp;Invalid first name or empty field. Model: Nicolas.";
			$is_empty_lname .= " emptyField";
		}
		
		if(!$post_pseudo || !is_pseudo($post_pseudo)){
			$display_error_pseudo .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pseudo n'est pas valide ou le champ est vide. Modèle: jerry_56.":"&rarr;&nbsp;Invalid pseudo or empty field. Model: jerry_56.";
			$is_empty_pseudo .= " emptyField";
		}
		
		if(!$post_email || !$post_email_2 || !is_email($post_email) || !is_email($post_email_2)){
			if(!$post_email || !is_email($post_email)){
				$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
			if(!$post_email_2 || !is_email($post_email_2)){
				$display_error_email_2 .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail de confirmation n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid confirmation e-mail or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
		}
		
		if(!email_confirm($post_email, $post_email_2)){
			$display_error_email_2 .= ($get_lang == "fr") ? "&rarr;&nbsp;Les deux e-mails sont différents.":"&rarr;&nbsp;The twoo writed e-mails are different";
			$is_empty_email .= " emptyField";
			$page = "";
		}
		
		//AJOUTER is_email_exist($post_email);
		if(is_email_exist($post_email)){
			$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;Cette adresse e-mail existe déjà.":"&rarr;&nbsp;This e-mail adres already exist.";
		}
		
		$is_empty_psw		= (!$post_password) ? " emptyField":"";
		$is_empty_day		= (!$post_day) ? " emptyField":"";
		$is_empty_month		= (!$post_month) ? " emptyField":"";
		$is_empty_year		= (!$post_year) ? " emptyField":"";
	}
			
		$page = "index_forms";
		
	}else{
	
		if(!$post_city || !is_txt($post_city)){
			$display_error_city .= ($get_lang == "fr") ? "&rarr;&nbsp;La ville n'est pas valide. Modèle: Bruxelles":"&rarr;&nbsp;Invalid city. Model: New-York.";
		}
		
		//creation de la variable $post_birthday_comp
		if(!empty($post_day) && !empty($post_month) && !empty($post_year)){
				$post_birthday_comp = $post_year."-".$post_day."-".$post_month;
		}
		
		if(!empty($post_src_fichier['name'])){
			$upload = uploadImg($_FILES, "avatar/");
			//var_dump($upload);//ok
				if(!$upload){
					$display_error_avatar .= ($get_lang == "fr") ? "&rarr;&nbsp; Pas d'avatar envoyé.":"&rarr;&nbsp;No dowloaded avatar";
				}else{
					$avatar .= $upload['img'];//$post_src_fichier['name'];
					//var_dump($avatar);//ok				
				}
		}else{
			$avatar = $no_avatar;
		}
	
		//inscription à la newsletter
		if(!$post_nl_regist){
			$is_empty_nl_reg .= " emptyField";
		}
		
		//génération de la clé pour la confirmation d'inscription
		$cle = md5(microtime(TRUE) * 100000);
		/*function insertUser case add*/
		if(insertUser($get_lang, $post_first_name, $post_last_name, $post_pseudo, $post_email, $post_password, $avatar , $post_city, $post_birthday_comp, $post_nl_regist, $cle)){
				
			//recup id pour le nommage de l'avatar -> test !!
			$last_member_id = mysql_insert_id();
		
			$avatar_path = "";
			
			$avatar_path .= WWW_UP."avatar/".$avatar;
			$check_img_ext = getimagesize($avatar_path);
			//var_dump($check_img_ext);
			
			if($check_img_ext[2] == 1){
				if(!resize_gif($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 2){
				if(!resize_jpg($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 3){
				if(!resize_png($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}else{
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'avatar envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The avatar you sent hasn't good format. Please try again !</h3>";
			}			
			
			$display_form = false;
			
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>"; //
			
			//vérification si envoi de l'email pour l'acivation s'est bien déroulé
			if (createMail($post_email, $cle, $get_lang)) {
                $show_txt_page .= ($get_lang=="fr") ? 
                "Un e-mail vous a ete envoye a l'adresse : " . $post_email . " pour vous indiquer comment valider votre inscription.":
                "A mail has been sent to: ". $post_email . " to show you how validate your registration.";

            } else {
				$show_txt_page .= ($get_lang=="fr") ? 
                "Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
                "An error occured. Please contact the administrator";
                }	
			
			$page = "index_forms";
		}
	}
	
	break;
	
	case "validation":
		
		//$show_txt_page .= "<h1>++++++++++++++ CASE VALIDATION ++++++++++</h1>";
		
	    //$display_form = true;
	    
        if (!isset($_GET['email']) || !isset($_GET['cle'])) {
            $show_txt_page .= $get_lang == "fr"? 
            "Nous ne pouvons pas valider votre inscription,  veuillez contacter l'administrateur du site":
            "We are not able to validate your registration. Please contact the administrator.";
            
            $page = "index_forms";
            $get_typ_form = "new_registration";
            
        } else {
            $email = $_GET['email'];//ok
            $cle = $_GET['cle'];//ok

            $checkUser = verifUser($email, $cle);//ok
            
            if (!$checkUser) {
                $show_txt_page .= $get_lang == "fr"? 
	            "Cette adresse e-mail n'existe pas.":
	            "This e-mail adres doesn't exist.";
	            
	            $page = "index_forms";
	            $get_typ_form = "validation";
	            
            } else {
                if ($checkUser[0]['actif'] == '1') {//si le compte est déjà actif...
                    $show_txt_page .= $get_lang == "fr"?"Votre compte est deja  actif !<br/> Merci de vous connecter en cliquant
                    <a href='?lang=$get_lang&p=home'> <b>ici</b></a>.":
					"Your account is already activated!<br/ >Click <a href='?lang=$get_lang&p=home'> <b>here</b></a> to login.";
                    
                    $page = "index_forms";
	            	$get_typ_form = "validation";
	            	
                } else {
                    if (trim($cle) == convertFromDB($checkUser[0]['cle_inscript'])) {//si la cle de l'url est la même que celle de la DB...
                    //$show_txt_page .= var_dump(convertFromDB($checkUser[0]['cle_inscript']));
                        if (!actifUser($email)) { 
                        		
                            if (createMailConfirmation($email)) {
                                $show_txt_page .= $get_lang == "fr"?"Votre inscription est terminée !<br/> Merci de vous connecter en cliquant
                                <a href='?lang=$get_lang&p=home'> <b>ici</b></a>.":
								"Your account is activated!<br/ >Click <a href='?lang=$get_lang&p=home'> <b>here</b></a> to login.";
                   				$page = "home";
	            				//$get_typ_form = "new_registration";
                               
                            } else {
                                $show_txt_page .= ($get_lang=="fr") ? 
               					"Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
               					"An error occured. Please contact the administrator";
                   				$page = "index_forms";
	            				$get_typ_form = "new_registration";
                            }
                        } else {
                            $show_txt_page .= ($get_lang=="fr") ? 
               				"Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
               				"An error occured. Please contact the administrator";
                   			$page = "index_forms";
	            			$get_typ_form = "new_registration";
                        }
                    }
                }
            }
        }
	break;
	
	case"pass_forgot":
		if(!$post_pseudo || !is_txt($post_pseudo) || !$post_email || !is_email($post_email)){ //champs obligatoires
					
			$display_form = true;
			
			if($post_submit){
				
				if(!$post_pseudo || !is_txt($post_pseudo)){
					$display_error_pseudo .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pseudo n'est pas valide ou le champ est vide. Modèle: jerry_56.":"&rarr;&nbsp;Invalid pseudo or empty field. Model: jerry_56.";
					$is_empty_pseudo .= " emptyField";
				}
				
				if(!$post_email || !is_email($post_email)){
					$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
					$is_empty_email .= " emptyField";
				}
		
			}
					
				$page = "index_forms";
		}else{
			
			//fonction mail
				
				$show_txt_page .= ($get_lang=="fr")?"<h3>Un e-mai a été envoyé à l'adresse que vous avez indiqué.</h3>":"<h3>An e-mail has been sent to the specified e-mail adres</h3>"; //
				
				$page = "index_forms";
			}
	
		break;
	
	case "news_letter":
		if(!$post_email || !is_email($post_email) || !is_new_email($post_email)){ //champs obligatoires
			if($post_submit){
				if(!$post_email || !is_email($post_email)){
					$display_error_email .= ($get_lang == "fr") ? 
					"&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":
					"&rarr;&nbsp;Invalid pseudo or empty field. Model: smith@smith.com.";
					$is_empty_email .= " emptyField";
				}
				if(!is_new_email($post_email)){
					//$display_form = true;
					$display_error_email .= ($get_lang == "fr") ? 
					"&rarr;&nbsp;Cette adresse e-mail existe déjà."
					:
					"&rarr;&nbsp;This e-mail address already exist.";
					$is_empty_email .= " emptyField";
					$show_txt_page .= ($get_lang == "fr") ? 
					"<br/><p>Si vous êtes déjà membre Phone&Co, vous pouvez vous inscrire à la newsletter dans votre espace personnel.</p>"
					:
					"<br /><p>If you are already a Phone&Co member, you can subscribe to the newsletter in your personnal area.</p>";
				}
			}
			$display_form = true;
			$page = "index_forms";
			}else{
				if(insertEmail($get_lang, $post_email)){
					$display_form = false;
					$show_txt_page .= ($get_lang=="fr")?"<h3>Nous avons bien reçu votre inscription à la newsletter Phone&amp;Co. MERCI !</h3>":"<h3>Your registration has been well recieved. THANKS !</h3>";
					$page = "index_forms";
				}else{
					$display_form = true;
					$show_txt_page .= ($get_lang=="fr")?"<h3>Votre inscription à la newsletter Phone&amp;Co à échoué. Désolé !</h3>":"<h3>Your registration has failed. SORRY !</h3>";
				}
				
			}
		break;
}//END switch $typ_form

	break;
/*-------------------------- fr ------------------------------*/
default:

switch($get_typ_form){
	
case "new_register":
	if(!$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || !$post_pseudo
		|| !$post_email || !is_email($post_email)  || !$post_email_2 || !is_email($post_email_2)  || !email_confirm($post_email, $post_email_2) 
		|| !$post_password || !$post_day || !$post_month || !$post_year){ //champs obligatoires
			
	$display_form = true;
	
	if($post_submit){

		if(!$post_first_name || !is_txt($post_first_name)){
			$display_error_fname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le nom n'est pas valide ou le champ est vide. Modèle: Dupont.":"&rarr;&nbsp;Invalid first name or empty field. Model: Dupont.";
			$is_empty_fname .= " emptyField";
		}
		
		if(!$post_last_name || !is_txt($post_last_name)){
			$display_error_lname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le nom n'est pas valide ou le champ est vide. Modèle: Nicolas.":"&rarr;&nbsp;Invalid first name or empty field. Model: Nicolas.";
			$is_empty_lname .= " emptyField";
		}
		
		if(!$post_pseudo){
			$display_error_pseudo .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pseudo n'est pas valide ou le champ est vide. Modèle: jerry_56.":"&rarr;&nbsp;Invalid pseudo or empty field. Model: jerry_56.";
			$is_empty_pseudo .= " emptyField";
		}
		
		if(!$post_email || !$post_email_2 || !is_email($post_email) || !is_email($post_email_2)){
			if(!$post_email || !is_email($post_email)){
				$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
			if(!$post_email_2 || !is_email($post_email_2)){
				$display_error_email_2 .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail de confirmation n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid confirmation e-mail or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
		}
		
		if(!email_confirm($post_email, $post_email_2)){
			$display_error_email_2 .= ($get_lang == "fr") ? "&rarr;&nbsp;Les deux e-mails sont différents.":"&rarr;&nbsp;The twoo writed e-mails are different";
			$is_empty_email .= " emptyField";
			$page = "";
		}
		
		//AJOUTER is_email_exist($post_email);
		if(is_email_exist($post_email)){
			$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;Cette adresse e-mail existe déjà.":"&rarr;&nbsp;This e-mail adres already exist.";
		}
		
		$is_empty_psw		= (!$post_password) ? " emptyField":"";
		$is_empty_day		= (!$post_day) ? " emptyField":"";
		$is_empty_month		= (!$post_month) ? " emptyField":"";
		$is_empty_year		= (!$post_year) ? " emptyField":"";
	}
			
		$page = "index_forms";
		
	}else{
	
		if(!$post_city || !is_txt($post_city)){
			$display_error_city .= ($get_lang == "fr") ? "&rarr;&nbsp;La ville n'est pas valide. Modèle: Bruxelles":"&rarr;&nbsp;Invalid city. Model: New-York.";
		}
		
		//creation de la variable $post_birthday_comp
		if(!empty($post_day) && !empty($post_month) && !empty($post_year)){
				$post_birthday_comp = $post_year."-".$post_day."-".$post_month;
		}
		
		if(!empty($post_src_fichier['name'])){
			$upload = uploadImg($_FILES, "avatar/");
			//var_dump($upload);//ok
				if(!$upload){
					$display_error_avatar .= ($get_lang == "fr") ? "&rarr;&nbsp; Pas d'avatar envoyé.":"&rarr;&nbsp;No dowloaded avatar";
				}else{
					$avatar .= $upload['img'];//$post_src_fichier['name'];
					//var_dump($avatar);//ok				
				}
		}else{
			$avatar .= $no_avatar;
		}
	
		//inscription à la newsletter
		if(!$post_nl_regist){
			$is_empty_nl_reg .= " emptyField";
		}
		
		//génération de la clé pour la confirmation d'inscription
		$cle = md5(microtime(TRUE) * 100000);
		/*function insertUser case add*/
		if(insertUser($get_lang, $post_first_name, $post_last_name, $post_pseudo, $post_email, $post_password, $avatar , $post_city, $post_birthday_comp, $post_nl_regist, $cle)){
				
			//recup id pour le nommage de l'avatar -> test !!
			$last_member_id = mysql_insert_id();
		
			$avatar_path = "";
			
			$avatar_path .= WWW_UP."avatar/".$avatar;
			$check_img_ext = getimagesize($avatar_path);
			//var_dump($check_img_ext);
			
			if($check_img_ext[2] == 1){
				if(!resize_gif($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 2){
				if(!resize_jpg($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}elseif($check_img_ext[2] == 3){
				if(!resize_png($avatar_path, 60, "resized_".$avatar, WWW_UP."avatar/")){
					$display_error_avatar.= $get_lang == "fr"?"Une erreur est survenue. Contactez l'administrateur": "An error occurred. Please contact the administrator.";
				}
			}else{
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'avatar envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The avatar you sent hasn't good format. Please try again !</h3>";
			}			
			
			$display_form = false;
			
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>"; //
			
			//vérification si envoi de l'email pour l'acivation s'est bien déroulé
			if (createMail($post_email, $cle, $get_lang)) {
                $show_txt_page .= ($get_lang=="fr") ? 
                "Un e-mail vous a ete envoye a l'adresse : " . $post_email . " pour vous indiquer comment valider votre inscription.":
                "A mail has been sent to: ". $post_email . " to show you how validate your registration.";

            } else {
				$show_txt_page .= ($get_lang=="fr") ? 
                "Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
                "An error occured. Please contact the administrator";
                }	
			
			$page = "index_forms";
		}
	}
	
	break;
	
	case "validation":
		
		$show_txt_page .= "<h1>++++++++++++++ CASE VALIDATION ++++++++++</h1>";
		
	    //$display_form = true;
	    
        if (!isset($_GET['email']) || !isset($_GET['cle'])) {
            $show_txt_page .= $get_lang == "fr"? 
            "Nous ne pouvons pas valider votre inscription,  veuillez contacter l'administrateur du site":
            "We are not able to validate your registration. Please contact the administrator.";
            
            $page = "index_forms";
            $get_typ_form = "new_registration";
            
        } else {
            $email = $_GET['email'];//ok
            $cle = $_GET['cle'];//ok

            $checkUser = verifUser($email, $cle);//ok
            
            if (!$checkUser) {
                $show_txt_page .= $get_lang == "fr"? 
	            "Cette adresse e-mail n'existe pas.":
	            "This e-mail adres doesn't exist.";
	            
	            $page = "index_forms";
	            $get_typ_form = "validation";
	            
            } else {
                if ($checkUser[0]['actif'] == '1') {//si le compte est déjà actif...
                    $show_txt_page .= $get_lang == "fr"?"Votre compte est deja  actif !<br/> Merci de vous connecter en cliquant
                    <a href='?lang=$get_lang&p=home'> <b>ici</b></a>.":
					"Your account is already activated!<br/ >Click <a href='?lang=$get_lang&p=home'> <b>here</b></a> to login.";
                    
                    $page = "index_forms";
	            	$get_typ_form = "validation";
	            	
                } else {
                    if (trim($cle) == convertFromDB($checkUser[0]['cle_inscript'])) {//si la cle de l'url est la même que celle de la DB...
                    //$show_txt_page .= var_dump(convertFromDB($checkUser[0]['cle_inscript']));
                        if (!actifUser($email)) { 
                        		
                            if (createMailConfirmation($email)) {
                                $show_txt_page .= $get_lang == "fr"?"Votre inscription est terminée !<br/> Merci de vous connecter en cliquant
                                <a href='?lang=$get_lang&p=home'> <b>ici</b></a>.":
								"Your account is activated!<br/ >Click <a href='?lang=$get_lang&p=home'> <b>here</b></a> to login.";
                   				$page = "home";
	            				//$get_typ_form = "new_registration";
                               
                            } else {
                                $show_txt_page .= ($get_lang=="fr") ? 
               					"Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
               					"An error occured. Please contact the administrator";
                   				$page = "index_forms";
	            				$get_typ_form = "new_registration";
                            }
                        } else {
                            $show_txt_page .= ($get_lang=="fr") ? 
               				"Une erreur est survenue lors de votre inscription. Veuillez contacter l'administrateur du site":
               				"An error occured. Please contact the administrator";
                   			$page = "index_forms";
	            			$get_typ_form = "new_registration";
                        }
                    }
                }
            }
        }
	break;	

case"pass_forgot":
	if(!$post_pseudo || !is_txt($post_pseudo) || !$post_email || !is_email($post_email)){ //champs obligatoires
				
				$display_form = true;
				
				if($post_submit){
					
					if(!$post_pseudo || !is_txt($post_pseudo)){
						$display_error_pseudo .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pseudo n'est pas valide ou le champ est vide. Modèle: jerry_56.":"&rarr;&nbsp;Invalid pseudo or empty field. Model: jerry_56.";
						$is_empty_pseudo .= " emptyField";
					}
					
					if(!$post_email || !is_email($post_email)){
						$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
						$is_empty_email .= " emptyField";
					}
			
				}
						
					$page = "index_forms";
			}else{
									
					$show_txt_page .= ($get_lang=="fr")?"<h3>Un e-mai a été envoyé à l'adresse que vous avez indiqué.</h3>":"<h3>An e-mail has been sent to the specified e-mail adres</h3>"; //
					
					$page = "index_forms";
				}
	
	break;

case "news_letter":
	if(!$post_email || !is_email($post_email) || !is_new_email($post_email)){ //champs obligatoires
		if($post_submit){
			if(!$post_email || !is_email($post_email)){
				$display_error_email .= ($get_lang == "fr") ? 
				"&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":
				"&rarr;&nbsp;Invalid pseudo or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
			if(!is_new_email($post_email)){
				//$display_form = true;
				$display_error_email .= ($get_lang == "fr") ? 
				"&rarr;&nbsp;Cette adresse e-mail existe déjà."
				:
				"&rarr;&nbsp;This e-mail address already exist.";
				$is_empty_email .= " emptyField";
				$show_txt_page .= ($get_lang == "fr") ? 
				"<br/><p>Si vous êtes déjà membre Phone&Co, vous pouvez vous inscrire à la newsletter dans votre espace personnel.</p>"
				:
				"&rarr;&nbsp;<p>If you are already a Phone&Co member, you can subscribe to the newsletter in your personnal area.</p>";
			}
		}
		$display_form = true;
		$page = "index_forms";
		}else{
			if(insertEmail($get_lang, $post_email)){
				$display_form = false;
				$show_txt_page .= ($get_lang=="fr")?"<h3>Nous avons bien reçu votre inscription à la newsletter Phone&amp;Co. MERCI !</h3>":"<h3>Your registration has been well recieved. THANKS !</h3>";
				$page = "index_forms";
			}else{
				$display_form = true;
				$show_txt_page .= ($get_lang=="fr")?"<h3>Votre inscription à la newsletter Phone&amp;Co à échoué. Désolé !</h3>":"<h3>Your registration has failed. SORRY !</h3>";
			}
			
		}
		break;

	}//END switch $typ_form
	
		break;
	}




