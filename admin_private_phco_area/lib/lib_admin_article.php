<?php

include_once(PATH_LIBS."lib_admin_article_section.php");

function getArticleList($article_id, $art_categ, $is_visible, $order){//MEMO: $groupby=1 à tester si probl de stats (COUNT...SUM)
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
			";

		if($is_visible != null){
			$sql .= " WHERE ".DB_PREFIXE."article.is_visible = '$is_visible'";
		}
		
		if($article_id != null){
			$sql .= " WHERE ".DB_PREFIXE."article.article_id = $article_id ";
			if($art_categ != null){
				$sql .= "AND ".DB_PREFIXE."article_categ.article_categ_id = $art_categ";
			}
		}
		
		$sql .= " GROUP BY ".DB_PREFIXE."article.article_id";
		
		if($order != null){
			$sql .= " ORDER BY ".DB_PREFIXE."article.date_debut $order";
		}
		
	//echo $sql;
	
	$art_list = requeteResultat($sql);

	return $art_list;
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

function getCategsByArt($art_id){
	if(!is_numeric($art_id)){
		return false;
	}
	
	$sql = "SELECT ".DB_PREFIXE."article_categ.article_categ_id, article_categ_fr, article_categ_en, pac_article_categ.is_visible, article_id
			FROM ".DB_PREFIXE."article_categ
			INNER JOIN ".DB_PREFIXE."article_categ_assoc ON (".DB_PREFIXE."article_categ.article_categ_id = ".DB_PREFIXE."article_categ_assoc.article_categ_id)
			WHERE ".DB_PREFIXE."article_categ_assoc.article_id = $art_id";
	
	$categs_by_art = requeteResultat($sql);
	
	return $categs_by_art;
}

/**
 * @param $_publi 		= is_visible -> publié ou non
 * @param $_section 	= section
 * @param $_categ 		= catégorie
 * @param $_field_db	= champ de la table article
 * @param $_searchBy 	= filtre "contient" "commence par" ou "égal"
 * @param $user_data 	= saisie de l'utilisateur
*/

function engineArticle($_publi, $_section, $_categ, $_field_db, $_searchBy, $user_data, $order, $limit){
			
		
	$sql = "SELECT ".DB_PREFIXE."article.article_id, img_index, ".DB_PREFIXE."article.date_add AS date_crea, ".DB_PREFIXE."article.langue, article_titre, courte_description, description, 
			".DB_PREFIXE."article.date_debut, ".DB_PREFIXE."article.date_fin, ".DB_PREFIXE."article.is_visible, 
			article_categ_fr, article_categ_en, article_section_fr,	article_section_en, pseudo, avatar, commentaire, nbre_votes, total_points, 
			".DB_PREFIXE."commentaires.date_add
			
			FROM ".DB_PREFIXE."article
			
			LEFT JOIN ".DB_PREFIXE."article_categ_assoc ON ( ".DB_PREFIXE."article.article_id = ".DB_PREFIXE."article_categ_assoc.article_id)
			
			LEFT JOIN ".DB_PREFIXE."article_categ ON (".DB_PREFIXE."article_categ_assoc.article_categ_id = ".DB_PREFIXE."article_categ.article_categ_id)
			LEFT JOIN ".DB_PREFIXE."art_sec_categ_assoc ON (".DB_PREFIXE."article_categ.article_categ_id = ".DB_PREFIXE."art_sec_categ_assoc.article_categ_id)
			LEFT JOIN ".DB_PREFIXE."article_section ON (".DB_PREFIXE."art_sec_categ_assoc.article_section_id = ".DB_PREFIXE."article_section.article_section_id)
			LEFT JOIN ".DB_PREFIXE."membre_article ON (".DB_PREFIXE."article.article_id = ".DB_PREFIXE."membre_article.article_id)
			LEFT JOIN ".DB_PREFIXE."membre ON (".DB_PREFIXE."membre_article.membre_id = ".DB_PREFIXE."membre.membre_id)
			
			LEFT JOIN ".DB_PREFIXE."article_cotation ON  (".DB_PREFIXE."membre.membre_id = ".DB_PREFIXE."article_cotation.membre_id)
			
			LEFT JOIN ".DB_PREFIXE."membre_comment ON (".DB_PREFIXE."article_cotation.membre_id = ".DB_PREFIXE."membre_comment.membre_id)
			LEFT JOIN ".DB_PREFIXE."commentaires ON (".DB_PREFIXE."membre_comment.commentaire_id = ".DB_PREFIXE."commentaires.commentaire_id)
			LEFT JOIN ".DB_PREFIXE."article_comment ON ( ".DB_PREFIXE."commentaires.commentaire_id = ".DB_PREFIXE."article_comment.commentaire_id)
			";

		//echo $sql;
		/*			
			WHERE article_section_fr LIKE '%internet%'
			AND article_categ_fr LIKE '%buzz%'
			AND pac_article.date_debut > 2013-10-19
			AND article_titre LIKE '%selfie%'
		 */
	
	$art_found = requeteResultat($sql);
	
	return $art_found;
}

//affichage des catégories par section dans le add
function displayCategBySection($_art_section, $art_categ){
	
	$sql = "SELECT ".DB_PREFIXE."article_section.article_section_id, ".DB_PREFIXE."article_section.article_section_fr, ".DB_PREFIXE."article_categ.article_categ_id, article_categ_fr
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

/**
 * @param $is_visible -> publié ou non
 * */
function insertArticle($lang, $img_index, $title, $short_desc, $desc, $is_visible, $d_online, $d_end){
	$lang 			= convert2DB($lang);
	$d_online 		= dateFr2Us($d_online);
	$d_end 			= dateFr2Us($d_end);
	$title 			= convert2DB($title);
	$img_index 		= convert2DB($img_index);
	$short_desc 	= convert2DB($short_desc);
	$desc 			= convert2DB($desc);
	$is_visible 	= convert2DB($is_visible);
	
	$sql = "INSERT INTO ".DB_PREFIXE."article (langue, img_index, article_titre, courte_description, description, is_visible, date_debut, date_fin, date_add)
			VALUES
			('$lang', '$img_index', '$title', '$short_desc', '$desc', '$is_visible', '$d_online', '$d_end', NOW());
			";
	$new_article = ExecRequete($sql);
	return $new_article ? TRUE : FALSE;
}

/**
 * @param $art_categ_tab -> tableau des id des catégories sélectionnées -> insertion ds table article_categ_assoc
 * */
function insertCategByArt($art_id, $art_categ_tab){
	if(!is_numeric($art_id)){
		return false;
	}
	if(is_array($art_categ_tab) && $art_categ_tab != null){
		foreach($art_categ_tab AS $catId){
		$catId = convert2DB($catId);
		$sql = "INSERT INTO " .DB_PREFIXE ."article_categ_assoc (article_id, article_categ_id) 
				VALUES ('$art_id', '$catId')";
		ExecRequete($sql);
		//echo $sql."<br />";
		}
		return true;
	}else{
		return false;
	}
}


/**Insertion dans la table MEMBRE_ARTICLE
 * @param $author_id -> $_SESSION
 * @param $art_id -> id récupéré après insertion de l'article ds la table article
 */
function insertAuthorByArt($membre_id, $art_id){ //$author_id
	if(!is_numeric($membre_id) || !is_numeric($art_id)){
		return false;
	}
	
	$sql = "INSERT INTO " .DB_PREFIXE ."membre_article (membre_id, article_id) 
			VALUES ('$membre_id', '$art_id')";
	//echo $sql;
	return ExecRequete($sql) ? TRUE : FALSE;
}

function updateArticle($art_id, $lang, $img_index, $title, $short_desc, $desc, $is_visible, $d_publi, $d_expi){
	if(!is_numeric($art_id)){
		return false;
	}
	$art_id 		= convert2DB($art_id);
	$lang 			= convert2DB($lang);
	$img_index 		= convert2DB($img_index);
	$title 			= convert2DB($title);
	$short_desc 	= convert2DB($short_desc);
	$desc 			= convert2DB($desc);
	$is_visible 	= convert2DB($is_visible);
	$d_publi 		= convert2DB(dateFr2Us($d_publi));
	$d_expi 		= convert2DB(dateFr2Us($d_expi));
	
	$sql = "UPDATE ".DB_PREFIXE."article 
			
			SET
			
			langue 				= '$lang',
			img_index 			= '$img_index',
			article_titre 		= '$title',
			courte_description 	= '$short_desc',
			description 		= '$desc',
			is_visible 			= '$is_visible',
			date_debut 			= '$d_publi',
			date_fin 			= '$d_expi'
			
			WHERE article_id = $art_id
			";
	//echo $sql;
	return ExecRequete($sql) ? TRUE:FALSE;
}

//A compléter -> mise à jour des catégories associées
function updCategByArt($art_id, $art_categ_tab){}




function delReactiveArticle($article_id, $is_visible){
	if(!is_numeric($article_id)){
		return false;
	}
	
	$is_visible = convert2DB($is_visible);
	
	$sql = "UPDATE ".DB_PREFIXE."article  
            SET 
            is_visible = '$is_visible' 
            WHERE article_id = $article_id
            ";
            
        //echo $sql;
        return ExecRequete($sql) ? true : false;
}

?>