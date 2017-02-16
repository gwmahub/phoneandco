<?php
    //phpinfo();
?>
<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

switch($get_action){
	case 'view':
?>
<h1>--- Gestion des articles ---</h1>
<!--//ADD-->
<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title="add a new article">
			        <img src="<?php echo WWW_IMG ?>add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter un nouvel article</h4>
			    </a>
			</td>
		</tr>
	</table>
	<hr class='hrSepar'/>
<!--//END ADD-->

<div class=""></div>

<table id="tab_list">
	<tbody>
		<tr> <!--10 champs-->
			<th class="td_action">Action</th>
			<th>Date<br />créa.</th	>
			<th>Lg</th>
			<th>Img<br />index</th>
			<th>Titre</th>
			<th>Auteur</th>
			<th>Section</th>
			<th>Date <br />début</th>
			<th>Date <br />fin</th>
			<th>Publié</th>
			<th>Visu</th>
			
		</tr>
<?php 
		if(is_array($display_articles) && !empty($display_articles)){
			foreach($display_articles AS $da){
				$art_id 			= $da["article_id"];
				$art_categ_id		= $da["article_categ_id"];
				$art_date_crea 		= dateUs2Fr($da["date_crea"]);
				$art_lang 			= $da["langue"];
				$art_img_index 		= $da["img_index"];
				$art_titre 			= $da["article_titre"]; 
				$art_auteur 		= $da["pseudo"]; 
				$art_categ_fr 		= $da["article_categ_fr"];
				$art_section_fr 	= $da["article_section_fr"];
				$art_date_dbt 		= dateUs2Fr($da["date_debut"]);
				$art_date_fin 		= dateUs2Fr($da["date_fin"]);
				$art_is_visible 	= $da["is_visible"];
		
?>
		<tr>
			<td class="td_action">
<?php 
				if($art_is_visible == 1){
?>
				<!--//DELETE-->
				<a href=index.php?p=<?php echo $var_page; ?>&action=delete&art_id=<?php echo $art_id;?> title="delete an article">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='del.jpg' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href=?p=<?php echo $var_page; ?>&action=update&art_id=<?php echo $art_id;?> title="update an article">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="edit.jpg" />
				</a>
<?php
			}else{
?>
				<!--//REACTIVE-->
				<a href=index.php?p=<?php echo $var_page; ?>&action=reactive&art_id=<?php echo $art_id;?> title="reactive an article">
			        <img src="<?php echo WWW_IMG ?>reactivate.jpg" alt='reactive.jpg' class=''/>
			    </a>
<?php
				}
?>
				
			</td>
			<td align="center"><?php echo $art_date_crea; ?></td>
			<td class="td_lg" align="center"><b><?php echo $art_lang; ?></b></td>
			<td align="center"><img src="<?php echo WWW_UP."articles/thumb/thumb_".$art_img_index; ?>"  alt="img"/></td>
			<td><a class="aTyp_2" href="index.php?p=<?php echo $var_page; ?>&action=detail&art_id=<?php echo $art_id;?>&art_categ=<?php echo $art_categ_id;?>">
				<?php echo $art_titre; ?>
				</a>
			</td>
			<td><?php echo $art_auteur; ?></td>
			<td><?php echo empty($art_section_fr)? "<b style='color: red;'>Pas de section associée</b>": $art_section_fr;?></td>
			<td align="center"><?php echo $art_date_dbt; ?></td>
			<td align="center"><?php echo $art_date_fin; ?></td>
			<td align="center"><?php echo $art_is_visible == "1"? "<span style='color: green;'><b>V</b></span>":"<span style='color: red;'><b>X</b></span>"; ?></td>
			<td align="center">
				<a href="index.php?p=<?php echo $var_page; ?>&action=detail&art_id=<?php echo $art_id;?>&art_categ=<?php echo $art_categ_id;?>">
					<img title="visu" src="<?php echo WWW_IMG . "icon_eye.gif";?>" alt="Visu" />
				</a>
			</td>
		</tr>
<?php
	}//END foreach
}
?>
	</tbody>
</table>

<?php 
	break;//END case view
	
	//visualisation de l'article
	case 'detail':
	include_once(PATH_VIEW."admin_article_detail.php");
	
	break;
		
	case 'add';
	//if($display_form){

?>
<h1>Ajouter un article</h1>
<form action=?p=<?php echo $var_page;?>&action=<?php echo $get_action; ?> method="POST" lang="en" enctype="multipart/form-data">
	<div class="bloc_form_1">
		<p>
			<label class="labelTyp_1" for="date de modification">Date de création : </label>
			<input class="" type="text" value="<?php echo date("d/m/y"); ?>" style="text-align: right; padding-right: 5px;" disabled="disabled" />
		</p>
	
		<p>
			<label class="labelTyp_1" for="lang">Langue&nbsp;:&nbsp;</label>
			<input type='radio' name='lang' value='fr' checked='checked' <?php echo isset($post_lg) && ($post_lg = "fr")? "checked='checked'" : ""; ?> /> FR
			<input type='radio' name='lang' value='en' <?php echo isset($post_lg) && ($post_lg = "en")? "checked='checked'" : ""; ?> /> EN
		</p>
		<p>
			<b>Publication:</b><br />
			<label class="labelTyp_1" for="Du">Du : </label>
			<input class="tcal <?php echo $is_empty_d_publi;?>" type="text" name="d_publi" value="<?php echo isset($post_d_publi) && !empty($post_d_publi)?$post_d_publi:""; ?>" required="required" />
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_d_publi</span>"; ?>
			
			<label class="labelTyp_1" for="Au">Au : </label>
			<input class="tcal <?php echo $is_empty_d_expi;?>" type="text" name="d_expi" value="<?php echo isset($post_d_expi) && !empty($post_d_expi)?$post_d_expi:""; ?>" required="required"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_d_expi</span>"; ?>
		</p>
		<p>
			<label class="labelTyp_1" for="titre">Titre : </label>
			<input class="inputTyp_1 <?php echo $is_empty_titre;?>" type="text" name="art_titre" 
			value="<?php echo isset($post_art_titre) && !empty($post_art_titre)?$post_art_titre:""; ?>" required="required"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_art_titre</span>"; ?>
		</p>
		<p>
			<label for="image index">Image index :</label>
			<input type="file" name="src_fichier" /><br /><span style="font-size: smaller">(JPG - GIF or PNG only )</span>
			<?php echo "<span class=\"dispErr\">$display_error_img_index</span>"; ?>
		</p>
		
		
	</div><!--END .bloc_form_1-->
	<div class="bloc_form_2">
		<label class="labelTyp_1" for="catégorie">Catégorie :</label>
		<p>
			<?php echo "<span class=\"dispErr\">$display_error_art_categ</span>"; ?>
						
			<select multiple="multiple" class="selectMulti <?php echo $is_empty_art_categ;?>" name="art_categ[]" required="required">
				<option></option>
				<?php 
				
				if(is_array($display_art_section) && !empty($display_art_section)){
					foreach($display_art_section AS $das){
						$art_section_id = $das["article_section_id"];	
						$art_section_fr = $das["article_section_fr"];
				?>
				<optgroup label="<?php echo  $art_section_fr;?>">
				<?php
					if(is_array($display_cat_by_sec) && !empty($display_cat_by_sec)){
						foreach ($display_cat_by_sec AS $dcbs) {
							$art_section_id2 	= $dcbs["article_section_id"];
							$art_categ_id		= $dcbs["article_categ_id"];
							$art_categ_fr 		= $dcbs["article_categ_fr"];
							$is_visible			= $dcbs["is_visible"];
							
							if($art_section_id2 == $art_section_id){

				?>
					<option value='<?php echo $art_categ_id; ?>'<?php if(isset($post_art_categ) && !empty($post_art_categ)){echo in_array($art_categ_id, $post_art_categ)?" selected=selected": "";} ?>'>
						&rarr; <?php echo $art_categ_fr; ?>
					</option>
				<?php
							}
						}
					}	
						
				?>
				</optgroup>
				<?php
						
					}
				}

				?>
			</select>
			<span class="reqField">*</span>	
		</p>
		
		
		<label for="courte description">Courte description :</label>
		<textarea class="txtAreaTyp_1 <?php echo $is_empty_art_short_desc;?>" name="art_short_desc" required="required"><?php echo isset($post_art_short_desc) && !empty($post_art_short_desc)?$post_art_short_desc: ""; ?></textarea>
		<span class="reqField">*</span><br />
	</div>
	
	<div class="bloc_form_3">
		<?php echo "<span class=\"dispErr\">$display_error_art_desc</span>"; ?>
		<textarea class="ckeditor <?php echo $is_empty_art_desc ;?>" cols="80" id="art_desc" name="art_desc" rows="10" required="required"><?php echo isset($post_art_desc) && !empty($post_art_desc)?$post_art_desc: ""; ?></textarea>
	</div>
	
	<div class="clearFloat"></div>
	
	<p style="text-align: center; ">
		<label for="Publier"><b>Publier ?</b></label>
		<input type="checkbox" name="is_visible" value="1" <?php echo (isset($post_is_visible) && !empty($post_is_visible)?"checked=checked":"") ;?>/><br />
		<?php echo $display_error_is_visible; ?>
		
		<input id="submitTyp_2" type="submit" name="submit" value="ENVOYER" />
	</p>
</form>
<?php
	//}//END if(display_form)
	break;
	
	case 'update':
		
	if($display_form){
		$display_the_article = getArticleList($get_art_id, 0, 0, "DESC");
		if(is_array($display_the_article) && !empty($display_the_article)){
			foreach ($display_the_article AS $dta) {
				$art_id 			= $dta["article_id"];
				$art_lang 			= $dta["langue"];
				$art_img_index 		= $dta["img_index"];
				$art_titre 			= $dta["article_titre"];
				$art_short_desc 	= $dta["courte_description"];
				$art_desc 			= $dta["description"];
				$art_visible 		= $dta["is_visible"];
				$art_d_publi 		= dateUs2Fr($dta["date_debut"]);
				$art_d_expi 		= dateUs2Fr($dta["date_fin"]);
				$art_d_crea 		= dateUs2Fr($dta["date_add"]);
			}
		}


?>
<h1>Modifier un article</h1>
<form action="?p=<?php echo $var_page;?>&action=<?php echo $get_action; ?>&art_id=<?php echo $get_art_id;?>" method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">
		<p>
			<label class="labelTyp_1" for="date de modification">Date de création : </label>
			<input class="" type="text" value="<?php echo $art_d_crea; ?>" style="text-align: right; padding-right: 5px;" disabled="disabled" />
		</p>
	
		<p>
			<label class="labelTyp_1" for="lang">Langue&nbsp;:&nbsp;</label>
			<input type="radio" name="lang" value="fr" <?php echo (isset($post_lg) && ($post_lg = "fr")) || $art_lang == "fr" ? "checked='checked'" : ""; ?> /> FR
			<input type="radio" name="lang" value="en" <?php echo (isset($post_lg) && ($post_lg = "en"))  || $art_lang == "en" ? "checked='checked'" : ""; ?> /> EN
		</p>
		<p>
			<b>Publication:</b><br />
			<label class="labelTyp_1" for="Du">Du : </label>
			<input class="tcal <?php echo $is_empty_d_publi;?>" type="text" name="d_publi" value="<?php echo isset($post_d_publi) && !empty($post_d_publi)?$post_d_publi:$art_d_publi; ?>" required="required" />
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_d_publi</span>"; ?>
			
			<label class="labelTyp_1" for="Au">Au : </label>
			<input class="tcal <?php echo $is_empty_d_expi;?>" type="text" name="d_expi" value="<?php echo isset($post_d_expi) && !empty($post_d_expi)?$post_d_expi:$art_d_expi; ?>" required="required"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_d_expi</span>"; ?>
		</p>
		<p>
			<label class="labelTyp_1" for="titre">Titre : </label>
			<input class="inputTyp_1 <?php echo $is_empty_titre;?>" type="text" name="art_titre" required="required"
			value="<?php echo isset($post_art_titre) && !empty($post_art_titre)?$post_art_titre:$art_titre; ?>"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_art_titre</span>"; ?>
		</p>

	</div><!--END .bloc_form_1-->
	<div class="bloc_form_2">
	<p> 
		<!--//Affichage de l'ancienne image-->
		<img src="<?php echo WWW_UP."articles/thumb/thumb_".$art_img_index; ?>" alt="img"/><br />
		<?php echo "<span class=\"dispErr\">$display_error_img_index</span>"; ?>
		<label for="image index">Image index :</label>
		<input type="file" name="src_fichier" /><br />
		
		<span style="font-size: smaller">(JPG - GIF or PNG only )</span>
		
		<input type="hidden" name="img_index_old" value="<?php echo $art_img_index ;?>"/>
	</p>
		<label for="courte description">Courte description :</label>
		<textarea class="txtAreaTyp_1 <?php echo $is_empty_art_short_desc;?>" name="art_short_desc" required="required"><?php echo isset($post_art_short_desc) && !empty($post_art_short_desc)?$post_art_short_desc: $art_short_desc; ?></textarea>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_art_short_desc</span>"; ?>
	</div>
	
	<div class="bloc_form_3">
		<textarea class="ckeditor <?php echo $is_empty_art_desc ;?>" cols="80" id="art_desc" name="art_desc" rows="10" required="required"><?php echo isset($post_art_desc) && !empty($post_art_desc)?$post_art_desc: $art_desc; ?></textarea>
		<?php echo "<span class=\"dispErr\">$display_error_art_desc</span>"; ?>
	</div>
	
	<div class="clearFloat"></div>
	
	<p style="text-align: center; ">
		<label for="Publier"><b>Publier ?</b></label>
		<input type="checkbox" name="is_visible" value="1"<?php echo (isset($post_is_visible) && !empty($post_is_visible) || $art_visible == "1"?" checked=checked":"") ;?>/><br />
		<?php echo $display_error_is_visible; ?>
		
		<input id="art_submit" type="submit" name="submit" value="ENVOYER" />
	</p>
</form>
<?php

	}//else{echo "display_form à false";}//END if(display_form)	

		break;

}//END $get_action

?>

	</div>
</div><!--END .bloc_deco-->