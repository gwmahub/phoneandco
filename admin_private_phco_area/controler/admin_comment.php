<?php
//INCLUDES
include_once(PATH_BASE.'protect_admin.php');
include_once(PATH_LIBS.'lib_admin_comment.php');

//VARS
$var_page = "admin_comment";


//GET
$get_lang 			= ifsetor($_GET["lang"], "fr");
$get_action 		= ifsetor($_GET["action"], "view");
$get_comment_id		= ifsetor($_GET["comment_id"], "");
//var_dump($get_comment_id);//ok
$get_membre_id		= ifsetor($_GET["membre_id"], "");
$get_orderByMembre	= ifsetor($_GET["order_m"], "");
$get_orderByComment = ifsetor($_GET["order_c"], "");
//POST
$post_comment		= ifsetor($_POST["comment"], "");//txt
$post_field			= ifsetor($_POST["field"], "");
$post_user_data		= ifsetor($_POST["user_data"], "");
$post_is_visible 	= ifsetor($_POST["is_visible"], "");//txt
$post_submit		= ifsetor($_POST["submit"], "");

//CHECK
$is_empty_comment 		= "";
$is_empty_is_visible 	= "";

$display_error_comment 	= "";

$display_field_in_select = array(
	"commentaire"		=> "Commentaire",
	"pseudo"	 		=> "Pseudo",
	"pac_commentaires.date_add " 	=> "Date du post"
);

switch ($get_action) {
	case 'view':
	$display_comments	= getCommentList(0, $get_membre_id, $post_is_visible, $post_field, $post_user_data, $get_orderByMembre, $get_orderByComment);
	$page 				= "admin_comment";
	$action 			= "view";
	break;
	
	case 'add':
		// gestion via partie publique
		
	break;
	
	case 'update':
		if(!$post_comment){
			if(!$post_submit){
				
				$display_comments	= getCommentList($get_comment_id, 0, 0, 0, 0, 0, 0); //getCommentList($get_comment_id, 0, 0, $get_orderByMembre, $get_orderByComment);			
				//var_dump($display_comments);//ok
			}else{
				if(!$post_comment){
					$is_empty_comment 		.= " emptyField";
					$display_error_comment 	.= "Le texte indiqué n'est pas valide ou le champ est vide.";
				}
		
			}
		$page 				= "admin_comment";
		$action 			= "update";
		
		}else{
			
			$post_comment = htmlentities($post_comment, ENT_QUOTES, "utf-8");
					
			$upd_comment = updateComment($get_comment_id, $post_comment);
			
			if($upd_comment){
				$show_txt_page .= "<p>Commentaire modifié avec succès.</p>";

			}else{
				$show_txt_page .= "<p>Echec de la modification du commentaire. Contactez l'administrateur système.</p>";
			}
			$page 				= "admin_comment";	
			$get_action 		= "view";
			$display_comments	= getCommentList(0, 0, 0, 0, 0, 0, 0);
		}
		
		
		
	break;
		
	case 'delete':
		$del_comment = delreactiveComment($get_comment_id, "0");
		if($del_comment){
			$show_txt_page .= "<p>Suppression du commentaire efectuée avec succès. .</p>";
		}else{
			$show_txt_page .= "<p>Echec de la suppression du commentaire. Contactez l'administrateur système.</p>";
		}
		$page 				= "admin_comment";
		$get_action 		= "view";
		$display_comments	= getCommentList(0, 0, 0, 0, 0, 0, 0);
		
	break;
		
	case 'reactive':
		$reactive_comment 	= delreactiveComment($get_comment_id, "1");
		if($reactive_comment){
			$show_txt_page .= "<p>Réactivation du commentaire efectuée avec succès.</p>";
		}else{
			$show_txt_page .= "<p>Echec de la réactivation du commentaire. Contactez l'administrateur système.</p>";
		}
		$page 				= "admin_comment";
		$get_action 		= "view";
		$display_comments	= getCommentList(0, 0, 0, 0, 0, 0, 0);
		
		break;
}



?>