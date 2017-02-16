<?php
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_admin_membres.php');
include_once(PATH_LIBS."lib_tools.php");

$var_page = "admin_membre";

//flag d'affichage de formulaire
$display_form 	= false;
// message d'erreur -> aide à la saisie
$display_error 	= "";
//init var
$avatar			= "";
$no_avatar 		= "no_avatar.jpg";

//+++ GET
//$get_lang = ifsetor($_GET["lang"], "fr");
$get_typ_form 	= ifsetor($_GET["typ_form"], "view");
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
//var_dump($post_old_avat);


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

//ENGINE
$post_filter_1		= ifsetor($_POST['filter_1'], "");
$post_filter_2		= ifsetor($_POST['filter_2'], "");
$post_filter_3		= ifsetor($_POST['filter_3'], "");
$post_user_data 	= ifsetor($_POST['user_data'], "");
$post_order 		= ifsetor($_POST['order'], "");

$post_limit 		= ifsetor($_POST['limit'], "");

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


// vérifier si l'id envoyé est bien un numerique
if (isset($get_membre_id) && !is_numeric($get_membre_id)) {
    // si ce n'est pas un numeric, on redirige vers la sélection des utilisateurs
    header("Location: index.php?p=$var_page");
    exit;
}


switch($get_typ_form){
	
case "view":

	$user_filter = engine_user($post_filter_1, $post_filter_2, $post_filter_3, $post_user_data, $post_order, $post_limit);
	//var_dump($user_filter);
	
	if(!empty($user_filter) && is_array($user_filter)){
		$display_user_list = engine_user($post_filter_1, $post_filter_2, $post_filter_3, $post_user_data, $post_order, $post_limit);
		//var_dump($display_user_list);
	}else{
		$display_user_list = engine_user(0, 0, 0, 0, 0, 0);
	}
	
	$page			="admin_membre";
	$get_typ_form 	= "view";
	
	break;
	
case "add":
	
	if(!$post_lg || !$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || !$post_pseudo || !is_pseudo($post_pseudo) 
		|| !$post_email || !is_email($post_email)  || !$post_email_2 || !is_email($post_email_2)  || !email_confirm($post_email, $post_email_2) || !$post_password 
		|| !$post_day || !$post_month || !$post_year){ //champs obligatoires
			
	$display_form = true;
	
	if($post_submit){
		
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
			$page = "admin_membre";
		}
		
		$is_empty_psw		= (!$post_password) ? " emptyField":"";
		$is_empty_day		= (!$post_day) ? " emptyField":"";
		$is_empty_month		= (!$post_month) ? " emptyField":"";
		$is_empty_year		= (!$post_year) ? " emptyField":"";
	}
			
		$page = "admin_membre";
	// si les champs oblig ok	
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
		//$post_nl_regist == "yes"? $post_nl_regist = "1": $post_nl_regist = "0";
		
		/*function insertUser case add*/
		if(insertUser($post_lg, $post_first_name, $post_last_name, $post_pseudo, $post_email, $post_password, $avatar , $post_city, $post_birthday_comp, $post_nl_regist)){
				
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
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'avatar envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The avater you sent hasn't good format. Please try again !</h3>";
			}			
					
			$display_form = false;
			
			$show_txt_page .= ($get_lang=="fr")?"<h3>Formulaire enregistré ! MERCI !</h3>":"<h3>Your form is registred ! THANKS !</h3>"; //
			
			$page = "admin_membre";
		}//END if insertUser
	}// END else champs oblig
	
	break;
	
case "update":
	
	if(!$post_lg || !$post_first_name || !is_txt($post_first_name) || !$post_last_name || !is_txt($post_last_name) || !$post_pseudo || !is_pseudo($post_pseudo)
		|| !$post_email || !is_email($post_email) || !$post_day || !$post_month || !$post_year){ //champs obligatoires
		
		//AFFICHAGE des données ds les champs
		if(!$post_submit){
			//requete function getUser($user_id, $order, $limit)
			$result = getUser($get_user_id, 0, 0);	
				
			// SI REQUETE OK
			if(isset($result) && is_array($result)){
				//affectation des vars
				foreach($result AS $r){
					$post_lg			= convertFromDB($r['langue']);
					$post_first_name 	= convertFromDB($r['prenom']);
					$post_last_name 	= convertFromDB($r['nom']);
					$post_pseudo 		= convertFromDB($r['pseudo']);
					$post_email			= convertFromDB($r['email']);
					$post_password  	= "";
					$avatar				= convertFromDB($r['avatar']);
					$post_city			= convertFromDB($r['ville']);
					if($birthday_db		= convertFromDB($r['date_naiss'])){//evite le message d'erreur si slmt email
						$birthday_db 		= explode("-", convertFromDB($r['date_naiss']));
						$post_day 			= $birthday_db[2];
						$post_month 		= $birthday_db[1];
						$post_year 			= $birthday_db[0];
						$post_birthday_comp	= $birthday_db[0]."-".$birthday_db[1]."-".$birthday_db[2];
					}
					$post_nl_regist		= convertFromDB($r['newsletter_inscript']);
					$post_is_visible	= convertFromDB($r['is_visible']);
					$post_date_add		= dateUs2Fr((convertFromDB($r['date_add'])));
					
				}//END foreach data
					
				}else{// END isset($result)
					echo "<p>Pas de résultats obtenus.</p>";
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
			
			$display_form 	= true;
			$page			= "admin_membre";
			$get_typ_form 	= "update";
			
//si tous les champs sont ok lors de l'envoi -> requete update
	}else{

		if(!$post_city || !is_txt($post_city)){
			$display_error_city .= ($get_lang == "fr") ? "&rarr;&nbsp;La ville n'est pas valide. Modèle: Bruxelles":"&rarr;&nbsp;Invalid city. Model: New-York.";
		}
		
		//creation de la variable $post_birthday_comp
		if(!empty($post_day) && !empty($post_month) && !empty($post_year)){
				$post_birthday_comp = $post_year."-".$post_day."-".$post_month;
		}
		
		//NOUVEL AVATAR
		$size_avat_tmp[2] = "";
		if(!empty($post_src_fichier['name'])){
			$size_avat_tmp = getimagesize($post_src_fichier['tmp_name']);
		}
		//$size_avat_tmp = getimagesize($post_src_fichier['tmp_name']);
		//var_dump($size_avat_tmp);
		if(!empty($post_src_fichier['name']) && $size_avat_tmp[2] < 4){// sol 1:&& $post_src_fichier['name'] != $post_old_avat...
				
				$upload = uploadImg($_FILES, "avatar/");
				
					if(!$upload){
						$display_error_avatar .= ($get_lang == "fr") ? "&rarr;&nbsp; Pas d'avatar envoyé.":"&rarr;&nbsp;No dowloaded avatar";
					}else{
						$avatar .= $upload['img'];//$post_src_fichier['name'];
						 // si l'upload c'est bien passé, on peut supprimer définitivement l'ancienne img du serveur
                		if(delPicFile($post_old_avat, "avatar/")){
                			if(delPicFile($post_old_avat, "avatar/resized_")){
                				$show_txt_page .= "<p>Ancien avatar supprimé avec succès</p>";
                			}
                		}else{
                			$show_txt_page .= "<p>Echec lors de la suppression de l'ancien avatar :-(</p>";
                		}
						
						//var_dump($avatar);//ok				
					}
			}else{
				if(empty($post_src_fichier['name'])){
					$show_txt_page .= "<p>Pas de nouvel avatar envoyé.</p>";
				}
				if($size_avat_tmp[2] > 3){
					$show_txt_page .= "<p>L'avatar envoyé n'est pas un jpg, gif ou png</p>";
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
		if($update_membre = updateMembre($get_user_id, $post_lg, $post_first_name, $post_last_name, $post_pseudo, $post_email, $post_password, $avatar, $post_city, $post_birthday_comp, $post_nl_regist, $post_is_visible)){
				
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
				$show_txt_page .= ($get_lang=="fr")?"<h3>L'avatar envoyé n'est pas un jpeg, gif ou png. Veuillez réessayer !</h3>":"<h3>The avater you sent hasn't good format. Please try again !</h3>";
			}						
			
		if($update_membre){
			$display_form 		= false;
			$page 				= "admin_membre";
			$get_typ_form 		= "view";
			$display_user_list 	= getUser(0, 0, 0);
		}else{
			echo "<p>Echec de l'execution de la req update_membre</p>";
		}
	}
}
	break;
	
case "delete":
	$del_membre = delReact_membre($get_user_id, "0");
	$page = "admin_membre";
	$get_typ_form = "view";
	$display_user_list = getUser(0, 0, 0);
	
	break;
	
case "reactive";
	$react_membre = delReact_membre($get_user_id, "1");
	$page = "admin_membre";
	$get_typ_form = "view";
	$display_user_list = getUser(0, 0, 0);//engine_user(0, 0, 0, 0, 0, 0);
	//var_dump($display_user_list);
	break;

	}//END switch $typ_form


?>