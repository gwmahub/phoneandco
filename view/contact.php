
<div id="main_bloc_page" class="bloc_deco">
<div class="mainBloc">
	
<?php 

switch ($get_action) {
		
	case 'view':
		if($display_form){
?>

<h1><?php echo $get_lang == "fr"? "Une question ?": "A question ?"; ?></h1>

<form action=?lang=<?php echo $get_lang; ?>&p=contact&action=view method="POST">

<div class="bloc_form_1">
<p><label class="labelTyp_1" for="first_name"><?php echo $get_lang == "fr"?"Pr&eacutenom":"First name&nbsp;:&nbsp;";?></label>
<input class="inputTyp_1<?php echo $is_empty_fname; ?>" name="first_name" type="text" required="required" value="<?php echo isset($post_first_name) && !empty($post_first_name) ? $post_first_name : ""; ?>"/>
<span class="reqField">*</span><br />
<?php echo "<span class=\"dispErr\">$display_error_fname</span>"; ?>
</p>

<p><label class="labelTyp_1" for="last_name"><?php echo $get_lang == "fr"?"Nom":"Last name&nbsp;:&nbsp;";?></label>
<input class="inputTyp_1<?php echo $is_empty_lname; ?>" name="last_name" type="text" required="required" value="<?php echo isset($post_last_name) && !empty($post_last_name) ? $post_last_name : ""; ?>"/>
<span class="reqField">*</span><br />
<?php echo "<span class=\"dispErr\">$display_error_lname</span>"; ?>
</p>

<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php echo isset($post_email) && !empty($post_email) ? $post_email : ""; ?>"/>
<span class="reqField">*</span><br />
<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
</p>

</div><!--END.bloc_form_1-->

<div class="bloc_form_2">
	<img src="<?php echo WWW_IMG."logo_phoneAndCo.png";?>" alt="logoWhite"/>	
	<img src="<?php echo WWW_IMG."logo_phoneAndCo_blackBg.jpg";?>" alt="logoGrey"/>
</div><!--END .bloc_form_2-->
<div class="clearFloat"></div>

<div class="bloc_form_3">
<!--//Zone txt msg -->
<?php echo "<span class=\"dispErr\">$display_error_msg</span>"; ?>
<textarea class="editme<?php echo $is_empty_msg;?>" rows="10" name="msg" cols="80"><?php echo isset($post_msg)&&!empty($post_msg)?$post_msg:"" ?></textarea><br />

<p style="text-align: center;">
	<input id="comment_submit" type="submit" name="submit" value="<?php echo $get_lang == "fr"?"Envoyer mon message":"Send my message" ?>" />
	&nbsp;<input type="reset" name="reset" value="Reset"/>
</p>
</div>
</form>


<?php	
	}else{
		echo $show_txt_page;//END if $display_form
	}		
		break;
		
}//END switch

?>

</div>
</div>
