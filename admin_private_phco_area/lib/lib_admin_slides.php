<?php

function getSlides($slide_id, $order , $limit_dbt, $limit_fin){
	if(!is_numeric($slide_id)){
		return false;
	}
	
	$sql_slide = "SELECT slide_id, slide_img, slide_txt_fr, slide_txt_en, is_visible, date_add FROM pac_slide_pub ";
	
	if($slide_id != null){
		$sql_slide .= " WHERE slide_id = '$slide_id' ";
	}
	
	if($order != null){
		$sql_slide .= "ORDER BY slide_id $order ";
	}

	if($limit_dbt != null || $limit_fin != null){
		$sql_slide .= "LIMIT $limit_dbt , $limit_fin ";
	}
	
	
	//echo $sql_slide;
	
	if($display_slides = requeteResultat($sql_slide)){
		return $display_slides;
	}else{
		return false;
	}
}


function insertSlide($slide_img, $slide_txt_fr, $slide_txt_en, $is_visible){
	$slide_img 		= convert2DB($slide_img);
	$slide_txt_fr 	= convert2DB($slide_txt_fr);
	$slide_txt_en 	= convert2DB($slide_txt_en);
	$is_visible 	= convert2DB($is_visible);
	
	$sql_insert_slide = "INSERT INTO pac_slide_pub (slide_img, slide_txt_fr, slide_txt_en, is_visible, date_add)
						VALUES ('$slide_img','$slide_txt_fr','$slide_txt_en', '$is_visible', NOW())";
	
	//echo $sql_insert_slide;
	return ExecRequete($sql_insert_slide)?true:false;
}

function updateSlide($slide_id, $slide_img, $slide_txt_fr, $slide_txt_en){
	$slide_img 		= convert2DB($slide_img);
	$slide_txt_fr 	= convert2DB($slide_txt_fr);
	$slide_txt_en 	= convert2DB($slide_txt_en);
	
	$sql_upd_slide = "UPDATE `pac_slide_pub`
					  SET
					  `slide_img` 		= '$slide_img',
					  `slide_txt_fr` 	= '$slide_txt_fr',
					  `slide_txt_en` 	= '$slide_txt_en'
					  
					  WHERE `slide_id` 	= '$slide_id'";
					  
	return ExecRequete($sql_upd_slide)?true:false;
}

function delReactiveSlide($slide_id, $is_visible){
	if(!is_numeric($slide_id)){
		return false;
	}
	
	$sql = "UPDATE `pac_slide_pub`
		  	SET
			`is_visible` = '$is_visible'
		  
		 	 WHERE `slide_id` = '$slide_id'";
	//echo $sql;
	return ExecRequete($sql)?true:false;
}








?>