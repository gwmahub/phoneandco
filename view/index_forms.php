
<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
<?php

switch($get_lang){
/*----------------------------- en ------------------------------------*/		
	case "en":
		
		switch ($get_typ_form) {
			case 'new_register':
				if($display_form){
?>

<h1>New registration... Welcome new visitor !</h1>
<form action=?lang=<?php echo $get_lang;?>&p=index_forms&typ_form=<?php echo $get_typ_form; ?> method="POST" enctype="multipart/form-data">
<div class="bloc_form_1">	
	<!--<p><input type="hidden" name="today" value="<?php echo date("Y-m-d"); ?>"/></p>-->
	<p><input type="hidden" name="lang" value="<?php echo isset($get_lang) && !empty($get_lang) ? $get_lang: ""; ?>"/></p>
	
	<p><label class="labelTyp_1" for="first_name">First name&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_fname; ?>" name="first_name" type="text" required="required" value="<?php echo isset($post_first_name) && !empty($post_first_name)? $post_first_name:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_fname</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="last_name">Last name&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_lname; ?>" name="last_name" type="text" required="required" value="<?php echo isset($post_last_name) && !empty($post_last_name)?$post_last_name:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_lname</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_pseudo; ?>" name="pseudo" type="text" required="required" value="<?php echo isset($post_pseudo) && !empty($post_pseudo)?$post_pseudo:""; ?>" />
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_pseudo</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php echo isset($post_email) && !empty($post_email)?$post_email:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="email_confirm">E-mail&nbsp;<br />confirm:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email_confirm" type="text" required="required" value="<?php echo isset($post_email_2) && !empty($post_email_2)?$post_email_2:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email_2</span>"; ?>
	</p>
	
	<p><label class="labelTyp_1" for="password">Password&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_psw; ?>" name="password" type="password" required="required" value="<?php echo isset($post_password) && !empty($post_password)?$post_password:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_psw</span>"; ?>
	</p>

</div><!--END.bloc_form_1-->

<div class="bloc_form_2">
	
	<p><label class="labelTyp_1" for="avatar">Avatar&nbsp;:&nbsp; </label>
		<input type="file" name="src_fichier" /><span style="font-size: smaller">(JPG - GIF or PNG only )</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_avatar</span>"; ?>
		
	</p>

	<p><label class="labelTyp_1" for="city">City&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" type="text" name="city" value="<?php echo isset($post_city) && !empty($post_password)?$post_city:""; ?>"/><br />
		<?php echo "<span class=\"dispErr\">$display_error_city</span>"; ?>
	</p>
	<p><label class="labelTyp_1" for="birth">Birthday&nbsp;:&nbsp;</label>
			<select class="<?php echo $is_empty_day; ?>" name="b_day" required="required">

				<option></option>
				<?php 
					for($i=1; $i<=31; $i++){
						echo ($post_day == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			
			<select class="<?php echo $is_empty_month; ?>" name="b_month" required="required">
				<option></option>
				<?php
			
					for($i=1; $i<13; $i++){
						echo ($post_month == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			<select class="<?php echo $is_empty_year; ?>" name="b_year" required="required">
				<option></option>
				<?php 
					for($i=date("Y"); $i>1930; $i--){
						echo ($post_year == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			<span class="reqField">*</span>
		</p>
			
		<p>
			<label for="nl_regist">I wisth to receive the newsletter&nbsp;:&nbsp;</label>			
				<?php 
				echo (isset($post_nl_regist) && $post_nl_regist == "1")? 
				"<input type='radio' name='nl_regist' value='1' checked='checked' />"
				: "<input type='radio' name='nl_regist' value='1' />"
				?> YES
				<?php 
				echo (isset($post_nl_regist) && $post_nl_regist == "0")? 
				"<input type='radio' name='nl_regist' value='0' checked='checked' />"
				: "<input type='radio' name='nl_regist' value='0' />"
				?> NO 
		</p>
		
		<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
</div><!--END .bloc_form_2-->
<div class="clearFloat"></div>
</form>

<?php					
				}else{
					echo $show_txt_page;
				}//END if $display_form

				break;
				
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
			case "validation":
?>

				<h1>Your account is validated ! Congratulations :-)</h1>
<?php				
				echo $show_txt_page;
				break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
			case "pass_forgot":
?>
<h1>I forgot my password :-(</h1>
<form action="./" method="POST" lang="en" enctype="multipart/form-data">
<div class="bloc_form_1">	

	<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" name="pseudo" type="text" required="required" /></p>
	
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" name="email" type="text" required="required" /></p>
</div>
<div class="bloc_form_2">
	
	<p><input type="submit" value="OK" />&nbsp;<input type="reset" value="Reset"/></p>
</div>
</form>

<?php
				break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

			case "news_letter" :
				
				if($display_form){
?>
<h1>Subscribe to the newsletter</h1>
<form action=?lang=<?php echo $get_lang;?>&p=<?php echo $var_page;?>&typ_form=<?php echo $get_typ_form; ?> method="POST" enctype="multipart/form-data">
<div class="bloc_form_1">
	
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php echo isset($post_email) && !empty($post_email) ? $post_email:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
	</p>
	
</div>
<div class="bloc_form_2">
	<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
</div>
</form>
<?php
					echo $show_txt_page;
				}else{
					echo $show_txt_page;

				}

				break;//END case "news_letter" :
		}// END switch $get_typ_form
		
	break;
		
/*----------------------------- fr ------------------------------------*/		
		
	default:
		switch ($get_typ_form) {
			case 'new_register':
				if($display_form){
?>

<h1>Nouvelle inscription... Bienvenue visiteur !</h1>
<form action=?lang=<?php echo $get_lang;?>&p=index_forms&typ_form=<?php echo $get_typ_form; ?> method="POST" enctype="multipart/form-data">
<div class="bloc_form_1">	
	<!--<p><input type="hidden" name="today" value="<?php echo date("Y-m-d"); ?>"/></p>-->
	<p><input type="hidden" name="lang" value="<?php echo $get_lang; ?>"/></p>
	
	<p><label class="labelTyp_1" for="first_name">Prénom&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_fname; ?>" name="first_name" type="text" required="required" value="<?php echo isset($post_first_name) && !empty($post_first_name)? $post_first_name:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_fname</span>"; ?>
	</p>
			
	<p><label class="labelTyp_1" for="last_name">Nom&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_lname; ?>" name="last_name"  type="text" required="required" value="<?php echo isset($post_last_name) && !empty($post_last_name)?$post_last_name:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_lname</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_pseudo; ?>" name="pseudo" type="text" required="required" value="<?php echo isset($post_pseudo) && !empty($post_pseudo)?$post_pseudo:""; ?>" />
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_pseudo</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php if($get_email){echo $get_email;}else{echo isset($post_email) && !empty($post_email)? $post_email : ""; } ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
	</p>
		
	<p><label class="labelTyp_1" for="email_confirm">Confirmation <br />de l'e-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email_confirm" type="text" required="required" value="<?php echo isset($post_email_2) && !empty($post_email_2)?$post_email_2:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email_2</span>"; ?>
	</p>
	
	<p><label class="labelTyp_1" for="password">Password&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_psw; ?>" name="password" type="password" required="required" value="<?php echo isset($post_password) && !empty($post_password)?$post_password:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_psw</span>"; ?>
	</p>

</div><!--END.bloc_form_1-->

<div class="bloc_form_2">
	
	<p><label class="labelTyp_1" for="avatar">Avatar&nbsp;:&nbsp; </label>
		<input type="file" name="src_fichier" /><span style="font-size: smaller">(JPG - GIF or PNG only )</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_avatar</span>"; ?>
	</p>

	<p><label class="labelTyp_1" for="city">Ville&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" type="text" name="city" value="<?php echo isset($post_city) && !empty($post_password)?$post_city:""; ?>"/><br />
		<?php echo "<span class=\"dispErr\">$display_error_city</span>"; ?>
	</p>
	<p><label class="labelTyp_1" for="birth">Date de <br />naissance&nbsp;:&nbsp;</label>
			<select class="<?php echo $is_empty_day; ?>" name="b_day" required="required">

				<option></option>
				<?php 
					for($i=1; $i<=31; $i++){
						echo ($post_day == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			
			<select class="<?php echo $is_empty_month; ?>" name="b_month" required="required">
				<option></option>
				<?php
			
					for($i=1; $i<13; $i++){
						echo ($post_month == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			<select class="<?php echo $is_empty_year; ?>" name="b_year" required="required">
				<option></option>
				<?php 
					for($i=date("Y"); $i>1930; $i--){
						echo ($post_year == $i)? "<option value='$i' selected=selected>$i</option>" : "<option value='$i'>$i</option>";
					}
				?>
			</select>
			<span class="reqField">*</span>
		</p>
	<p><label for="nl_regist">Je souhaite recevoir la newsletter&nbsp;:&nbsp;</label>
		<?php 
			echo (isset($post_nl_regist) && $post_nl_regist == "1")? 
			"<input type='radio' name='nl_regist' value='1' checked='checked' />"
			: "<input type='radio' name='nl_regist' value='1' />"
			?> OUI
			<?php 
			echo (isset($post_nl_regist) && $post_nl_regist == "0")? 
			"<input type='radio' name='nl_regist' value='0' checked='checked' />"
			: "<input type='radio' name='nl_regist' value='0' />"
			?> NON 
		
	</p>
	<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
</div><!--END .bloc_form_2-->
<div class="clearFloat"></div>
</form>

<?php					
				}else{
					echo $show_txt_page;
				}//END if $display_form

				break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
			case "validation":
?>

				<h1>Your account is validated ! Congratulations :-)</h1>
<?php				
				echo $show_txt_page;
				break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
			case "pass_forgot":
?>
<h1>J'ai perdu mon mot de passe :-(</h1>
<form action="./" method="POST" lang="en" enctype="multipart/form-data">
<div class="bloc_form_1">	

	<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" name="pseudo" type="text" required="required" /></p>
	
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" name="email" type="text" required="required" /></p>
</div>
<div class="bloc_form_2">
	
	<p><input type="submit" value="OK" />&nbsp;<input type="reset" value="Reset"/></p>
</div>
</form>

<?php
				break;
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

			case "news_letter" :
				
				if($display_form){
?>
<h1>Inscription à la newsletter</h1>
<form action=?lang=<?php echo $get_lang;?>&p=<?php echo $var_page;?>&typ_form=<?php echo $get_typ_form; ?> method="POST" enctype="multipart/form-data">
<div class="bloc_form_1">
	
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php echo isset($post_email) && !empty($post_email) ? $post_email:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
	</p>
	
</div>
<div class="bloc_form_2">
	<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
</div>
</form>
<?php
					echo $show_txt_page;
				}else{
					echo $show_txt_page;

				}

				break;//END case "news_letter" :
				
			
		}// END switch $get_typ_form
	break;
}//END $get_lang

?>


</div><!--END .mainBloc-->
</div><!--END #main_bloc_page-->