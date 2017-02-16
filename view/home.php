
<div id="slide_deco" class="bloc_deco">
 	
	<div id="container">
			<div id="slides">
				<div class="slides_container">
<?php
if(is_array($display_slides) && !empty($display_slides)){
	foreach($display_slides AS $ds){
		$slide_id		= $ds["slide_id"];
		$slide_img  	= $ds["slide_img"];
		$slide_txt_fr	= html_entity_decode($ds["slide_txt_fr"],ENT_QUOTES, "UTF-8");
		$slide_txt_en	= html_entity_decode($ds["slide_txt_en"],ENT_QUOTES, "UTF-8");
		$is_visible		= $ds["is_visible"];
		$date_add		= dateUs2Fr($ds["date_add"]);
		
		if($is_visible == "1"){
?>

<!-- ici les slides -->

				<div class="slide">
						<img src="<?php echo WWW_UP."slides/".$slide_img ?>"  width="1000" height="300" alt="">
					<div class="caption">
						<p>
							<?php echo $get_lang == "fr"? $slide_txt_fr:$slide_txt_en;?>
						</p>
					</div>
				</div>
					
<!--ici la fin des slides-->

<?php
		}
	}
}

?>
				</div><!--.slides_container-->
				<a href="#" class="prev"><img src="img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div><!--slides-->
	</div><!--#container-->

<div class="clearFloat"></div>
</div><!--END #slide_deco-->

<div id="blocNew_deco" class="bloc_deco">
    <div id="blocNew" class="mainBloc">
        
        <div id="blocNewProd" class="setFloat_l">
            <h4>Derniers appareils en ligne</h4>
<?php
if(isset($displayLastAp) && is_array($displayLastAp)){
	foreach($displayLastAp AS $dla){
		$ap_id		= $dla["ap_id"];
		$img_index	= $dla["ap_img_index"];
		$titre_fr 	= $dla["ap_titre_fr"];
		$titre_en	= $dla["ap_titre_en"];
		
		$img_index = WWW_UP."appareils/resized/resized_".$img_index;
		list($width, $height, $type, $attr) = getimagesize($img_index);
?>
			 <a href="?lang=<?php echo $get_lang;?>&p=appareil&action=detail&ap_id=<?php echo $ap_id;?>">
			 	<img class="imgIndexHome" src="<?php echo $img_index; ?>" width="<?php echo $width."px";?>" height="<?php echo $height."px";?>" alt="<?php echo $get_lang == "fr"? $titre_fr : $titre_en; ?>" />
			 </a>

<?php
	}
}

?>
        </div>
        
        <div id="blocNewTech" class="setFloat_l">
            <h4>Derniers articles postés</h4>
 <?php
if(isset($displayLastArt) && is_array($displayLastArt)){
	foreach($displayLastArt AS $dla){
		$art_id 		= $dla["article_id"];
		$lang			= $dla["langue"];
		$img_index		= $dla["img_index"];
		$article_titre 	= $dla["article_titre"];
		
		$img_index = WWW_UP."articles/resized/resized_".$img_index;
		//print_q($img_index);
		list($width, $height, $type, $attr) = getimagesize($img_index);
?>          
		<div class="setFloat_l artHome">
 			<div style="width: 235px; height: 235px; overflow: hidden;">
				<a href="?lang=<?php echo $get_lang;?>&p=articles&action=detail&art_id=<?php echo $art_id;?>">
					 <img class="imgIndexHome" src="<?php echo $img_index ?>"width="<?php echo $width."px";?>" height="<?php echo $height."px";?>" alt="<?php echo $article_titre;?>" />
				 </a>
				 <p><?php echo $article_titre;?></p>	
			</div>	
       </div> 
           
<?php
		
	}
}
?>

        </div>
        
    <div class="clearFloat"> </div>
    </div><!--END #blocNew-->
    <div class="clearFloat"> </div>
</div><!--END #blocNew_deco-->

<div id="freeArea_deco" class="bloc_deco">
    <div id="freeArea" class="mainBloc">
        <h4 class="blocFreeArea_l setFloat_l"><a href="?lang=<?php echo $get_lang;?>&p=articles&action=view&id_sect=1">Actus Appareils Multimedia</a></h4>
        <h4 class="blocFreeArea_l setFloat_l"><a href="?lang=<?php echo $get_lang;?>&p=articles&action=view&id_sect=67">Internet</a></h4>
        <h4 class="blocFreeArea_r setFloat_r"><a href="?lang=<?php echo $get_lang;?>&p=articles&action=view&id_sect=69">Jeux Vidéos</a></h4>
        <h4 class="blocFreeArea_r setFloat_r"><a href="?lang=<?php echo $get_lang;?>&p=articles&action=view&id_sect=70">Technologies bien être</a></h4>
   </div><!--END #freeArea-->
   <div class="clearFloat"> </div>
</div><!--END #freeArea_deco-->

