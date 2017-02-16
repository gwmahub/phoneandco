<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		<h1>--- Gestion des slides ---</h1>

<?php 
switch ($get_action) {
	case 'view':
		echo $show_txt_page;
?>

<!--// link add new member -->

<table id="tab_add">
	<tbody>
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			        <img src="<?php echo WWW_IMG."add.jpg";?>" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter un nouveau slide :</h4>
			    </a>
			</td>
		</tr>
	</tbody>
</table>
	<hr class='hrSepar'/>
<!--// END link add new slide -->
	<table id="tab_list">
		<tbody>
			<tr>
				<th>Action</th>
				<th>Slide</th>
				<th>txt FR</th>
				<th>txt EN</th>
				<th>online</th>
				<th>Date</th>
				
			</tr>
			
<?php
				if(is_array($display_slides) && !empty($display_slides)){
					foreach($display_slides AS $ds){
						$slide_id		= $ds["slide_id"];
						$slide_img  	= $ds["slide_img"];
						$slide_txt_fr	= html_entity_decode($ds["slide_txt_fr"], ENT_QUOTES, "UTF-8");
						$slide_txt_en	= html_entity_decode($ds["slide_txt_en"],ENT_QUOTES, "UTF-8");
						$is_visible		= $ds["is_visible"];
						$date_add		= dateUs2Fr($ds["date_add"]);
?>
			<tr>
				<td class='td_action'>	
<?php  
	        	if($is_visible == "1"){
?>
			        <!--// DELETE -->
			        <a href=?p=<?php echo $var_page; ?>&action=delete&slide_id=<?php echo $slide_id; ?> title='delete'>
			            <img src=<?php echo WWW_IMG.'del.jpg';?> alt='delete' />
			        </a>
			        <!--// UPDATE -->
			        <a href=index.php?p=<?php echo $var_page; ?>&action=update&slide_id=<?php echo $slide_id; ?> title='update'>
			            <img src=<?php echo WWW_IMG.'edit.jpg';?> alt='edit' />
			        </a>
<?php
				}else{
?>
			<!--// REACTIVE-->
			    	<a href=index.php?p=<?php echo $var_page; ?>&action=reactive&slide_id=<?php echo $slide_id; ?> title='reactive'>
			            <img src=<?php echo WWW_IMG.'reactivate.jpg';?> alt='supprimer' class='ico_action' />
			        </a>
<?php
				}
?>
				</td>
				
				<td><img src="<?php echo WWW_UP.'slides/slides_thumb/thumb_'.$slide_img;?>" /></td>
				<td><?php echo $slide_txt_fr;?></td>
				<td><?php echo $slide_txt_en;?></td>
				<td align="center">
					<?php echo ($is_visible=="1" ? "<span style='color: green; font-weight: bolder;'> V </span>" :
					"<span style='color: red; font-weight: bolder;'> X </span>");?>
				</td>
				<td><?php echo $date_add;?></td>			
			</tr>
<?php
					}
				}
?>
		</tbody>
	</table>

<?php
		break;

case 'add':
?>
<h2>Ajouter un nouveau slide :</h2>
<form action=?p=<?php echo $var_page;?>&action=add method="POST" lang="en" enctype="multipart/form-data">
	<!--txt FR-->
	<span class="reqField">*</span>
	<label for="txt_fr">Texte français : </label><br />
	<?php echo "<span class=\"dispErr\">$display_error_txt_fr</span>"; ?>
	<textarea class="editme <?php echo $is_empty_txt_en;?>" name="txt_fr" cols="80" rows="2" maxlength="200" /><?php echo isset($post_txt_fr)&&!empty($post_txt_fr)?$post_txt_fr:"";?></textarea><br />	
	
	<!--txt EN-->
	<span class="reqField">*</span>
	<label for="txt_en">Texte anglais : </label><br />
	<?php echo "<span class=\"dispErr\">$display_error_txt_en</span>"; ?>
	<textarea class="editme <?php echo $is_empty_txt_en;?>"  name="txt_en" cols="80" rows="2" maxlength="200" /><?php echo isset($post_txt_en)&&!empty($post_txt_en)?$post_txt_en:"";?></textarea><br />
	<!--slide-->
	<span class="reqField">*</span>
	<label for="src_fichier">Slide : </label>
	<?php echo "<span class=\"dispErr\">$display_error_slide_img</span>"; ?>
	<input type="file" name="src_fichier" class="<?php echo $is_empty_slide_img;?>" />
	<!--publication-->

	<p style="text-align: center;">
		<label><b>Publier ? </b></label>
		<input type="checkbox" name="is_visible" value="1" <?php echo isset($post_is_visible)&&($post_is_visible=="1")? " selected='selected'":"";?> /><br />
		<input id="submitTyp_2" type="submit" name="submit" valur="OK"/>
	</p>
</form>

<?php
	break;
	
case 'update':
	
	if(is_array($display_slides) && !empty($display_slides)){
		foreach($display_slides AS $ds){
			$slide_id		= $ds["slide_id"];
			$slide_img  	= $ds["slide_img"];
			$slide_txt_fr	= html_entity_decode($ds["slide_txt_fr"], ENT_QUOTES, "UTF-8");
			$slide_txt_en	= html_entity_decode($ds["slide_txt_en"], ENT_QUOTES, "UTF-8");
			$is_visible		= $ds["is_visible"];
			$date_add		= dateUs2Fr($ds["date_add"]);
		}
	}				
?>

<h2>Modifier un slide :</h2>
<form action="?p=<?php echo $var_page;?>&action=update&slide_id=<?php echo $get_slide_id ?>" method="POST" enctype="multipart/form-data">
	<!--txt FR-->
	<span class="reqField">*</span>
	<label for="txt_fr">Texte français : </label><br />
	<textarea class="editme <?php echo $is_empty_txt_en;?>" name="txt_fr" cols="80" rows="2" maxlength="200" /><?php echo isset($post_txt_fr)&&!empty($post_txt_fr)?$post_txt_fr:$slide_txt_fr;?></textarea><br />	
	<!--txt EN-->
	<span class="reqField">*</span>
	<label for="txt_en">Texte anglais : </label><br />
	<textarea class="editme <?php echo $is_empty_txt_en;?>"  name="txt_en" cols="80" rows="2" maxlength="200" /><?php echo isset($post_txt_en)&&!empty($post_txt_en)?$post_txt_en:$slide_txt_en;?></textarea><br />
	<!--slide-->
	<span class="reqField">*</span>
	
	<label for="src_fichier">Slide : </label> <img src="<?php echo WWW_UP."slides/slides_thumb/thumb_".$slide_img;?>"/><br />
	<input type="file" name="src_fichier" class="<?php echo $is_empty_slide_img;?>" />
	<input type="hidden" name="old_slide" value="<?php echo $slide_img;?>" disable="disable"/>
	
	
	<!--publication-->

	<p style="text-align: center;">
		<!--<label><b>Publier ? </b></label>
		<input type="checkbox" name="is_visible" value="1" <?php echo isset($post_is_visible)&&($post_is_visible=="1" || $is_visible == "1")? " checked='checked'":"";?> /><br />
		-->
		<input id="submitTyp_2" type="submit" name="submit" valur="OK"/>
	</p>
</form>


<?php
	
	break;
}
?>
		
		
	</div><!--END .mainBloc-->
</div><!--END #main_bloc_page-->

<?php




?>