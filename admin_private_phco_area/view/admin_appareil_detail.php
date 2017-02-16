<?php

$var_page 				= "admin_appareil";
$display_ap_list 		= getApList($post_is_visible, $get_ap_categ_id, $get_ap_fab_id, $get_ap_id, $get_group_by_categ, $get_group_by_fab, $get_group_by_ap, $post_field, $post_user_data, "DESC");
$display_categ_by_ap 	= getCategsByAp($get_ap_id);

if(is_array($display_ap_list) && !empty($display_ap_list)){
	//var_dump($display_ap_list);

$img_index			= $display_ap_list[0]["ap_img_index"];
$fab_logo			= $display_ap_list[0]["fab_logo"];
$fabricant			= $display_ap_list[0]["fabricant"];
$ap_titre_fr		= $display_ap_list[0]["ap_titre_fr"];
$ap_titre_en		= $display_ap_list[0]["ap_titre_en"];
$ap_courte_desc_fr 	= html_entity_decode($display_ap_list[0]["ap_courte_desc_fr"], ENT_QUOTES, "utf-8");
$ap_courte_desc_en 	= html_entity_decode($display_ap_list[0]["ap_courte_desc_en"], ENT_QUOTES, "utf-8");
$ap_desc_fr			= html_entity_decode($display_ap_list[0]["ap_desc_fr"], ENT_QUOTES, "utf-8");
$ap_desc_en			= html_entity_decode($display_ap_list[0]["ap_desc_en"], ENT_QUOTES, "utf-8");
//$ft_fr			= $dal["ap_fiche_tech_fr"];
//$ft_en			= $dal["ap_fiche_tech_en"];
$is_visible 		= $display_ap_list[0]["is_visible"];

}//END is_array($display_ap_list) 
?>

<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		<h1>--- Détail de <b><?php echo $ap_titre_fr; ?></b></h1>
		
		<div id="ap_header">
			<h3 class="setFloat_r">
				<a class="aTyp_1" href="?p=<?php echo $var_page; ?>">--- Retour à la liste ---</a>
			</h3>
			<img class="setFloat_l" src="<?php echo WWW_UP."appareils/resized/resized_".$img_index; ?>" alt="DD<?php echo $ap_titre_fr; ?>" />
			<img src="<?php echo WWW_UP."fabricants/fab_thumb/thumb_".$fab_logo; ?>" alt="<?php echo $fabricant; ?>" />
			<h4><b>Courte description FR :</b> </h4>
			<p>
				<?php echo $ap_courte_desc_fr;?>
			</p>
			<h4><b>Courte description EN :</b> </h4>

			<p>
				<?php echo $ap_courte_desc_en;?>
			</p>
		<div class="clearFloat"></div>
		</div>
		<div id="ap_content">
		<h4><b>Description FR : </b></h4>
			<?php echo $ap_desc_fr;?>
		<h4><b>Description EN : </b></h4>
			<?php echo $ap_desc_en;?>
		</div>
		<div id="ap_footer">
			&nbsp;
		</div>
		<div class="clearFloat"></div>
	</div><!--END .mainBloc-->
</div><!--END .bloc_deco-->