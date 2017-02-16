<?php
 
include_once(PATH_LIBS."lib_admin_login.php");

$var_page 	= "login_admin";
$msg 		= "";

$get_state			= ifsetor($_GET["state"], "");
 
$post_pseudo 		= ifsetor($_POST["pseudo"], "");
$post_password 		= ifsetor($_POST["password"], "");
$post_submit		= ifsetor($_POST["submit"], "");

$is_empty_pseudo	= "";
$is_empty_psw		= "";

$display_error_pseudo 	= "";
$display_error_psw		= "";

   
if(!$post_pseudo || !$post_password){
    if($post_submit || $get_state == "error"){
        if(!$post_pseudo){
            $is_empty_pseudo = " emptyField";
        }
        if(!$post_password){
            $is_empty_psw = " emptyField";
        }
    }  
    $page = "login_admin";
}else{       
    if(getUserAuth($post_pseudo, $post_password)){
        $page = "home";
    }
    else{
        $msg.="<p style='color: #ed1c24; font-weight: bolder;'>&rarr;&nbsp;Le pseudo et/ou le mot de passe est incorrect.</p>";
        $page = "login_admin";
    }
}
?>