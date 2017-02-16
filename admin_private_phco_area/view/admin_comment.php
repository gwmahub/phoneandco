<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

	switch($get_action){
		case 'view':
?>
<h1>--- Gestion des commentaires : ----</h1>
<!-- A débloqué quand tout sera en place -> assoc avec art  ou ap ou access. -> pour le moment, gestion publique
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
-->

<div id="blocMenuAp" class="setFloat_l">
<h3 class="setFloat_l">Trier par : </h3>
		<ul id="menu_ap">
			<li><a href="?p=admin_comment&action=view&order_c=1">Par commentaire</a>
			<li><a href="?p=admin_comment&action=view&order_m=1">Par membre</a></li>
		</ul>
</div>

<div id="engineAp" class="setFloat_l">
	<form id="engineApForm" action="?p=admin_comment&action=view" method="POST">
		
		<label for="visib">Publié : </label>
		<input type="radio" name="is_visible" value="1" <?php echo isset($post_is_visible) && ($post_is_visible == "1") ? " checked=\"checked\"" : ""; ?> />Oui
		<input type="radio" name="is_visible" value="0" <?php echo isset($post_is_visible) && ($post_is_visible == "0") ? " checked=\"checked\"" : ""; ?> />Non
		<input type="radio" name="is_visible" value="" <?php echo isset($post_is_visible) && ($post_is_visible == "") ? " checked=\"checked\"" : ""; ?> />Tous
		
		<select class="selectTyp_1" name="field">
			<option></option>
<?php
			if(is_array($display_field_in_select) && !empty($display_field_in_select)){
				foreach($display_field_in_select AS $dfis => $val){
?>
			<option value="<?php echo $dfis; ?>" <?php echo (isset($post_field) && $post_field == $dfis)? " selected='selected'": ""; ?>>
				<?php echo $val; ?>
			</option>
<?php					
				}
			}
?>
		</select>
		
		<label for="user_data">Contient :</label>
		<input class="inputTyp_1" type="text" name="user_data" value="<?php echo (isset($post_user_data) && !empty($post_user_data))?$post_user_data:"";?>" />
		
		<!--// SUBMIT-->
		<input type="submit" name="submit" value="OK"/>
	</form>
</div>
<div class="clearFloat"></div>
<hr class='hrSepar'/>
<!--//END engine-->
<table id="tab_list">
	<tbody>
		<tr>
			<th class="td_action">Action</th>
			<th>Commentaire</th>
			<th>Membre</th>
			<th>Date</th>
		</tr>
		<tr>
<?php
if(is_array($display_comments) && !empty($display_comments)){
	foreach($display_comments AS $dc) {
		$comment_id 	= $dc["commentaire_id"];
		$comment		= html_entity_decode($dc["commentaire"], ENT_QUOTES, "utf-8");
		$membre_id 		= $dc["membre_id"];
		$pseudo			= $dc["pseudo"];
		$date			= dateUs2Fr($dc["comment_date_add"]);
		$is_visible		= $dc["is_visible_comment"];//alias ds le query
		

		if($is_visible == '1'){
?>
		
			<td class="td_action">
				<!--//DELETE-->
				<a href="?p=<?php echo $var_page; ?>&action=delete&comment_id=<?php echo $comment_id;?>" title="delete a comment">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='add' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href="?p=<?php echo $var_page; ?>&action=update&comment_id=<?php echo $comment_id;?>">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="pic_update" />
				</a>
			</td>
<?php
		}else{
?>	
			<!--//REACTIVE-->
			<td class="td_action">
				<a href="?p=<?php echo $var_page; ?>&action=reactive&comment_id=<?php echo $comment_id?>">
					<img src="<?php echo WWW_IMG ?>reactivate.jpg" alt="reactive" />
				</a>
			</td>
<?php
		}
?>
			<td><?php echo $comment;?></td>
			<td><?php echo $pseudo;?></td>
			<td><?php echo $date;?></td>
		</tr>
<?php
	}
}
?>

	</tbody>
</table>
<?php
	break;//END case view
			
	case 'add':
	//A compléter par la suite
	echo "ici le case add";
			
	break;
		
	case 'update':
	if(is_array($display_comments) && !empty($display_comments)){
			$comment_id 	= $display_comments[0]["commentaire_id"];
			$post_comment	= html_entity_decode($display_comments[0]["commentaire"], ENT_QUOTES, "utf-8");
			$membre_id 		= $display_comments[0]["membre_id"];
			$pseudo			= $display_comments[0]["pseudo"];
			$date			= dateUs2Fr($display_comments[0]["comment_date_add"]);
	}

			
?>
<h1>--- Modifier un commentaire : ---</h1>
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>&comment_id=<?php echo $comment_id;?>" method="POST">
	<!--TXT COMMENTAIRE-->
	<label for="comment"><b>Contenu du commentaire : </b></label>
	<textarea required="required" class="ckeditor" name="comment"><?php echo isset($post_comment) && !empty($post_comment)? $post_comment:""; ?></textarea>
	<!--SUBMIT-->
	<input class="inputTyp_1" type="submit" name="submit" value="OK" />
</form>
<?php
		
	break;
	}

?>

	</div><!--END #mainBloc-->
</div><!--END #main_bloc_page-->