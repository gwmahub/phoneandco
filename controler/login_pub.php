<?php
include_once(PATH_LIBS."lib_login.php");

$var_page 	= "home";
$msg 		= "";

$get_typ_form		= ifsetor($_GET["typ_form"], "");
$get_state			= ifsetor($_GET["state"], "");
$get_lang			= ifsetor($_GET["lang"],"fr");
$post_pseudo 		= ifsetor($_POST["pseudo"], "");
$post_password 		= ifsetor($_POST["password"], "");
$post_submit		= ifsetor($_POST["submit"], "");

$is_empty_pseudo	= "";
$is_empty_psw		= "";

$display_error_pseudo 	= "";
$display_error_psw		= "";

if($get_lang){
	
	switch($get_lang){
		case "en":
			
			switch($get_typ_form){
				case "login":
					if(!$post_pseudo || !$post_password){
					    if($post_submit){
					        if(!$post_pseudo){
					        	$display_error_pseudo .= "The field pseudo is empty or not valid.";
					            $is_empty_pseudo = " emptyField";
					        }
					        if(!$post_password){
					        	$display_error_psw .= "The field password is empty or not valid"; 
					            $is_empty_psw = " emptyField";
					        }
					    }  
					    $page = "home";
					}else{
					    if(getUserAuth($post_pseudo, $post_password)){
					    	//var_dump($_SESSION);
					        $page = "home";
					    }else{
					        $msg.="<p style='color: #ed1c24; font-weight: bolder;'>&rarr;&nbsp;Le pseudo et/ou le mot de passe est incorrect.</p>";
					        $page = "home";
					    }
					}
					break;
				}//END swtitch $get_typ_form -> en
			break;
			
		default:
			switch($get_typ_form){
				case "login":
					if(!$post_pseudo || !$post_password){
					    if($post_submit || $get_state == "error"){
					        if(!$post_pseudo){
					            $is_empty_pseudo = " emptyField";
					        }
					        if(!$post_password){
					            $is_empty_psw = " emptyField";
					        }
					    }  
					    $page = "home";
					}else{
					    if(getUserAuth($post_pseudo, $post_password)){
					    	//var_dump($_SESSION);
					        $page = "home";
					    }else{
					        $msg.="<p style='color: #ed1c24; font-weight: bolder;'>&rarr;&nbsp;Le pseudo et/ou le mot de passe est incorrect.</p>";
					        $page = "home";
					    }
					}
					
					break;
				}//END swtitch $get_typ_form -> fr
			break;
			
		}//End switch $get_lang
}


?>