
<?php
$var_page = "appareil";
?>
<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">

<?php
switch($get_action){
	case 'view':
?>

<div id="blocMenuAp" class="setFloat_l">
		<ul id="menu_ap">
			<li><a href="?p=appareil&action=view">Tous</a></li>
			<li><a>Cat&eacute;gorie</a>
				<ul class="ss_menu">
<?php
					foreach($display_ap_categ AS $dac){
						$ap_categ_id = $dac["ap_categ_id"];
						$ap_categ_fr = $dac["ap_categ_fr"];
					
?>
					<li><a href="?p=appareil&action=view&ap_categ_id=<?php echo $ap_categ_id; ?>"><?php echo $ap_categ_fr; ?></a></li>
<?php
					}
?>
				</ul>
			</li>
			<li><a>Fabricant</a>
				<ul class="ss_menu">
<?php
					foreach($display_ap_fab AS $daf){
						$ap_fab_id 	= $daf["fab_id"];
						$ap_fab 	= $daf["fabricant"];
					
?>
					<li><a href="?p=appareil&action=view&ap_fab_id=<?php echo $ap_fab_id; ?>"><?php echo $ap_fab; ?></a></li>
<?php
					}
?>
				</ul>			
			</li>
		</ul>
</div>
<div id="engineAp" class="setFloat_l">
	<form id="engineApForm" action="?p=appareil&action=view" method="POST">
		<label for="filtrer par">Filtrer par : </label>
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
<?php
	if(is_array($display_ap_list) && !empty($display_ap_list)){
		foreach($display_ap_list AS $dal){
			$ap_id				= $dal["ap_id"];
			$date_add			= dateUs2Fr($dal["ap_date_add"]);
			$img_index			= $dal["ap_img_index"];
			$titre_fr			= $dal["ap_titre_fr"];
			$titre_en			= $dal["ap_titre_en"];
			$ap_courte_desc_fr 	= html_entity_decode($dal["ap_courte_desc_fr"], ENT_QUOTES, "utf-8");
			$ap_courte_desc_en 	= html_entity_decode($dal["ap_courte_desc_en"], ENT_QUOTES, "utf-8");
			$ap_categ_fr		= $dal["ap_categ_fr"];
			$ap_categ_en		= $dal["ap_categ_en"];
			$fab_logo			= $dal["fab_logo"];
			$fab				= $dal["fabricant"];
			$ft_fr				= $dal["ap_fiche_tech_fr"];
			$ft_en				= $dal["ap_fiche_tech_en"];
			$ap_is_visible 		= $dal["is_visible"];
?>
<!--Bloc appareil-->

<div class="setFloat_l bloc_ap">
	<div class="head_bloc_ap">
		<h5 class="setFloat_l">
		 <a href="?p=<?php echo $var_page;?>&action=detail&ap_id=<?php echo $ap_id; ?>">
		 	<?php echo  $get_lang == "fr"?$titre_fr:$titre_en;?>
		 </a>
		</h5>
		<img class="setFloat_l" title="" src="<?php echo WWW_UP.'fabricants/fab_thumb/thumb_'.$fab_logo; ?>" alt="<?php echo $fab; ?>" />
	</div>
	
	<img class="setFloat_l thumb_ap" title="" src="<?php echo WWW_UP."appareils/thumb/thumb_".$img_index; ?>" alt="" />
	<p><?php echo  $get_lang == "fr"?$ap_courte_desc_fr:$ap_courte_desc_en?></p>
	<a class="aTyp_1 setFloat_r link_ap_detail" href="?p=<?php echo $var_page;?>&action=detail&ap_id=<?php echo $ap_id; ?>">
		<?php echo  $get_lang == "fr"?"Plus d'infos": "More info";?></a>
<div class="clearFloat"></div>
</div><!--END Bloc appareil-->
<?php
		}
	}else{
		echo $get_lang == "fr"?"<p>&rarr;&nbsp;Désolé, aucun résultat ne correspond à votre recherche.</p>":"Sorry, no result found.";
	}
	break;
		
	case 'detail':

?>
<h1><?php echo $get_lang=="fr"?"--- Fiche technique de : <b>".$ap_titre_fr."</b>":"--- Technical data on : <b>".$ap_titre_en."</b>"; ?></h1>

<div id="ap_header">
	<h3 class="setFloat_r">
		<a class="aTyp_1" href="?p=<?php echo $var_page; ?>"><?php echo $get_lang=="fr"? "--- Retour à la liste ---":"--- Back to the list ---";?></a>
	</h3>
	
	<img class="setFloat_l" src="<?php echo WWW_UP."appareils/resized/resized_".$img_index; ?>" alt="<?php echo $ap_titre_fr; ?>" />
	
	<p class="ap_fab setFloat_l">
		<img src="<?php echo WWW_UP."fabricants/fab_thumb/thumb_".$fab_logo; ?>" alt="<?php echo $fab; ?>" />
	</p>
	
	<h4><b><?php echo $get_lang=="fr"? "Courte description :": "Short description :";?></b></h4>
	<p>
		<?php echo $ap_courte_desc_fr;?>
	</p>
	<p>
	<?php 
		if(!empty($ft_fr) && !empty($ft_en)){
	?>
		<a class="aTyp_1" href="<?php echo $get_lang == "fr"? WWW_UP."appareils/ft_pdf/".$ft_fr : WWW_UP."appareils/ft_pdf/".$ft_en; ?>" target="blank">
			<?php echo $get_lang == "fr"? "<span><b>Fiche Technique : </b></span>": "<span><b>Technical sheet</b></span>";?>
			<img src="<?php echo WWW_IMG."ico_pdf.jpg";?>" />
		</a>
	</p>
<?php
	}else{
?>
	<p style="margin-top: 15px;">&rarr;&nbsp;<b>Pas de fiche technique disponible pour cet appareil. :-(</b></p>
<?php

	}
	
?>
	
<div class="clearFloat"></div>
</div>
<div id="ap_content">
	<h4>
		<b><?php echo $get_lang=="fr"? "Description" :"Description"; ?> </b>
	</h4>
		<p><?php echo $get_lang=="fr"? $ap_desc_fr:$ap_desc_en;?></p>
</div>
<div id="ap_footer">
	&nbsp;
</div>

<?php
	break;
}
?>



		<div class="clearFloat"></div>
	</div><!--END .mainBloc-->
</div><!--END .bloc_deco-->