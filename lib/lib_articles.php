<?php

function getArticleList($lang, $article_id, $art_sect_id, $art_categ_id, $order){//ajouter param $art_section
	if(!is_numeric($article_id)){
		return false;
	}
	
	$sql = "SELECT ".DB_PREFIXE."article.article_id, img_index, ".DB_PREFIXE."article.date_add AS date_crea, ".DB_PREFIXE."article.langue, article_titre, courte_description, description, 
			".DB_PREFIXE."article.date_debut, ".DB_PREFIXE."article.date_fin, ".DB_PREFIXE."article.date_add, ".DB_PREFIXE."article.is_visible, 
			".DB_PREFIXE."article_categ.article_categ_id, article_categ_fr, article_categ_en, 
			article_section_fr, article_section_en, 
			pseudo, avatar
			
			FROM ".DB_PREFIXE."article
			
			LEFT JOIN ".DB_PREFIXE."article_categ_assoc ON ( ".DB_PREFIXE."article.article_id = ".DB_PREFIXE."article_categ_assoc.article_id)
			
			LEFT JOIN ".DB_PREFIXE."article_categ ON (".DB_PREFIXE."article_categ_assoc.article_categ_id = ".DB_PREFIXE."article_categ.article_categ_id)
			LEFT JOIN ".DB_PREFIXE."art_sec_categ_assoc ON (".DB_PREFIXE."article_categ.article_categ_id = ".DB_PREFIXE."art_sec_categ_assoc.article_categ_id)
			LEFT JOIN ".DB_PREFIXE."article_section ON (".DB_PREFIXE."art_sec_categ_assoc.article_section_id = ".DB_PREFIXE."article_section.article_section_id)
			
			LEFT JOIN ".DB_PREFIXE."membre_article ON (".DB_PREFIXE."article.article_id = ".DB_PREFIXE."membre_article.article_id)
			LEFT JOIN ".DB_PREFIXE."membre ON (".DB_PREFIXE."membre_article.membre_id = ".DB_PREFIXE."membre.membre_id)
			
			WHERE ".DB_PREFIXE."article.is_visible = '1'";

			if($lang != null){
				$sql .= " AND ".DB_PREFIXE."article.langue = '$lang'";
			}
		
			if($article_id != null){
				$sql .= " AND ".DB_PREFIXE."article.article_id = $article_id ";
			}
			
			if($art_sect_id != null){
				$sql .= "AND ".DB_PREFIXE."article_section.article_section_id = $art_sect_id";
			}
			
			if($art_categ_id != null){
					$sql .= " AND ".DB_PREFIXE."article_categ.article_categ_id = $art_categ_id";
			}
			
			$sql .= " AND (`date_debut` <= NOW()) AND (`date_fin` >= NOW())";
			
			$sql .= " GROUP BY ".DB_PREFIXE."article.article_id";
		
			//if($order != null){
				$sql .= " ORDER BY ".DB_PREFIXE."article.date_debut $order";
			//}
			
	//echo $sql;
	
	return ($art_list = requeteResultat($sql))?$art_list:false;
}

function getArtSect($art_sect_id, $is_visible, $order){
	if(!is_numeric($art_sect_id)){
		return false;
	}
	
	$sql = "SELECT `article_section_id`, `article_section_fr`, `article_section_en`, `is_visible` 
			FROM `" .DB_PREFIXE . "article_section` ";
	
	if($art_sect_id != NULL){
		$sql .= " WHERE `article_section_id` = $art_sect_id ";
		
		if($is_visible != NULL  ){
			$sql .= " AND `is_visible` = '$is_visible'";	
		}
	}
	
	if($is_visible != NULL  ){
			$sql .= " WHERE `is_visible` = '$is_visible'";	
		}
	
	if($order != null){
		$sql .= " ORDER BY article_section_fr $order";
	}

	//echo $sql;
	return requeteResultat($sql);
}

//affichage des catégories par section -> menu
function displayCategBySection($_art_section, $art_categ){
	
	$sql = "SELECT ".DB_PREFIXE."article_section.article_section_id, ".DB_PREFIXE."article_section.article_section_fr, ".DB_PREFIXE."article_section.article_section_en, ".DB_PREFIXE."article_categ.article_categ_id, 
			article_categ_fr, article_categ_en
			FROM ".DB_PREFIXE."article_section
			INNER JOIN ".DB_PREFIXE."art_sec_categ_assoc ON (".DB_PREFIXE."article_section.article_section_id = ".DB_PREFIXE."art_sec_categ_assoc.article_section_id )
			INNER JOIN ".DB_PREFIXE."article_categ ON (".DB_PREFIXE."art_sec_categ_assoc.article_categ_id = ".DB_PREFIXE."article_categ.article_categ_id )
			";
			
	if($_art_section != null){
		$sql  .= " WHERE ".DB_PREFIXE."article_section.article_section_fr = $_art_section";
	}
	
	if($art_categ != null){
		$sql  .= " AND ".DB_PREFIXE."article_categ.article_categ_fr = $art_categ";
	}
	
	$sql .= " ORDER BY ".DB_PREFIXE."article_section.article_section_id ASC";
	
	//echo $sql;
	$categBySect = requeteResultat($sql);
	
	return $categBySect;
	
}
/*Affiche le nombre d'article en ligne une catégorie définie -> menu*/
function getNbArtByCateg($lang, $categ_id){
	if(!is_numeric($categ_id)){
		return false;
	}
	
	$sql_nb_art_categ = "SELECT COUNT(pac_article_categ_assoc.article_id) Art_by_categ, article_titre FROM pac_article_categ_assoc
						INNER JOIN pac_article ON (pac_article_categ_assoc.article_id = pac_article.article_id)
						WHERE article_categ_id = $categ_id
						AND pac_article.is_visible = '1'
						AND (`date_debut` <= NOW()) AND (`date_fin` >= NOW())
						AND pac_article.langue = '$lang'";
	
	//echo $sql_nb_art_categ;
							
	return requeteResultat($sql_nb_art_categ);
	
}


function getCotationByArt($art_id){
	if(!is_numeric($art_id)){
		return false;
	}
	
	$sql = "SELECT (SUM(cote)/COUNT(cote)) AS coteMoy, (COUNT(cote)) AS nbVote  
			FROM ".DB_PREFIXE."article_cotation 
			WHERE article_id = $art_id";
			
	//echo "<br />".$sql;
	
	$cote = requeteResultat($sql);
	
	return $cote;
}

function getCommentsByArt($art_id){
	if(!is_numeric($art_id)){
		return false;
	}
	
	$sql = "SELECT commentaire, (SELECT COUNT(commentaire_id) FROM ".DB_PREFIXE."article_comment WHERE article_id = $art_id) AS nbComment, avatar, pseudo
			FROM ".DB_PREFIXE."commentaires 
			LEFT JOIN ".DB_PREFIXE."article_comment ON  (".DB_PREFIXE."commentaires.commentaire_id = ".DB_PREFIXE."article_comment.commentaire_id)
			LEFT JOIN ".DB_PREFIXE."membre_comment ON (".DB_PREFIXE."commentaires.commentaire_id = ".DB_PREFIXE."membre_comment.commentaire_id)
			LEFT JOIN ".DB_PREFIXE."membre ON (".DB_PREFIXE."membre_comment.membre_id = ".DB_PREFIXE."membre.membre_id)
			WHERE ".DB_PREFIXE."article_comment.article_id = $art_id";
	
	//echo "<p>".$sql."</p>";
	
	$article_comments = requeteResultat($sql);
	
	return $article_comments; 
}

/**
 * @param $auteur_id = $_SESSION["membre"]
 * @param $article_id = $get_art_id
 * @param $comment = contenu txt 
 * */

function insertMyComment($comment){
	$comment	= convert2DB($comment);
	$sql_comment = " INSERT INTO  ".DB_PREFIXE."commentaires (`commentaire`, `is_visible`, `date_add`)
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
function insertArticleComment($art_id, $comment_id){
	if(!is_numeric($art_id) || !is_numeric($comment_id)){
		return false;
	}
	$art_id 		= convert2DB($art_id);
	$comment_id		= convert2DB($comment_id);
	
	$sql_art_comment 	= " INSERT INTO ".DB_PREFIXE."article_comment (`article_id`,`commentaire_id`)
							VALUES ('$art_id','$comment_id')";
	
	$exec_sql_art_comment		= ExecRequete($sql_art_comment);
	
	if($exec_sql_art_comment){
		return true;
	}else{
		return false;
	}
}

function insertArtCote($art_id, $membre_id, $cote){
	if(!is_numeric($art_id)){
		return false;
	}
	
	$sql_art_cote = " INSERT INTO ".DB_PREFIXE."article_cotation (`article_id`,`membre_id`, `cote`)
			VALUES ('$art_id','$membre_id','$cote')";
	
	//echo $sql_art_cote;
	
	if($sql_art_cote = ExecRequete($sql_art_cote)){
		return true;
	}else{
		return false;
	} 
}

?>