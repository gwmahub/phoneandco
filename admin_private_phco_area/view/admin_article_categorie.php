<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

	switch($get_action){
		case 'view':
?>
<h1>Cat&eacute;gories d'articles</h1>
<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title="add a new article's category">
			        <img src="<?php echo WWW_IMG ?>add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter une nouvelle cat&eacute;gorie d'article</h4>
			    </a>
			</td>
		</tr>
	</table>
	<hr class='hrSepar'/>
	
<table id="tab_list">
	<tbody>
		<tr>
			<th class="td_action">Action</th>
			<th>Cat&eacute;gories fr</th>
			<th>Cat&eacute;gories en</th>
		</tr>
		
		
<?php

	foreach($display_art_categ AS $artCat) {
		
		$art_categ_id	=	$artCat['article_categ_id'];
		$art_categ_fr	=	$artCat['article_categ_fr'];
		$art_categ_en	=	$artCat['article_categ_en'];
		$is_visible		=	$artCat['is_visible'];

		if($is_visible == '1'){
?>
		<tr>
			<td class="td_action">
				<!--//DELETE-->
				<a href="?p=<?php echo $var_page; ?>&action=delete&categ_id=<?php echo $art_categ_id;?>" title="delete an article's category">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='add' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href="?p=<?php echo $var_page; ?>&action=update&categ_id=<?php echo $art_categ_id;?>">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="pic_update" />
				</a>
			</td>
			<td><?php echo $art_categ_fr;?></td>
			<td><?php echo $art_categ_en;?></td>
		</tr>
<?php
		}else{
		
?>			
		<tr>
			<!--//REACTIVE-->
			<td class="td_action">
				<a href="?p=admin_article_categorie&action=reactive&categ_id=<?php echo $art_categ_id;?>">
					<img src="<?php echo WWW_IMG ?>reactivate.jpg" alt="pic_update" />
				</a>
			</td>
			<td><?php echo $art_categ_fr;?></td>
			<td><?php echo $art_categ_en;?></td>
		</tr>
<?php
		}
	}
?>
		
	</tbody>
</table>
<?php
			break;//case view
			
		case 'add':
		
		if($display_form){
?>
<h1>Ajouter une cat&eacute;gorie d'articles</h1>
<div class="bloc_form_1">
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>" method="POST">
	<label for="art_categ_fr">Cat&eacute;gorie FR</label>
	<input required="required" type="text" name="art_categ_fr" class="inputTyp_1<?php echo $is_empty_categ_fr ?>" value="<?php echo isset($post_categ_fr) && !empty($post_categ_fr)? $post_categ_fr:"";?>" />
</div>

<div class="bloc_form_2">
	<label for="art_categ_en">Cat&eacute;gorie EN</label>
	<input required="required" type="text" name="art_categ_en" class="inputTyp_1<?php echo $is_empty_categ_en ?>" value="<?php echo isset($post_categ_en) && !empty($post_categ_en)? $post_categ_en:"";?>" />
	<label for="art_sect">Choisissez la section:</label><br />
	<?php echo "$msg_error_cat_sect"; ?>
	<select class="inputTyp_1<?php echo $is_empty_cat_sect;?>" name="art_sect" required="required">
		<option></option>
		<?php 
			if(is_array($display_art_sect) && !empty($display_art_sect)){
				foreach ($display_art_sect AS $das) {
					$art_sect_id = $das["article_section_id"];	
					$art_sect_fr = $das["article_section_fr"];
		?>
		<option value="<?php echo $art_sect_id; ?>"><?php echo $art_sect_fr; ?></option>
		<?php
				}
			}
		?>
	</select><br />
	<p style="text-align: right; padding-right: 31px;">
		<input class="inputTyp_1" type="submit" name="submit" value="OK" />
	</p>
</div>

	
	<div class="clearFloat"></div>
</form>

<?php
			
		}
			
			break;
		
		case 'update':
			
?>
<h1>Modifier une cat&eacute;gorie d'articles</h1>
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>&categ_id=<?php echo $get_categ_id;?>" method="POST">
	<label for="art_categ_fr">Cat&eacute;gorie FR</label>
	<input required="required" type="text" name="art_categ_fr" class="inputTyp_1" 
	value="<?php echo isset($art_categ_fr) && !empty($art_categ_fr)? $art_categ_fr:""; ?>" />
	
	<label for="art_categ_en">Cat&eacute;gorie EN</label>
	<input required="required" type="text" name="art_categ_en" class="inputTyp_1" 
	value="<?php echo isset($art_categ_en) && !empty($art_categ_en)? $art_categ_en:"";?>" />
	<input class="inputTyp_1" type="submit" name="submit" value="OK" />
</form>
<?php
		
			break;
	}

?>

	</div><!--END #mainBloc-->
</div><!--END #main_bloc_page-->