<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

	switch($get_action){
		case 'view':
			echo $show_txt_page;
?>
<h1>--- Cat&eacute;gories d'appareils ---</h1>
<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title="add a new devices's category">
			        <img src="<?php echo WWW_IMG ?>add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter une nouvelle cat&eacute;gorie d'appareil</h4>
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
if(is_array($display_ap_categ) && !empty($display_ap_categ)){
	foreach($display_ap_categ AS $apCat) {
		
		$ap_categ_id	=	$apCat['ap_categ_id'];
		$ap_categ_fr	=	$apCat['ap_categ_fr'];
		$ap_categ_en	=	$apCat['ap_categ_en'];
		$is_visible		=	$apCat['is_visible'];

		if($is_visible == '1'){
?>
		<tr>
			<td class="td_action">
				<!--//DELETE-->
				<a href="?p=<?php echo $var_page; ?>&action=delete&categ_id=<?php echo $ap_categ_id;?>" title="delete an device's category">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='add' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href="?p=<?php echo $var_page; ?>&action=update&categ_id=<?php echo $ap_categ_id;?>">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="pic_update" />
				</a>
			</td>
			<td><?php echo isset($ap_categ_fr)?$ap_categ_fr:"";?></td>
			<td><?php echo $ap_categ_en;?></td>
		</tr>
<?php
		}else{
		
?>			
		<tr>
			<!--//REACTIVE-->
			<td class="td_action">
				<a href="?p=admin_appareil_categ&action=reactive&categ_id=<?php echo $ap_categ_id;?>">
					<img src="<?php echo WWW_IMG ?>reactivate.jpg" alt="pic_update" />
				</a>
			</td>
			<td><?php echo $ap_categ_fr;?></td>
			<td><?php echo $ap_categ_en;?></td>
		</tr>
<?php
		}
	}
}else{
	echo "<p>Aucun type d'appareil enregistrés</p>";
}
?>
		
	</tbody>
</table>
<?php
			break;//case view
			
		case 'add':
		
		if($display_form){
?>
<h1>--- Ajouter une cat&eacute;gorie d'appareils ---</h1>
<div class="bloc_form_1">
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>" method="POST">
	<label for="ap_categ_fr">Cat&eacute;gorie FR</label>
	<input required="required" type="text" name="ap_categ_fr" class="inputTyp_1<?php echo $is_empty_categ_fr ?>" value="<?php echo isset($post_categ_fr) && !empty($post_categ_fr)? $post_categ_fr:"";?>" />
</div>

<div class="bloc_form_2">
	<label for="ap_categ_en">Cat&eacute;gorie EN</label>
	<input required="required" type="text" name="ap_categ_en" class="inputTyp_1<?php echo $is_empty_categ_en ?>" value="<?php echo isset($post_categ_en) && !empty($post_categ_en)? $post_categ_en:"";?>" />

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
			if(is_array($display_ap_categ) && !empty($display_ap_categ)){
				foreach ($display_ap_categ AS $apCat) {
						$ap_categ_id	=	$apCat['ap_categ_id'];
						$ap_categ_fr	=	$apCat['ap_categ_fr'];
						$ap_categ_en	=	$apCat['ap_categ_en'];
					}
			}
?>
<h1>--- Modifier une cat&eacute;gorie d'appareil ---</h1>
<form action="?p=<?php echo $var_page ;?>&action=<?php echo $get_action; ?>&categ_id=<?php echo $get_categ_id;?>" method="POST">
	<div class="bloc_form_1">
		<label for="ap_categ_fr">Cat&eacute;gorie FR</label>
		<input required="required" type="text" name="ap_categ_fr" class="inputTyp_1" value="<?php echo isset($post_categ_fr) && !empty($post_categ_fr)? $post_categ_fr:$ap_categ_fr; ?>" />
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_categ_fr</span>"; ?>
	</div>

	<div class="bloc_form_2">
		<label for="ap_categ_en">Cat&eacute;gorie EN</label>
		<input required="required" type="text" name="ap_categ_en" class="inputTyp_1" 
		value="<?php echo isset($post_categ_en) && !empty($post_categ_en) ? $post_categ_en:$ap_categ_en;?>" />
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_categ_en</span>"; ?>
	</div>
	<input class="inputTyp_1" type="submit" name="submit" value="OK" />
</form>
<?php
		
			break;
	}

?>

	</div><!--END #mainBloc-->
</div><!--END #main_bloc_page-->