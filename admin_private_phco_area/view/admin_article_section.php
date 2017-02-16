<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

	switch($get_action){
		case 'view':
?>
<h1>Sections d'articles</h1>
<!--//ADD-->
<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title="add a new article's section">
			        <img src="<?php echo WWW_IMG ?>add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter une nouvelle section d'article</h4>
			    </a>
			</td>
		</tr>
	</table>
	<hr class='hrSepar'/>
<!--//END ADD-->

<table id="tab_list">
	<tbody>
		<tr>
			<th class="td_action">Action</th>
			<th>Sections fr</th>
			<th>Sections en</th>
			<th>Catégories associées</th>
		</tr>
		
		
<?php

	foreach($display_art_sect AS $artSect) {
		
		$art_sect_id	=	$artSect['article_section_id'];
		$art_sect_fr	=	$artSect['article_section_fr'];
		$art_sect_en	=	$artSect['article_section_en'];
		$is_visible		=	$artSect['is_visible'];
		
		//affichage des catégories associées
	$display_categ_by_sect = getCategBySection($art_sect_id);

		if($is_visible == '1'){
?>
		<tr>
			<td class="td_action">
				<!--//DELETE-->
				<a href=index.php?p=<?php echo $var_page; ?>&action=delete&art_sect_id=<?php echo $art_sect_id;?> title="delete an article's section">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='del.jpg' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href=?p=<?php echo $var_page; ?>&action=update&art_sect_id=<?php echo $art_sect_id;?> title="update an article's section">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="edit.jpg" />
				</a>
			</td>
			<td><?php echo $art_sect_fr;?></td>
			<td><?php echo $art_sect_en;?></td>
			<td>
				<button class="butDisplay setFloat_l">>></button>
				<div class="blocDispCategElem setFloat_l">
				<?php 
					//affichage des catégories associées à la section
					if(is_array($display_categ_by_sect) && !empty($display_categ_by_sect)){
						foreach ($display_categ_by_sect AS $cbs) {
							$art_categ_fr 		= $cbs["article_categ_fr"];
							$art_categ_en 		= $cbs["article_categ_en"];
					
							echo "- ".$art_categ_fr." - ".$art_categ_en."<br />";
						}
					}
				?>
				</div>
			
				
			</td>
		</tr>
<?php
		}else{
		
?>			
		<tr>
			<!--//REACTIVE-->
			<td class="td_action">
				<a href="?p=<?php echo $var_page ;?>&action=reactive&art_sect_id=<?php echo $art_sect_id;?>">
					<img src="<?php echo WWW_IMG ?>reactivate.jpg" alt="pic_update" />
				</a>
			</td>
			<td><?php echo $art_sect_fr;?></td>
			<td><?php echo $art_sect_en;?></td>
			<td>
				<?php 
				if(is_array($display_categ_by_sect) && !empty($display_categ_by_sect)){
					foreach ($display_categ_by_sect AS $cbs) {
						$art_categ_fr 		= $cbs["article_categ_fr"];
						$art_categ_en 		= $cbs["article_categ_en"];
				
						echo "- ".$art_categ_fr." - ".$art_categ_en."<br />";
					}
				}
				?>
			</td>
		</tr>
<?php
			}
		}
?>
		
	</tbody>
</table>
<script type="text/javascript" src="js/admin_art_sect_v.js"></script>
<?php
			break;//case view
			
		case 'add':
		if($display_form){
?>
<h1>Ajouter une section d'articles</h1>
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>" method="POST">
	<div class="bloc_form_1">
		<label for="art_sect_fr">Section FR</label>
		<input required="required" type="text" name="art_sect_fr" class="inputTyp_1<?php echo $is_empty_sect_fr ?>" 
		value="<?php echo isset($post_sect_fr) && !empty($post_sect_fr)? $post_sect_fr:"";?>" />
		<?php echo "<span class=\"dispErr\">$display_error_art_sect_fr</span>"; ?>

		<h4>Associer des cat&eacute;gories</h4>
		<select multiple="multiple" name="sect_cat_ass[]" class="selectMulti">
			<option></option>
		<?php 
			foreach($display_art_categ AS $artCat){
				$art_categ_id = $artCat["article_categ_id"];
				$art_categ_fr = $artCat["article_categ_fr"];
				$art_categ_en = $artCat["article_categ_en"];
		?>
		
			<option value="<?php echo $art_categ_id; ?>">
				<?php echo $art_categ_fr." - ".$art_categ_en ?>
			</option>
			
		<?php
				
			}
		?>
		</select>
	</div><!--END .bloc_form_1-->
		
		<div class="bloc_form_2">
			<label for="art_sect_en">Section EN</label>
			<input required="required" type="text" name="art_sect_en" class="inputTyp_1<?php echo $is_empty_sect_en ?>" 
			value="<?php echo isset($post_sect_en) && !empty($post_sect_en)? $post_sect_en:"";?>" />	
			<?php echo "<span class=\"dispErr\">$display_error_art_sect_en</span>"; ?>
			<div id="newCategList">
				<h5>Ajouter une ou plusieurs nouvelles catégories ?</h5>
				<!--js -> label input create-->
			</div>
			<p>
				<img id="addCateg" src=<?php echo WWW_IMG."add.jpg"; ?> alt="add" />
			</p>
			
		
			<p style="text-align: right"><input class="inputTyp_1" type="submit" name="submit" value="OK" /></p>
		</div><!--END .bloc_form_2-->
	<div class="clearFloat"></div>
	
</form>
<script type="text/javascript" src="js/admin_art_sect_ad.js"></script>

<?php
			
		}
?>

<?php
		break;
		
		case 'update':
			
?>
<h1>Modifier une section d'articles</h1>
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>&art_sect_id=<?php echo $get_sect_id;?>" method="POST">
	
	<label for="art_sect_fr">Sections FR</label>
	<input required="required" type="text" name="art_sect_fr" class="inputTyp_1" 
	value="<?php echo isset($art_sect_fr) && !empty($art_sect_fr)? $art_sect_fr:""; ?>" />
	
	<label for="art_sect_en">Sections EN</label>
	<input required="required" type="text" name="art_sect_en" class="inputTyp_1" 
	value="<?php echo isset($art_sect_en) && !empty($art_sect_en)? $art_sect_en:"";?>" />
	
	<input class="inputTyp_1" type="submit" name="submit" value="OK" />
</form>
<?php
		
			break;
	}

?>

	</div><!--END #mainBloc-->
</div><!--END #main_bloc_page-->
