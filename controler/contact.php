<?php
include_once(PATH_LIBS.'lib_contact.php');
$display_form 	= false;

$get_lang 		= ifsetor($_GET["lang"], "fr");
$get_action 	= ifsetor($_GET["action"], "view");

$post_first_name 	= ifsetor($_POST["first_name"], "");
$post_last_name 	= ifsetor($_POST["last_name"], "");
$post_pseudo 		= ifsetor($_POST["pseudo"], "");
$post_email 		= ifsetor($_POST["email"], "");
$post_msg 			= ifsetor($_POST["msg"], "");
$post_submit		= ifsetor($_POST["submit"], "");


//check empty
$is_empty_fname 	= "";
$is_empty_lname 	= "";
$is_empty_pseudo 	= "";
$is_empty_email 	= "";
$is_empty_msg		= "";

//message d'erreur pour l'utilisateur
$display_error_fname	= "";
$display_error_lname	= "";
$display_error_pseudo	= "";
$display_error_email	= "";
$display_error_msg		= "";

switch($get_action){
	case 'view':
		
	if(!$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || 
		!$post_email || !is_email($post_email)){ //champs obligatoires
		
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
		
		if(!$post_email || !is_email($post_email)){
			if(!$post_email || !is_email($post_email)){
				$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
				$is_empty_email .= " emptyField";
			}
		}
		
		if(!$post_msg ){
			$display_error_msg .= ($get_lang == "fr") ? "&rarr;&nbsp;Il n'y a pas de message :-(":"&rarr;&nbsp;No message writed :-(.";
			$is_empty_msg .= " emptyField";
		}		
	}
		$page 		= "contact";
		$get_action = "view";
		
	}else{
		$display_form 	= false;
		$post_msg = htmlentities($post_msg, ENT_QUOTES, "utf-8");
		
		if (sendMailContact($post_email, $get_lang)) {
            $show_txt_page .= ($get_lang=="fr") ? 
            "La copie de ce message a été envoyée à : " . $post_email . ".":
            "A copy of this mail has been sent to: ". $post_email . ".";

        } else {
			$show_txt_page .= ($get_lang=="fr") ? 
            "Une erreur est survenue lors de l'envoi de votre message. Veuillez contacter l'administrateur du site":
            "An error occured and your message hasn't been sent. Please contact the administrator";
        }
        

			$page 			= "contact";
			$get_action 	= "view";
	}	
	break;		
}
?>