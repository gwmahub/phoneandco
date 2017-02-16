<h1>Visualisation de l'article</h1>
<?php 
if(is_array($display_article) && !empty($display_article)){
	foreach($display_article AS $da){
		$art_auteur 		= $da["pseudo"];
		$art_date_dbt 		= dateUs2Fr($da["date_debut"]);
		$art_titre			= html_entity_decode($da["article_titre"], ENT_QUOTES, "utf-8");
		$art_img_index		= $da["img_index"];
		$art_desc			= html_entity_decode($da["description"], ENT_QUOTES, "utf-8");
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
		$art_nb_comment	= $comba["nbComment"];
		
	}
	
}else{
	$art_nb_comment		= "0";
}
		
?>
<div class="artHead">
	<p class="setFloat_l">
		<span>Auteur&nbsp;:&nbsp; <?php echo $art_auteur;?></span><br />
		<span>Publié le&nbsp;:&nbsp; <?php echo $art_date_dbt;?></span>
	</p>
	<p class="setFloat_r">
		<span>
			<a class="aTyp_1" href="#comments">
				<b><u><?php echo  $art_nb_comment;?></u></b>
			</a> commentaire<?php echo $art_nb_comment > 1 ? "s":""; ?></span><br />
		<span>
			<b><?php echo isset($art_cote) && !empty($art_cote)?"Cote: ".$art_cote."/10 - ":"";?></b>
			<b><?php echo isset($art_nb_cote) && !empty($art_nb_cote)?$art_nb_cote:"0";?></b> vote<?php echo $art_nb_cote  > 1 ? "s":""; ?>
		</span>
	</p>
	<div class="clearFloat"></div>
</div>

<div class="artContent">
	<h3><?php echo $art_titre;?></h3>
	<img class="setFloat_l" src="<?php echo WWW_UP."articles/resized/resized_".$art_img_index; ?>" alt="img_index"/>
	<div><?php echo $art_desc;?></div>
	<div class="clearFloat"></div>
</div>
<hr class="hrSepar" />

<h3>Commentaires:</h3>
<?php 
if(is_array($commentByArt) && !empty($commentByArt)){
	foreach($commentByArt AS $comba){
		$art_comment		= html_entity_decode($comba["commentaire"], ENT_QUOTES, "utf-8");

?>

<div id="comments" class="artComments">
	<?php echo $art_comment;?>
</div>
<?php
	}
}else{
?>
	<p id="comments">Pas de commentaire sur cet article. :-(</p>
<?php
}
?>






