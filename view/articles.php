<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
<?php 

switch($get_action){
	
	case 'view':
?>

<!--//menu-->
<div id="blocMenuArt" class="setFloat_l menu">
	<ul id="menu_art" name="art_categ"><!--// name ?? $_GET ??-->
		
		<?php 
		
		if(is_array($display_art_section) && !empty($display_art_section)){
			foreach($display_art_section AS $das){
				$art_section_id = $das["article_section_id"];	
				$art_section_fr = $das["article_section_fr"];
		?>
		<li>
		<a href="?lang=<?php echo $get_lang?>&p=articles&action=view&id_sect=<?php echo $art_section_id;?>"><?php echo $art_section_fr; ?></a>
		<ul class="ss_menu">
		<?php
			if(is_array($display_cat_by_sec) && !empty($display_cat_by_sec)){
				foreach ($display_cat_by_sec AS $dcbs) {
					$art_section_id2 	= $dcbs["article_section_id"];
					$art_categ_id		= $dcbs["article_categ_id"];
					$art_categ_fr 		= $dcbs["article_categ_fr"];
					$art_categ_en 		= $dcbs["article_categ_en"];
					//$is_visible			= $dcbs["is_visible"];
					
					if($art_section_id2 == $art_section_id){
	
		?>
			<li>
				<a href="?lang=<?php echo $get_lang?>&p=articles&action=view&id_sect=<?php echo $art_section_id;?>&categ_id=<?php echo $art_categ_id;?>">
					&rarr; 
					<?php 
					echo $get_lang == "fr"?$art_categ_fr:$art_categ_en; 
					$nb_art_categ = getNbArtByCateg($get_lang, $art_categ_id);
					if(is_array($nb_art_categ) && !empty($nb_art_categ)){
						foreach ($nb_art_categ AS $nbac) {
							$nb_art_by_categ = $nbac["Art_by_categ"];
						}
						echo "(".$nb_art_by_categ.")";
					}
					
					?>
				</a>
			</li>
		<?php
					}
				}
			}	
				
		?>
		</ul>
		<?php
				
			}
		}
	
		?>
		</li>
	</ul>

</div>
	<div class="clearFloat"></div>
<!--//END #menu_art-->

<?php
	if(is_array($display_art_list) && !empty($display_art_list)){
		foreach($display_art_list AS $dal){
			$art_id				= $dal["article_id"];
			$art_auteur 		= $dal["pseudo"];
			$avatar				= $dal["avatar"];
			$art_date_dbt 		= dateUs2Fr($dal["date_debut"]);
			$art_titre			= $dal["article_titre"];
			$art_img_index		= $dal["img_index"];
			$art_short_desc		= html_entity_decode($dal["courte_description"], ENT_QUOTES, "utf-8");
			$art_desc			= html_entity_decode($dal["description"], ENT_QUOTES, "utf-8");
			$art_categ_fr		= $dal["article_categ_fr"];
			$art_categ_en		= $dal["article_categ_en"];
			$art_section_fr		= $dal["article_section_fr"];
			$art_section_en		= $dal["article_section_en"];

			
?>


	<div class="artHead">
		<img class="setFloat_l" src="<?php echo WWW_UP."avatar/resized_".$avatar;?>" alt="avatar"/>
		<p class="setFloat_l">
			
			<span><?php echo $get_lang == "fr"? "Auteur&nbsp;:&nbsp;": "Author&nbsp;:&nbsp;";?><?php echo $art_auteur;?></span><br />
			<span><?php echo $get_lang == "fr"? "Publié le&nbsp;:&nbsp;":"Posted on&nbsp;:&nbsp;";?><?php echo $art_date_dbt;?></span>
		</p>
		<p class="setFloat_r">
			<span>
<?php 
	$commentByArt 	= getCommentsByArt($art_id);
	//svar_dump($commentByArt);
	if(is_array($commentByArt) && !empty($commentByArt)){
			$art_nb_comment		= $commentByArt[0]["nbComment"];
?>
				
				<b><?php echo  $art_nb_comment;?></b>
				<?php echo $get_lang == "fr"? "commentaire":"comment";?><?php echo $art_nb_comment > 1 ? "s":""; ?>
			</span><br />
<?php 
		
	}else{
		$art_nb_comment		= "0";
?>
		<span>
			<b><?php echo  $art_nb_comment;?></b>
			<?php echo $get_lang == "fr"? "commentaire":"comment";?><?php echo $art_nb_comment > 1 ? "s":""; ?>
		</span><br />
<?php
	}

?>
			<span>
<?php 
$coteByArt 	= getCotationByArt($art_id);
if(is_array($coteByArt) && !empty($coteByArt)){
		foreach($coteByArt AS $cba){
			$art_cote  		= round($cba["coteMoy"],2,10);
			$art_nb_cote 	= $cba["nbVote"];
?>
				<b><?php echo isset($art_cote) && !empty($art_cote)?"Cote: ".$art_cote."/10 - ":"";?></b>
				<b><?php echo isset($art_nb_cote) && !empty($art_nb_cote)?$art_nb_cote:"0";?></b> vote<?php echo $art_nb_cote  > 1 ? "s":""; ?>
<?php 
		}
	}
?>
			</span>
		</p>
		<div class="clearFloat"></div>
	</div><!--END .artHead-->
	
	
	<div class="artContent">
		<!--//titre-->
		<h3>
			<a href="?lang=<?php echo $get_lang;?>&p=articles&action=detail&art_id=<?php echo $art_id;?>">
			<?php echo $art_titre;?>
			</a>
		</h3>
		
		<img class="setFloat_l" src="<?php echo WWW_UP."articles/thumb/thumb_".$art_img_index;?>" alt="img_index"/>
		
		<div><?php echo $art_short_desc;?></div>
		
		<div class="clearFloat"></div>
	</div>
	<p class="footerArt"><b>Section :</b> <?php echo $get_lang=="fr"? $art_section_fr:$art_section_en; ?> 
		- <b><?php echo $get_lang=="fr"?"Catégorie":"Category";?></b> <?php echo $get_lang=="fr"?$art_categ_fr:$art_categ_en;?></p>
	<hr class="hrSepar" />

<?php
		}
	}else{
		echo $get_lang == "fr"?"<p>&rarr;&nbsp;Désolé, aucun résultat ne correspond à votre recherche.</p>":"Sorry, no result found.";
	}
	break;//END cas view
					
	case 'detail':

	if(is_array($display_article) && !empty($display_article)){
		foreach($display_article AS $da){
			$art_auteur 		= $da["pseudo"];
			$avatar				= $da["avatar"];
			$art_date_dbt 		= dateUs2Fr($da["date_debut"]);
			$art_titre			= $da["article_titre"];
			$art_img_index		= $da["img_index"];
			$art_desc			= $da["description"];
		}
	}
				
	if(is_array($coteByArt) && !empty($coteByArt)){
		foreach($coteByArt AS $cba){
			$art_cote  		= round($cba["coteMoy"],2,10);
			$art_nb_cote 	= $cba["nbVote"];
		}
	}		
		
	if(is_array($commentByArt) && !empty($commentByArt)){
		foreach($commentByArt AS $comba){
			$art_nb_comment		= $comba["nbComment"];
		}
	}else{
		$art_nb_comment		= "0";
	}
			
?>
	<h4 class="setFloat_r">
		<a class="aTyp_1" href="?lang=<?php echo $get_lang;?>&p=articles&action=view">
			<b>--- <?php echo $get_lang == "fr" ? "Retour à la liste": "Back to the list"; ?> ---</b>
		</a>
	</h4>
	<div class="clearFloat"></div>
	
	<div class="artHead">
		<p class="setFloat_l">
			<img src="<?php echo WWW_UP."avatar/resized_".$avatar;?>" alt="avatar"/><br />
			<span><?php echo $get_lang == "fr"? "Auteur&nbsp;:&nbsp;": "Author&nbsp;:&nbsp;";?><?php echo $art_auteur;?></span><br />
			<span><?php echo $get_lang == "fr"? "Publié le&nbsp;:&nbsp;":"Posted on&nbsp;:&nbsp;";?><?php echo $art_date_dbt;?></span>
		</p>
		<p class="setFloat_r">
			<span>
				<a class="aTyp_1" href="#comments">
					<b><u><?php echo  $art_nb_comment;?></u></b>
				</a><?php echo $get_lang == "fr"? "commentaire":"comment";?><?php echo $art_nb_comment > 1 ? "s":""; ?></span><br />
			<span>
				<b><?php echo isset($art_cote) && !empty($art_cote)?"Cote: ".$art_cote."/10 - ":"";?></b>
				<b><?php echo isset($art_nb_cote) && !empty($art_nb_cote)?$art_nb_cote:"0";?></b> vote<?php echo $art_nb_cote  > 1 ? "s":""; ?>
			</span>
		</p>
		<div class="clearFloat"></div>
	</div><!--END artHead-->
	
	<div class="artContent">
		<h3><?php echo $art_titre;?></h3>
		<img class="setFloat_l" src="<?php echo WWW_UP."articles/resized/resized_".$art_img_index; ?>" alt="img_index"/>
		<div><?php echo html_entity_decode($art_desc, ENT_QUOTES, 'utf-8');?></div>
		<div class="clearFloat"></div>
	</div>
	<hr class="hrSepar" />
	
	<h3><?php echo $get_lang == "fr"? "Commentaires":"Comments";?></h3>
	<?php 
	if(is_array($commentByArt) && !empty($commentByArt)){
		foreach($commentByArt AS $comba){
			$art_comment_auteur = $comba["pseudo"];
			$art_comment_avatar	= $comba["avatar"];
			$art_comment		= html_entity_decode($comba["commentaire"]);
	
	?>
	<!--// Affichage des commentaires -->
	<div id="comments" class="artComments">
		<p class="setFloat_l artComInfos">
			<img src="<?php echo WWW_UP."avatar/resized_".$art_comment_avatar;?>" alt="avatar"/><br />
			<span><?php echo $art_comment_auteur;?></span><br />
			<?php echo $get_lang == "fr"? "à écrit :":"writed :"?>
		</p>
		<div class="setFloat_l blocTxtComment"><?php echo $art_comment;?></div>
		<div class="clearFloat"></div>
	</div>
	
	<?php
		}
	}else{
	?>
		<p id="comments"><?php echo $get_lang == "fr"? "Pas de commentaire sur cet article. :-(":"No comment on that article. :-("; ?></p>
	<?php
	}
	
if(isset($_SESSION["m_pseudo"]) && isset($_SESSION["m_statut"])){

?>
<!--Envoi de commentaires-->
<h3><?php echo $get_lang == "fr"? "Commentez cet article ! :" : "Comment on that article !"?></h3>
	<form action="?lang=<?php echo $get_lang; ?>&p=articles&action=send_comment&art_id=<?php echo $get_art_id;?>" method="POST">
		<!-- // Cotation de l'article -->
		<?php echo "<span class=\"dispErr\">$display_error_cote</span>"; ?>
		<label for="cotation"><?php echo $get_lang == "fr"? "Note attibuée : " : "Rating assigned : "; ?></label>
		<select name="art_cote" class="art_note<?php echo $is_empty_cote;?>" required="required">
			<option></option>
<?php 
		for($i=0, $c=10; $i<=$c;$i++){
?>
			<!--<option value="<?php echo $i; ?>" <?php echo isset($post_art_cote) && !empty($post_art_cote) && $post_art_cote == $i? " selected=selected" : ""; ?>>-- <?php echo $i; ?> --</option>-->
			<option value="<?php echo $i; ?>">-- <?php echo $i; ?> --</option>


<?php
			
		}
?>
		</select>
		<!--//Zone txt commentaire -->
		<?php echo "<span class=\"dispErr\">$display_error_comment</span>"; ?>
		<textarea class="editme<?php echo $is_empty_comment;?>" rows="10" name="art_comment" cols="120"><!--<?php echo isset($post_comment)&&!empty($post_comment)?$post_comment:"" ?>--></textarea><br />
		
		<p style="text-align: center;">
			<input id="comment_submit" type="submit" name="submit" value="<?php echo $get_lang == "fr"?"Envoyer mon commentaire":"Send my comment" ?>" />
		</p>
	</form>
<?php
}else{
?>
<h4>
<?php
	if($get_lang == "fr"){
?>
<p>Vous souhaitez laisser un commentaire ? 
	<a href='?&lang=<?php echo $get_lang;?>&p=index_forms&typ_form=new_register'>Inscrivez-vous vite !</a>
</p>
<?php	

	}else{
?>
<p>Do you want to post your comment ? 
	<a href='?&lang=<?php echo $get_lang;?>&p=index_forms&typ_form=new_register'>Sign up now !</a>
</p>
<?php
	}
}
			break;

	}//END $get_action
?>
	
	
	</div><!--END .mainBloc-->
</div><!--END #main_bloc_page-->