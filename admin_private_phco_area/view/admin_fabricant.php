<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		<h1>--- Gestion des fabricants ---</h1>

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
			    	<h4>Ajouter un nouveau fabricant :</h4>
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
				<th>Logo</th>
				<th>Fabricant</th>
				<th>Catégories<br />d'appareil</th>
				<th>Visible</th>
			</tr>
			
<?php
				if(is_array($display_fab) && !empty($display_fab)){
					foreach($display_fab AS $df){
						$fab_id		= $df["fab_id"];
						$logo	  	= $df["fab_logo"];
						$fab_nom	= $df["fabricant"];
						$is_visible	= $df["fab_is_visible"];
?>
			<tr>
				<td class='td_action'>	
<?php  
	        	if($is_visible == "1"){
?>
			        <!--// DELETE -->
			        <a href=?p=<?php echo $var_page; ?>&action=delete&fab_id=<?php echo $fab_id; ?> title='delete'>
			            <img src=<?php echo WWW_IMG.'del.jpg';?> alt='delete' />
			        </a>
			        <!--// UPDATE -->
			        <a href=index.php?p=<?php echo $var_page; ?>&action=update&fab_id=<?php echo $fab_id; ?> title='update'>
			            <img src=<?php echo WWW_IMG.'edit.jpg';?> alt='edit' />
			        </a>
<?php
				}else{
?>
			<!--// REACTIVE-->
			    	<a href=index.php?p=<?php echo $var_page; ?>&action=reactive&fab_id=<?php echo $fab_id; ?> title='reactive'>
			            <img src=<?php echo WWW_IMG.'reactivate.jpg';?> alt='supprimer' class='ico_action' />
			        </a>
<?php
				}
?>
				</td>
			<!--// Logo -->
				<td><img src="<?php echo WWW_UP.'fabricants/fab_thumb/thumb_'.$logo;?>" /></td>
			<!--// Nom -->
				<td><?php echo $fab_nom;?></td>
				<td>
					<ul>
						
<?php				
				//affichage des types d'appareils proposés par ce fabricant
				$display_ap_categ_by_fab 	= getApCategByFab($fab_id);
				if(is_array($display_ap_categ_by_fab) && !empty($display_ap_categ_by_fab)){
					foreach($display_ap_categ_by_fab AS $dacbf){
						$ap_categ_id 	= $dacbf["ap_categ_id"];
						$ap_categ_fr 	= $dacbf["ap_categ_fr"];
						$is_visible		= $dacbf["is_visible"];
						
						if($is_visible == "1"){
?>
					<li><?php echo $ap_categ_fr;?></li>
<?php
						}
					}//END if ap_categ
					
				}//END foreach ap_categ
?>
					</ul>
				</td>
				
				
				
				
				<td align="center">
					<?php echo ($is_visible=="1" ? "<span style='color: green; font-weight: bolder;'> V </span>" :
					"<span style='color: red; font-weight: bolder;'> X </span>");?>
				</td>
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
<h2>Ajouter un nouveau fabricant :</h2>
<form action=?p=<?php echo $var_page;?>&action=add method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">
		<!--txt FR-->
		<span class="reqField">*</span>
		<label for="fabricant">Fabricant : </label><br />
		<?php echo "<span class=\"dispErr\">$display_error_fab_nom</span>"; ?>
		<input type="text" class="inputTyp_1"<?php echo $is_empty_fab_nom;?>" name="fab_nom" value="<?php echo isset($post_fab_nom)&&!empty($post_fab_nom)?$post_fab_nom:"";?>" />
		<br />	
		<!-- logo -->
		<span class="reqField">*</span>
		<label for="src_fichier">Logo : </label>
		<?php echo "<span class=\"dispErr\">$display_error_logo</span>"; ?>
		<input type="file" name="src_fichier" class="<?php echo $is_empty_logo;?>" /><br />
		<span style="font-size: smaller">(JPG - GIF or PNG only )</span>
	</div><!--END .bloc_form_1-->
	
	<div class="bloc_form_2">
		<p>
			<b>NB: </b>Si le type d'appareil n'existe pas encore, rendez-vous 
			<a class="aTyp_1" href="?p=admin_appareil_categ&action=add"><b>ICI</b></a> pour l'enregistrer.
		</p>
		
		<p>
			<span class="reqField">*</span>
			<label for="art_sect"><b>Types d'appareils proposés par ce fabricant:</b></label>
			<?php echo "$display_error_ap_categ"; ?>
			<br />
<?php 
				// Affichage de toutes les catégories
				if(is_array($display_ap_categ) && !empty($display_ap_categ)){
					foreach ($display_ap_categ AS $dac) {
						$ap_categ_id 	= $dac["ap_categ_id"];	
						$ap_categ_fr 	= $dac["ap_categ_fr"];
						$ap_categ_en 	= $dac["ap_categ_en"];
						
?>
			<input type="checkbox" name="ap_categ[]" value="<?php echo $ap_categ_id; ?>" 
			<?php echo isset($post_ap_categ) && !empty($post_ap_categ) ? " checked='checked'":"";?> />
			&nbsp;<?php echo $ap_categ_fr . " - " . $ap_categ_en; ?><br />
<?php
					}
				}
?>
		</p>
	</div><!--END .bloc_form_2-->

	<div class="bloc_form_3">
		<!--publication-->
		<p style="text-align: center;">
			<label><b>Publier ? </b></label>
			<input type="checkbox" name="is_visible" value="1" <?php echo isset($post_is_visible)&&($post_is_visible=="1")? " checked='checked'":"";?> /><br />
			
			<input id="submitTyp_2" type="submit" name="submit" valur="OK"/>
		</p>
	</div>
	<div class="clearFloat"></div>
	
</form>

<?php
	break;
	
case 'update':
	
	if(is_array($display_fab) && !empty($display_fab)){
		foreach($display_fab AS $df){
			$fab_id			= $df["fab_id"];
			$logo	  		= $df["fab_logo"];
			$fab_nom		= $df["fabricant"];
			$is_visible		= $df["fab_is_visible"];
			var_dump($df["fab_is_visible"]);
		}
	}				
?>

<h2>Modifier un fabricant :</h2>

<form action="?p=<?php echo $var_page;?>&action=update&fab_id=<?php echo $get_fab_id ?>" method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1"><!--txt FR-->
		<span class="reqField">*</span>
		<label for="fabricant">Fabricant : </label><br />
		<?php echo "<span class=\"dispErr\">$display_error_fab_nom</span>"; ?>
		<input type="text" class="inputTyp_1"<?php echo $is_empty_fab_nom;?>" name="fab_nom" value="<?php echo isset($post_fab_nom)&&!empty($post_fab_nom)?$post_fab_nom:$fab_nom;?>" />
		<br />	
		<!-- logo -->
		<span class="reqField">*</span>
		<label for="src_fichier">logo : </label> <img src="<?php echo WWW_UP.'fabricants/fab_thumb/thumb_'.$logo;?>" /><br />
		<input type="file" name="src_fichier" class="<?php echo $is_empty_logo;?>" />
		<input type="hidden" name="old_logo" value="<?php echo $logo; ?>" />
	</div><!--END .bloc_form_1-->
	
	<div class="bloc_form_2">
		<span class="reqField">*</span>
		<label for="art_sect"><b>Types d'appareils proposés par ce fabricant:</b></label><br />
		<?php echo "$display_error_ap_categ"; ?>
		<br />
<?php 
				// Affichage de toutes les catégories
				if(is_array($display_ap_categ) && !empty($display_ap_categ)){
					foreach ($display_ap_categ AS $dac) {
						$ap_categ_id 	= $dac["ap_categ_id"];	
						$ap_categ_fr 	= $dac["ap_categ_fr"];
						$ap_categ_en 	= $dac["ap_categ_en"];
						
						// Présélection des catégories déjà associées
						if(is_array($display_ap_categ_by_fab) && !empty($display_ap_categ_by_fab)){
?>
			<input type="checkbox" name="ap_categ[]" value="<?php echo $ap_categ_id; ?>"
<?php 		
			foreach ($display_ap_categ_by_fab AS $dacbf) {
				$ap_categ_id_2 	= $dacbf["ap_categ_id"];
				$ap_categ_fr_2 	= $dacbf["ap_categ_fr"];
				$ap_categ_en_2	= $dacbf["ap_categ_en"];
				
				echo isset($post_ap_categ) && !empty($post_ap_categ) || ($ap_categ_id == $ap_categ_id_2) ? " checked='checked' ":"";
			}
?> 
			/> &nbsp;<?php echo $ap_categ_fr . " - " . $ap_categ_en; ?><br />
<?php
							
						// si aucune catégorie n'était associée avant...
						}else{

?>
			<input type="checkbox" name="ap_categ[]" value="<?php echo $ap_categ_id; ?>" 
			<?php echo isset($post_ap_categ) && !empty($post_ap_categ) ? " checked='checked'":"";?> />
			&nbsp;<?php echo $ap_categ_fr . " - " . $ap_categ_en; ?><br />
<?php
							
						}
					}
				}
?>
		
	</div><!--END .bloc_form_2-->
	
	<div class="bloc_form_3"><!--publication-->
		<p style="text-align: center;">
			<label><b>Publier ? </b></label>
			<input type="checkbox" name="is_visible" value="1" <?php echo isset($post_is_visible)&&($post_is_visible=="1" || $is_visible == "1")? " checked='checked'":"";?> /><br />
			<input id="submitTyp_2" type="submit" name="submit" valur="OK"/>
		</p>
	</div>
	<div class="clearFloat"></div>
</form>


<?php
	
	break;
}
?>
	</div><!--END .mainBloc-->
</div><!--END #main_bloc_page-->
