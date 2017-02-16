<?php
//ajouter $acc_id
function getCommentList($comment_id, $member_id, $is_visible, $field, $user_data, $orderByMembre, $orderByComment){
	if(!is_numeric($comment_id)){
		return false;
	}
	
	$sql = "SELECT " .DB_PREFIXE ."commentaires.commentaire_id, commentaire, " .DB_PREFIXE ."commentaires.is_visible AS is_visible_comment, 
					" .DB_PREFIXE ."commentaires.date_add AS comment_date_add, 

			 " .DB_PREFIXE ."membre.membre_id, prenom, nom, pseudo, email, " .DB_PREFIXE ."membre.is_visible, actif,

			 " .DB_PREFIXE ."article.article_id, article_titre,
			
			 " .DB_PREFIXE ."appareil.ap_id, ap_titre_fr, ap_titre_en, " .DB_PREFIXE ."appareil.is_visible
			
			FROM " .DB_PREFIXE ."commentaires
			
			LEFT JOIN " .DB_PREFIXE ."membre_comment ON (" .DB_PREFIXE ."commentaires.commentaire_id = " .DB_PREFIXE ."membre_comment.commentaire_id)
			LEFT JOIN " .DB_PREFIXE ."membre ON (" .DB_PREFIXE ."membre_comment.membre_id = " .DB_PREFIXE ."membre.membre_id)
			LEFT JOIN " .DB_PREFIXE ."article_comment ON ( " .DB_PREFIXE ."article_comment.commentaire_id = " .DB_PREFIXE ."commentaires.commentaire_id)
			LEFT JOIN " .DB_PREFIXE ."article ON ( " .DB_PREFIXE ."article_comment.article_id = " .DB_PREFIXE ."article.article_id)
			LEFT JOIN " .DB_PREFIXE ."appareil_comment ON ( " .DB_PREFIXE ."appareil_comment.commentaire_id = " .DB_PREFIXE ."commentaires.commentaire_id)
			LEFT JOIN " .DB_PREFIXE ."appareil ON ( " .DB_PREFIXE ."appareil_comment.ap_id = " .DB_PREFIXE ."appareil.ap_id)
		";
	
	if($comment_id != null){
		$sql .= " WHERE " .DB_PREFIXE ."commentaires.commentaire_id = '$comment_id' ";
	}
	
	if($is_visible != null && $field == null && $user_data == null && $ap_id == null){
		$sql .= " WHERE ".DB_PREFIXE."commentaires.is_visible = '$is_visible'";
	}
	
	if($is_visible != null && $field != null && $user_data != null){
		$sql .= " WHERE ".DB_PREFIXE."commentaires.is_visible = '$is_visible' AND $field LIKE '%$user_data%'"; 	 
	}
	
	if($is_visible == null && $field != null && $user_data != null){
		$sql .= " WHERE $field LIKE '%$user_data%'";
	}

	if(($is_visible == null  || $is_visible != null)  && $field == null && $user_data != null){//$is_visible < 2 ?
		$sql .= " WHERE commentaire 	LIKE '%$user_data%'
				  OR pseudo		 		LIKE '%$user_data%'
				  OR comment_date_add	LIKE '%$user_data%'
				";
	}
	
	if($orderByMembre != null){//test avec 1 à la place de zero
		$sql .= " ORDER BY  " .DB_PREFIXE ."membre.pseudo ASC";
		
	}elseif($orderByComment != null){
		$sql .= " ORDER BY  " .DB_PREFIXE ."commentaires.commentaire_id DESC";
	}
	
	//echo $sql."<br /><br />";
	$r = requeteResultat($sql);
	return $r?$r:false;
	
}
//pour insertion ultérieure -> !! param mbre + ap + art + ... 
function insertMyComment($comment){
	$comment		= convert2DB($comment);
	$sql_comment 	= " INSERT INTO  ".DB_PREFIXE."commentaires (`commentaire`, `is_visible`, `date_add`)
					VALUES ('$comment', '1',NOW())";
	
	$exec_sql_comment = ExecRequete($sql_comment);
	
	if(!$exec_sql_comment){
		return false;
	}else{
		return true;
	}
}

function insertMembreComment($membre_id, $comment_id){
	if(!is_numeric($membre_id) || !is_numeric($comment_id)){
		return false;
	}
	$membre_id 	= convert2DB($membre_id);
	$comment_id	= convert2DB($comment_id);
	
	$sql_membre_comment = " INSERT INTO ".DB_PREFIXE."membre_comment (`membre_id`,`commentaire_id`)
							VALUES ('$membre_id','$comment_id')";
							
	$exec_sql_membre_comment 	= ExecRequete($sql_membre_comment);
	if($exec_sql_membre_comment){
		return true;
	}else{
		return false;
	}
	
}

function updateComment($comment_id, $commentaire){
	if(!is_numeric($comment_id)){
		return false;
	}
	$commentaire = convert2DB($commentaire);
	
	$sql = "UPDATE " .DB_PREFIXE ."commentaires
			SET
			commentaire = '$commentaire'
			
			WHERE " .DB_PREFIXE ."commentaires.commentaire_id = '$comment_id'
		";
		
	return ExecRequete($sql)?true:false;
}

function delreactiveComment($comment_id, $is_visible){
	if(!is_numeric($comment_id)){
		return false;
	}
	
	$sql = "UPDATE " .DB_PREFIXE ."commentaires
			SET
			is_visible = '$is_visible'
			
			WHERE " .DB_PREFIXE ."commentaires.commentaire_id = '$comment_id'	
		";
		
	//echo $sql;
		
	return ExecRequete($sql)?true:false;
}


?>