<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		
<?php 

switch($get_action){
	case 'view':
?>
<h1>--- Gestion des appareils multimédia ---</h1>
<!--//ADD-->
<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title="add a new device">
			        <img src="<?php echo WWW_IMG ?>add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&action=add title='add'>
			    	<h4>Ajouter un nouvel appareil</h4>
			    </a>
			</td>
		</tr>
	</table>
	<hr class='hrSepar'/>
<!--//END ADD-->

<div id="blocMenuAp" class="setFloat_l">
		<ul id="menu_ap">
			<li><a href="?p=admin_appareil&action=view">Tous les appareils</a></li>
			<li><a href="?p=admin_appareil&action=view&groupByCateg=1">Par Cat&eacute;gorie</a>
				<ul class="ss_menu">
<?php
					foreach($display_ap_categ AS $dac){
						$ap_categ_id = $dac["ap_categ_id"];
						$ap_categ_fr = $dac["ap_categ_fr"];
					
?>
					<li><a href="?p=admin_appareil&action=view&ap_categ_id=<?php echo $ap_categ_id; ?>"><?php echo $ap_categ_fr; ?></a></li>
<?php
					}
?>
				</ul>
			</li>
			<li><a href="?p=admin_appareil&action=view&groupByFab=1">Par Fabricant</a>
				<ul class="ss_menu">
<?php
					foreach($display_ap_fab AS $daf){
						$ap_fab_id 	= $daf["fab_id"];
						$ap_fab 	= $daf["fabricant"];
					
?>
					<li><a href="?p=admin_appareil&action=view&ap_fab_id=<?php echo $ap_fab_id; ?>"><?php echo $ap_fab; ?></a></li>
<?php
					}
?>
				</ul>			
			</li>
			<li><a href="?p=admin_appareil&action=view&groupByAp=1">Par Appareil</a></li>
		</ul>
</div>
<div id="engineAp" class="setFloat_l">
	<form id="engineApForm" action="?p=admin_appareil&action=view" method="POST">
		
		<label for="visib">Publié : </label>
		<input type="radio" name="is_visible" value="1" <?php echo isset($post_is_visible) && ($post_is_visible == "1") ? " checked=\"checked\"" : ""; ?> />Oui
		<input type="radio" name="is_visible" value="0" <?php echo isset($post_is_visible) && ($post_is_visible == "0") ? " checked=\"checked\"" : ""; ?> />Non
		<input type="radio" name="is_visible" value="" <?php echo isset($post_is_visible) && ($post_is_visible == "") ? " checked=\"checked\"" : ""; ?> />Tous
		
		<select class="selectTyp_1" name="apField">
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
			<th>Date<br />créa.</th><!--$ap_date_crea-->
			<th>Img<br />index</th><!---->
			<th>Titre <br />FR - EN</th>
			<th>Courte<br />desc FR</th>
			<th>Courte<br />desc EN</th>
			<th>Type</th>
			<th>Fab</th>
			<th>FT <br />FR-EN</th> <!--// 2 icones pdf cliquables -->
			<th>Publié</th>
			<th>Visu</th>
		</tr>
<?php 
		if(is_array($display_ap_list) && !empty($display_ap_list)){
			foreach($display_ap_list AS $dal){
				$ap_id				= $dal["ap_id"];
				$date_add			= dateUs2Fr($dal["ap_date_add"]);
				$img_index			= $dal["ap_img_index"];
				$titre_fr			= $dal["ap_titre_fr"];
				$titre_en			= $dal["ap_titre_en"];
				$ap_courte_desc_fr 	=  substr($dal["ap_courte_desc_fr"],0,50);//problème charset -> voir avec le add -> html_
				$ap_courte_desc_en 	=  substr($dal["ap_courte_desc_en"], 0, 50);
				$ap_categ_fr		= $dal["ap_categ_fr"];
				$ap_categ_en		= $dal["ap_categ_en"];
				$fab_logo			= $dal["fab_logo"];
				$ft_fr				= $dal["ap_fiche_tech_fr"];
				$ft_en				= $dal["ap_fiche_tech_en"];
				$ap_is_visible 		= $dal["is_visible"];
				
				//$logo = getFabByAp($ap_id);
?>
		<tr>
			<td class="td_action">
<?php 
				if($ap_is_visible == 1){
?>
				<!--//DELETE-->
				<a href=index.php?p=<?php echo $var_page; ?>&action=delete&ap_id=<?php echo $ap_id;?> title="delete a device">
			        <img src="<?php echo WWW_IMG ?>del.jpg" alt='del.jpg' class=''/>
			    </a>
			    <!--//UPDATE-->
				<a href=?p=<?php echo $var_page; ?>&action=update&ap_id=<?php echo $ap_id;?> title="update an article">
					<img src="<?php echo WWW_IMG ?>edit.jpg" alt="edit.jpg" />
				</a>
<?php
			}else{
?>
				<!--//REACTIVE-->
				<a href=index.php?p=<?php echo $var_page; ?>&action=reactive&ap_id=<?php echo $ap_id;?> title="reactive a device">
			        <img src="<?php echo WWW_IMG ?>reactivate.jpg" alt='reactive.jpg' class=''/>
			    </a>
<?php
				}
?>
				
			</td>
			
			<td align="center"><?php echo $date_add; ?></td>
			<!--img appareil-->
			<td align="center"><img src="<?php echo WWW_UP."appareils/thumb/thumb_".$img_index; ?>"  alt="img"/></td>
			<td>
				<?php echo $titre_fr." - ".$titre_en; ?>
			</td>
			
			<td>
				<?php echo $ap_courte_desc_fr."..."; ?>
			</td>
			<td>
				<?php echo $ap_courte_desc_en."..."; ?>
			</td>
			
			<td>
				<?php echo $ap_categ_fr." - ".$ap_categ_en; ?>
			</td>
			
			<td>
				<img src="<?php echo WWW_UP."fabricants/fab_thumb/thumb_".$fab_logo; ?>"  alt="logo"/>
			</td>
			
			<td align="center">
				<!--Lien vers la FT FR-->
				 <a title="FT fr" href="<?php echo WWW_UP."appareils/ft_pdf/".$ft_fr; ?>" target="blank">
				 	<img src="<?php echo WWW_IMG ?>ico_pdf.jpg" alt='pdf.jpg' class='' />
				 </a>
				<!--Lien vers la FT EN-->
				 <a title="FT en" href="<?php echo WWW_UP."appareils/ft_pdf/".$ft_en; ?>" target="blank">
				 	<img src="<?php echo WWW_IMG ?>ico_pdf.jpg" alt='pdf.jpg' class=''/>
				 </a>
			</td>			
			
			<td align="center"><?php echo $ap_is_visible == "1"? "<span style='color: green;'><b>V</b></span>":"<span style='color: red;'><b>X</b></span>"; ?></td>
			
			<td align="center">
				<a href="index.php?p=<?php echo $var_page; ?>&action=detail&ap_id=<?php echo $ap_id;?>">
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
		
	include_once(PATH_VIEW."admin_appareil_detail.php");
	
	break;
	
	case 'add';
?>
<h1>--- Ajouter un appareil Multimédia ---</h1>
<form action=?p=<?php echo $var_page;?>&action=<?php echo $get_action; ?> method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">
		
		<!--Type d'appareil-->
		<p>
			<label for="ap_categ">Type d'appareil : </label>
			<a title="Ce type d'appareil n'existe pas encore ? Enregistrez-le avant :-)" href=?p=admin_appareil_categ&action=add>
				<img src=<?php echo WWW_IMG."add.jpg" ;?> />
			</a>
			<br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_categ</span>"; ?>
			<select class="selectMulti <?php echo $is_empty_ap_categ; ?>" name="ap_categ[]" multiple="multiple" required="required">
				<option></option>
<?php
			if(is_array($display_ap_categ) && !empty($display_ap_categ)){
				foreach($display_ap_categ AS $dac){
					$ap_categ_id = $dac["ap_categ_id"];
					$ap_categ_fr = $dac["ap_categ_fr"];
					$ap_categ_en = $dac["ap_categ_en"];
?>
				<option value="<?php echo $ap_categ_id; ?>" <?php echo isset($post_ap_categ) && !empty($post_ap_categ) && in_array($ap_categ_id, $post_ap_categ) ? " selected='selected'": ""; ?>>
					<?php echo $ap_categ_fr." - ".$ap_categ_en; ?>
				</option>
<?php					
				}
			}
?>
			</select>
		</p>
		<br />
		
		<!--Fabricants-->
		<p>	
			<label class="labelTyp_1" for="ap_fab">Fabricant : </label>	
			<a title="Ce fabricant n'existe pas encore ? Enregistrez-le avant :-)" href=?p=admin_fabricant&action=add>
				<img src=<?php echo WWW_IMG."add.jpg" ;?> />
			</a>
			<select class="selectTyp_1 <?php echo $is_empty_ap_fab; ?>" name="ap_fab" required="required">
				<option></option>
<?php
			if(is_array($display_ap_fab) && !empty($display_ap_fab)){
				foreach($display_ap_fab AS $daf){
					$ap_fab_id 		= $daf["fab_id"];
					$ap_fabricant 	= $daf["fabricant"];					
?>
				<option value="<?php echo $ap_fab_id; ?>" <?php echo (isset($post_ap_fab) && $post_ap_fab == $ap_fab_id)? " selected='selected'": ""; ?>>
					<?php echo $ap_fabricant; ?>
				</option>
<?php					
				}
			}
?>
			</select>
			<?php echo "<span class=\"dispErr\">$display_error_ap_fab</span>"; ?>
		</p>
		<!--Titre FR-->
		<p>
			<label class="labelTyp_1" for="ap_titre_fr">Titre FR : </label>
			<input class="inputTyp_1 <?php echo $is_empty_ap_titre_fr; ?>" type="text" name="ap_titre_fr" value="<?php echo isset($post_ap_titre_fr) && !empty($post_ap_titre_fr)?$post_ap_titre_fr:""; ?>" required="required"/>
			<br /><?php echo "<span class=\"dispErr\">$display_error_ap_titre_fr</span>"; ?>
		</p>
		<!--Titre EN-->
		<p>
			<label class="labelTyp_1" for="ap_titre_en">Titre EN : </label>
			<input class="inputTyp_1 <?php echo $is_empty_ap_titre_en; ?>" type="text" name="ap_titre_en" value="<?php echo isset($post_ap_titre_en) && !empty($post_ap_titre_en)?$post_ap_titre_en:""; ?>" required="required"/>
			<br /><?php echo "<span class=\"dispErr\">$display_error_ap_titre_en</span>"; ?>
		</p>	

	<div class="clearFloat"></div>
	
	</div><!--END .bloc_form_1-->
	
	
	<div class="bloc_form_2">
		<!--Img index-->
		<p>
			<label class="labelTyp_1" for="src_fichier">Image index :</label>
			<input type="file" name="src_fichier" /><br /><span style="font-size: smaller;">(JPG - GIF or PNG only)</span>
		</p>

		<label for="ap_courte_desc_fr">Courte description FR :</label><span style="font-size: smaller;"> 200 caract. max</span><br />
		<?php echo "<span class=\"dispErr\">$is_empty_ap_short_desc_fr</span>"; ?>
		<textarea maxlength="200" class="txtAreaTyp_1 <?php echo $is_empty_ap_short_desc_fr;?>" name="ap_courte_desc_fr" required="required"><?php echo isset($post_ap_courte_desc_fr) && !empty($post_ap_courte_desc_fr)?$post_ap_courte_desc_fr: ""; ?></textarea>
		<span class="reqField">*</span><br />
		
		<label for="ap_courte_desc_en">Courte description EN :</label><span style="font-size: smaller;"> 200 caract. max</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_ap_short_desc_en</span>"; ?>	
		<textarea maxlength="200" class="txtAreaTyp_1 <?php echo $is_empty_ap_short_desc_en;?>" name="ap_courte_desc_en" required="required"><?php echo isset($post_ap_courte_desc_en) && !empty($post_ap_courte_desc_en)?$post_ap_courte_desc_en: ""; ?></textarea>
		<span class="reqField">*</span><br />
	</div><!--END .bloc_form_2-->
	
	<div class="bloc_form_3">
		<p>
			<label for="ap_desc_fr"><b>Description FR</b></label><br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_desc_fr</span>"; ?>
			<textarea class="ckeditor <?php echo $is_empty_ap_desc_fr ;?>" cols="80" id="ap_desc" name="ap_desc_fr" rows="10" required="required"><?php echo isset($post_ap_desc_fr) && !empty($post_ap_desc_fr)?$post_ap_desc_fr: ""; ?></textarea>
		</p>
		<p>
			<label for="ap_desc_fr"><b>Description EN</b></label><br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_desc_en</span>"; ?>
			<textarea class="ckeditor <?php echo $is_empty_ap_desc_en ;?>" cols="80" id="ap_desc" name="ap_desc_en" rows="10" required="required"><?php echo isset($post_ap_desc_en) && !empty($post_ap_desc_en)?$post_ap_desc_en: ""; ?></textarea>
		</p>
	</div><!--END .bloc_form_3-->
	
	<div class="clearFloat"></div>
	
	<p style="text-align: center; ">
		<label for="Publier"><b>Publier ?</b></label>
		<input type="checkbox" name="is_visible" value="1" <?php echo (isset($post_is_visible) && !empty($post_is_visible)?" checked=checked":"") ;?>/><br />
		<?php echo $display_error_is_visible; ?>
		
		<input id="submitTyp_2" type="submit" name="submit" value="ENVOYER" />
	</p>
</form>
<?php
	break;
	
	case 'update':
		
//var_dump($_POST);
?>
<h1>--- Modifier un appareil Multimédia ---</h1>

<?php
if(is_array($display_ap_list) && !empty($display_ap_list)){
	//var_dump($display_ap_list);
$ap_id						= $display_ap_list[0]["ap_id"];
$post_ap_fab_id				= $display_ap_list[0]["fab_id"];
$post_ap_fab				= $display_ap_list[0]["fabricant"];
$img_index					= $display_ap_list[0]["ap_img_index"];
$post_ap_titre_fr			= $display_ap_list[0]["ap_titre_fr"];
$post_ap_titre_en			= $display_ap_list[0]["ap_titre_en"];
$post_ap_courte_desc_fr 	= $display_ap_list[0]["ap_courte_desc_fr"];
$post_ap_courte_desc_en 	= $display_ap_list[0]["ap_courte_desc_en"];
$post_ap_desc_fr			= $display_ap_list[0]["ap_desc_fr"];
$post_ap_desc_en			= $display_ap_list[0]["ap_desc_en"];
//$ft_fr					= $dal["ap_fiche_tech_fr"];
//$ft_en					= $dal["ap_fiche_tech_en"];
$post_is_visible 			= $display_ap_list[0]["is_visible"];

}//END is_array($display_ap_list) 


?>

<h3>> <?php echo $post_ap_titre_fr;?></h3>
<form action=?p=<?php echo $var_page;?>&action=<?php echo $get_action; ?>&ap_id=<?php echo $get_ap_id; ?> method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">
		
		<!--Type d'appareil-->
		<p>
			<label for="ap_categ">Type d'appareil : </label>
			<a title="Ce type d'appareil n'existe pas encore ? Enregistrez-le avant :-)" href=?p=admin_appareil_categ&action=add>
				<img src=<?php echo WWW_IMG."add.jpg" ;?> />
			</a>
			<br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_categ</span>"; ?>
			<select class="selectMulti <?php echo $is_empty_ap_categ; ?>" name="ap_categ[]" multiple="multiple" required="required">
				<option></option>
<?php

			if(is_array($display_ap_categ) && !empty($display_ap_categ)){//ok
				foreach($display_ap_categ AS $dac){
					$categ_id = $dac["ap_categ_id"];
					$categ_fr = $dac["ap_categ_fr"];
					$categ_en = $dac["ap_categ_en"];
					
				foreach($display_categ_by_ap AS $dcba){
					//var_dump($display_categ_by_ap);
					$ap_categ_id = $dcba["ap_categ_id"];
										
					if($categ_id == $ap_categ_id){
						$selected 	= " selected='selected'";
					}else{
						$selected 	= "";

					}
				}
?>
				<option value="<?php echo $categ_id; ?>" <?php echo $selected; ?> >
					<?php echo $categ_fr." - ".$categ_en; ?>
				</option>
<?php					

				}
			}
?>
			</select>
		</p>
		<br />
		
		<!--Fabricants-->
		<p>	
			<label class="labelTyp_1" for="ap_fab">Fabricant : </label>	
			<a title="Ce fabricant n'existe pas encore ? Enregistrez-le avant :-)" href=?p=admin_fabricant&action=add>
				<img src=<?php echo WWW_IMG."add.jpg" ;?> />
			</a>
			<select class="selectTyp_1 <?php echo $is_empty_ap_fab; ?>" name="ap_fab" required="required">
				<option></option>
<?php
			if(is_array($display_ap_fab) && !empty($display_ap_fab)){
				//var_dump($display_ap_fab);
				foreach($display_ap_fab AS $daf){
					$ap_fab_id 		= $daf["fab_id"];
					$ap_fabricant 	= $daf["fabricant"];					
?>
				<option value="<?php echo $ap_fab_id; ?>" <?php echo (isset($post_ap_fab_id) && !empty($post_ap_fab_id)) && $post_ap_fab_id == $ap_fab_id  ? " selected='selected'": ""; ?>>
					<?php echo $ap_fabricant; ?>
				</option>
<?php					
				}
			}
?>
			</select>
			<?php echo "<span class=\"dispErr\">$display_error_ap_fab</span>"; ?>
		</p>
		<!--Titre FR-->
		<p>
			<label class="labelTyp_1" for="ap_titre_fr">Titre FR : </label>
			<input class="inputTyp_1 <?php echo $is_empty_ap_titre_fr; ?>" type="text" name="ap_titre_fr" value="<?php echo isset($post_ap_titre_fr) && !empty($post_ap_titre_fr)?$post_ap_titre_fr : ""; ?>" required="required"/>
			<br /><?php echo "<span class=\"dispErr\">$display_error_ap_titre_fr</span>"; ?>
		</p>
		<!--Titre EN-->
		<p>
			<label class="labelTyp_1" for="ap_titre_en">Titre EN : </label>
			<input class="inputTyp_1 <?php echo $is_empty_ap_titre_en; ?>" type="text" name="ap_titre_en" value="<?php echo isset($post_ap_titre_en) && !empty($post_ap_titre_en)?$post_ap_titre_en : ""; ?>" required="required"/>
			<br /><?php echo "<span class=\"dispErr\">$display_error_ap_titre_en</span>"; ?>
		</p>	

	<div class="clearFloat"></div>
	
	</div><!--END .bloc_form_1-->
	
	
	<div class="bloc_form_2">
		<!--Img index-->
		
		<p>
			<label class="labelTyp_1" for="src_fichier">Image index :</label>
			<img src="<?php echo WWW_UP."appareils/thumb/thumb_".$img_index; ?>"/>
			<input type="file" name="src_fichier" /><br /><span style="font-size: smaller;">(JPG - GIF or PNG only)</span>
			<input type="hidden" name="img_index_old" value="<?php echo $img_index; ?>" />
		</p>

		<label for="ap_courte_desc_fr">Courte description FR :</label><span style="font-size: smaller;"> 200 caract. max</span><br />
		<?php echo "<span class=\"dispErr\">$is_empty_ap_short_desc_fr</span>"; ?>
		<textarea maxlength="200" class="txtAreaTyp_1 <?php echo $is_empty_ap_short_desc_fr;?>" name="ap_courte_desc_fr" required="required"><?php echo isset($post_ap_courte_desc_fr) && !empty($post_ap_courte_desc_fr) ? $post_ap_courte_desc_fr : ""; ?></textarea>
		<span class="reqField">*</span><br />
		
		<label for="ap_courte_desc_en">Courte description EN :</label><span style="font-size: smaller;"> 200 caract. max</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_ap_short_desc_en</span>"; ?>	
		<textarea maxlength="200" class="txtAreaTyp_1 <?php echo $is_empty_ap_short_desc_en;?>" name="ap_courte_desc_en" required="required"><?php echo isset($post_ap_courte_desc_en) && !empty($post_ap_courte_desc_en)?$post_ap_courte_desc_en:""; ?></textarea>
		<span class="reqField">*</span><br />
	</div><!--END .bloc_form_2-->
	
	<div class="bloc_form_3">
		<p>
			<label for="ap_desc_fr"><b>Description FR</b></label><br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_desc_fr</span>"; ?>
			<textarea class="ckeditor <?php echo $is_empty_ap_desc_fr ;?>" cols="80" id="ap_desc" name="ap_desc_fr" rows="10" required="required"><?php echo isset($post_ap_desc_fr) && !empty($post_ap_desc_fr)?$post_ap_desc_fr: ""; ?></textarea>
		</p>
		<p>
			<label for="ap_desc_fr"><b>Description EN</b></label><br />
			<?php echo "<span class=\"dispErr\">$display_error_ap_desc_en</span>"; ?>
			<textarea class="ckeditor <?php echo $is_empty_ap_desc_en ;?>" cols="80" id="ap_desc" name="ap_desc_en" rows="10" required="required"><?php echo isset($post_ap_desc_en) && !empty($post_ap_desc_en)?$post_ap_desc_en: ""; ?></textarea>
		</p>
	</div><!--END .bloc_form_3-->
	
	<div class="clearFloat"></div>
	
	<p style="text-align: center; ">
		<label for="Publier"><b>Publier ?</b></label>
		<input type="checkbox" name="is_visible" value="1" <?php echo (isset($post_is_visible) && !empty($post_is_visible) && $post_is_visible == "1" ?" checked=checked":"") ;?>/><br />
		<?php echo $display_error_is_visible; ?>
		
		<input id="submitTyp_2" type="submit" name="submit" value="ENVOYER" />
	</p>
</form>

<?php

		break;

}//END $get_action

?>