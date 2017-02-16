<?php
// INCLUDES
include_once(PATH_LIBS.'lib_account_user.php');
include_once(PATH_BASE.'protect_membre_pub.php');
include_once(PATH_LIBS.'lib_tools.php');


//VARS
$var_page = "account_user";
$avatar = "";

//GET
$get_lang 		= ifsetor($_GET["lang"], "fr");
//$get_action		= ifsetor($_GET["action"], "");

//SESSION
$user_id		= ifsetor($_SESSION["m_membre_id"] , "");
$user_lang		= ifsetor($_SESSION["m_langue"] , "");
$user_prenom	= ifsetor($_SESSION["m_prenom"] , "");
$user_nom		= ifsetor($_SESSION["m_nom"] , "");
$user_pseudo	= ifsetor($_SESSION["m_pseudo"] , "");
$user_avatar	= ifsetor($_SESSION["m_avatar"] , "");


$get_user_id 	= ifsetor($_GET['id'], "");

//+++ POST
$post_lg			= ifsetor($_POST["lang"], "");
$post_first_name 	= ifsetor($_POST["first_name"], "");
$post_last_name 	= ifsetor($_POST["last_name"], "");
$post_pseudo 		= ifsetor($_POST["pseudo"], "");
$post_email 		= ifsetor($_POST["email"], "");
$post_email_2		= ifsetor($_POST["email_confirm"], "");

$post_password 		= ifsetor($_POST["password"], "");

//AVATAR
$post_src_fichier	= ifsetor($_FILES["src_fichier"], "");
// test $post_src_fichier_tmp = ifsetor($_POST["src_fichier_tmp"], "");
//case update
$post_old_avat		= ifsetor($_POST['old_avat'], "");


$post_city			= ifsetor($_POST["city"], "");

//BIRTHDAY
$post_day		= ifsetor($_POST["b_day"], "");
$post_month		= ifsetor($_POST["b_month"], "");
$post_year		= ifsetor($_POST["b_year"], "");
//initialisation de la variable complète
$post_birthday_comp = "";

//NEWSLETTER
$post_nl_regist = ifsetor($_POST["nl_regist"], "");

//VISIBLE -> 
$post_is_visible = ifsetor($_POST["is_visible"], "");

//DATE_ADD -> pour conserver la valeur ds le champ. Pas de chmt dans la db
$post_date_add 	= ifsetor($_POST["date_add"], "");

$post_submit	= ifsetor($_POST["submit"], "");


//+++ CHECK EMPTY
$is_empty_lg	 	= "";
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


$display_user_data 	= getUserPub($user_id);


	if(!$post_lg || !$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || !$post_pseudo 
	|| !is_pseudo($post_pseudo)	|| !$post_email || !is_email($post_email) || !$post_day || !$post_month || !$post_year){ //champs obligatoires
		
		//AFFICHAGE des données ds les champs
		if(!$post_submit){
			
			$result = getUserPub($user_id);	
				
			// SI REQUETE OK
			if(isset($result) && is_array($result)){
				//affectation des vars
					$post_lg			= convertFromDB($result[0]['langue']);
					$post_first_name 	= convertFromDB($result[0]['prenom']);
					$post_last_name 	= convertFromDB($result[0]['nom']);
					$post_pseudo 		= convertFromDB($result[0]['pseudo']);
					$post_email			= convertFromDB($result[0]['email']);
					$post_password  	= "";
					$avatar				= convertFromDB($result[0]['avatar']);
					$post_city			= convertFromDB($result[0]['ville']);
					if($birthday_db		= convertFromDB($result[0]['date_naiss'])){//evite le message d'erreur si slmt email
						$birthday_db 		= explode("-", convertFromDB($result[0]['date_naiss']));
						$post_day 			= $birthday_db[2];
						$post_month 		= $birthday_db[1];
						$post_year 			= $birthday_db[0];
						$post_birthday_comp	= $birthday_db[0]."-".$birthday_db[1]."-".$birthday_db[2];
					}
					$post_nl_regist		= convertFromDB($result[0]['newsletter_inscript']);
					$post_is_visible	= convertFromDB($result[0]['is_visible']);
					$post_date_add		= dateUs2Fr((convertFromDB($result[0]['date_add'])));
										
				}else{// END isset($result)
					$show_txt_page .= $get_lang =="fr"?"<p>Problème d'affichage de vos données. Contactez l'administrateur.</p>" : "Problem to display your data. Contact the administrator.";
				}
		// si submit 
		}else{
			// vérif des champs
			if(!$post_lg){
				$is_empty_lg .= " emptyField";
			}
	
			if(!$post_first_name || !is_txt($post_first_name)){
				$display_error_fname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le nom n'est pas valide ou le champ est vide. Modèle: Dupont.":"&rarr;&nbsp;Invalid first name or empty field. Model: Dupont.";
				$is_empty_fname .= " emptyField";
			}
			
			if(!$post_last_name || !is_txt($post_last_name)){
				$display_error_lname .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pr&eacute;nom n'est pas valide ou le champ est vide. Modèle: Dupont.":"&rarr;&nbsp;Invalid last name or empty field. Model: Dupont.";
				$is_empty_lname .= " emptyField";
			}
			
			if(!$post_pseudo || !is_pseudo($post_pseudo)){
				$display_error_pseudo .= ($get_lang == "fr") ? "&rarr;&nbsp;Le pseudo n'est pas valide ou le champ est vide. Modèle: jerry_56.":"&rarr;&nbsp;Invalid pseudo or empty field. Model: jerry_56.";
				$is_empty_pseudo .= " emptyField";
			}
			
			if(!$post_email || !is_email($post_email) ){
					$display_error_email .= ($get_lang == "fr") ? "&rarr;&nbsp;L'e-mail n'est pas valide ou le champ est vide. Modèle: dupont@dupont.com":"&rarr;&nbsp;Invalid e-mail or empty field. Model: smith@smith.com.";
					$is_empty_email .= " emptyField";
			}
			
			$is_empty_day		= (!$post_day) ? " emptyField":"";
			$is_empty_month		= (!$post_month) ? " emptyField":"";
			$is_empty_year		= (!$post_year) ? " emptyField":"";
		
		}//END else submit
			
			$page			= "account_user";
			
//si tous les champs sont ok lors de l'envoi -> requete update
	}else{

		if(!$post_city || !is_txt($post_city)){
			$display_error_city .= ($get_lang == "fr") ? "&rarr;&nbsp;La ville n'est pas valide. Modèle: Bruxelles":"&rarr;&nbsp;Invalid city. Model: New-York.";
		}
		
		//creation de la variable $post_birthday_comp
		if(!empty($post_day) && !empty($post_month) && !empty($post_year)){
				$post_birthday_comp = $post_year."-".$post_day."-".$post_month;
		}
		
		$size_avat_tmp[2] = "";
		if(!empty($post_src_fichier['name'])){
			$size_avat_tmp = getimagesize($post_src_fichier['tmp_name']);
		}
		if(!empty($post_src_fichier['name']) && $size_avat_tmp[2] < 4){// sol 1:&& $post_src_fichier['name'] != $post_old_avat...
				
			$upload = uploadImg($_FILES, "avatar/");
			
				if(!$upload){
					$display_error_avatar .= ($get_lang == "fr") ? "&rarr;&nbsp; Pas d'avatar envoyé.":"&rarr;&nbsp;No dowloaded avatar";
				}else{
					$avatar .= $upload['img'];//$post_src_fichier['name'];
					 // si l'upload c'est bien passé, on peut supprimer définitivement l'ancienne img du serveur
            		if(delPicFile($post_old_avat, "avatar/")){
            			if(delPicFile($post_old_avat, "avatar/resized_")){
            				$show_txt_page .= ($get_lang == "fr") ? "<p>&rarr;&nbsp;Ancien avatar supprimé avec succès</p>": "<p>Old avatar correctly removed.</p>";
            			}
            		}else{
            			$show_txt_page .= ($get_lang == "fr") ? "<p>&rarr;&nbsp;Echec lors de la suppression de l'ancien avatar :-(</p>":"<p>&rarr;&nbsp;Failed to delete the old avatar.</p>";
            		}
					
					//var_dump($avatar);//ok				
				}
		}else{
			if(empty($post_src_fichier['name'])){
				$show_txt_page .= ($get_lang == "fr") ?"<p>&rarr;&nbsp;Pas de nouvel avatar envoyé.</p>":"<p>No new avatar sent.</p>";
			}
			if($size_avat_tmp[2] > 3){
				$show_txt_page .= ($get_lang == "fr") ?"<p>&rarr;&nbsp;L'avatar envoyé n'est pas un jpg, gif ou png</p>":"<p>&rarr;&nbsp;The avatar you sent is not a jpg gif or png.</p>";
			}
			if($post_old_avat){
				$avatar .= $post_old_avat;//sol 2 : $avatar = $post_old_avat
			}else{
				$avatar .= $no_avatar;
			}
			
		}
		
		//inscription à la newsletter
		if(!$post_nl_regist){
			$is_empty_nl_reg .= " emptyField";
		}				
		/*function update_membre case update*/
		if($update_membre = updateMembre($get_user_id, $post_lg, $post_first_name, $post_last_name, $post_pseudo, $post_email, $post_password, $avatar, $post_city, $post_birthday_comp, $post_nl_regist)){
				
			$avatar_path = "";
			
			$avatar_path .= WWW_UP."avatar/".$avatar;
			//echo "<br />".$avatar_path;
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
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'avatar envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The avater you sent hasn't good format. Please try again !</h3>";
			}						
			
		if($update_membre){
			$page 				= "account_user";
			$display_user_list 	= getUserPub($user_id);
		}else{
			echo "<p>Echec de l'execution de la req update_membre</p>";
		}
	}
}

?>



