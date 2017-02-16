
<div id="" class="bloc_deco">
	<div id="" class="mainBloc">
		
	<h1><?php echo $get_lang == "fr"?"--- Gestion de mon compte ---":"--- Account Management ---";?></h1>
		
		<!--<div class="bloc_form_1">
			<h2><?php echo $get_lang == "fr"?"Mes données personnelles":"My personnal data";?></h2>
			
			<p><?php echo $get_lang == "fr"?"<b>Langue : </b>" :"<b>Language : </b>"; echo $user_lang == "fr"?" français":" English";?></p>
			<p><?php echo $get_lang == "fr"?"<b>Prénom</b> : " :"<b>First name : </b>"; echo $user_prenom;?></p>
			<p><?php echo $get_lang == "fr"?"<b>Nom : </b>":"<b>Last Name : </b>"; echo $user_nom;?></p>
			<p><?php echo $get_lang == "fr"?"<b>Pseudo : </b>":"<b>Pseudo : </b>"; echo $user_pseudo;?></p>
			<p><?php echo $get_lang == "fr"?"<b>Avatar :</b>":"<b>Avatar : </b>"; ?><img src="<?php echo WWW_UP."avatar/resized_".$user_avatar;?>"</p>
		</div>-->
<?php		
	echo $show_txt_page;
	

		//requete
			$result = getUserPub($user_id);			
			
			// SI REQUETE OK
			if(isset($result) && is_array($result)){
				//affectation des vars
					$user_id			= convertFromDB($result[0]['membre_id']);
					$post_lg			= convertFromDB($result[0]['langue']);
					$post_first_name 	= convertFromDB($result[0]['prenom']);//test avec f_name -> ok
					$post_last_name 	= convertFromDB($result[0]['nom']);
					$post_pseudo 		= convertFromDB($result[0]['pseudo']);
					$post_email			= convertFromDB($result[0]['email']);
					$post_password  	= "";
					$avatar				= convertFromDB($result[0]['avatar']);
					$post_city			= convertFromDB($result[0]['ville']);
					
					if($birthday_db		= convertFromDB($result[0]['date_naiss'])){//evite le message d'erreur si slmt email
						$birthday_db 	= explode("-", convertFromDB($result[0]['date_naiss']));
						$day 			= $birthday_db[2];
						$month 			= $birthday_db[1];
						$year 			= $birthday_db[0];
					$birthday_comp		= $birthday_db[0]."-".$birthday_db[1]."-".$birthday_db[2];
					}
					
					$post_nl_regist		= convertFromDB($result[0]['newsletter_inscript']);
					$post_is_visible	= convertFromDB($result[0]['is_visible']);
					$post_date_add		= dateUs2Fr((convertFromDB($result[0]['date_add'])));
										
				}else{// END isset($result)
					echo "<p>Vos données ne sont pas disponibles. Veuillez contacter l'administrateur.</p>";
				}

?>

<form action=?p=account_user&id=<?php echo $user_id ;?> method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">	

		<p><label class="labelTyp_1" for="lang">Langue&nbsp;:&nbsp;</label>
			<?php 
			echo (isset($post_lg) && ($post_lg == "en"))? "<input type='radio' name='lang' value='en' checked='checked' />" 
			: "<input type='radio' name='lang' value='en' />"; 
			?> EN&nbsp;
			
			<?php 
			echo (isset($post_lg) && ($post_lg == "fr"))? "<input type='radio' name='lang' value='fr' checked='checked' />" 
			: "<input type='radio' name='lang' value='fr' />" 
			?> FR
		</p>
					
		<p><label class="labelTyp_1" for="first_name">Prénom&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_fname; ?>" name="first_name" type="text" required="required" value="<?php echo isset($post_first_name) && !empty($post_first_name)? $post_first_name : $first_name; ?>"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_lname</span>"; ?>
		</p>
		
		<p><label class="labelTyp_1" for="last_name">Nom&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_lname; ?>" name="last_name" type="text" required="required" value="<?php echo isset($post_last_name) && !empty($post_last_name)? $post_last_name : $last_name; ?>"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_fname</span>"; ?>
		</p>
			
		<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_pseudo; ?>" name="pseudo" type="text" required="required" value="<?php echo isset($post_pseudo) && !empty($post_pseudo)?$post_pseudo:$pseudo; ?>" />
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_pseudo</span>"; ?>
		</p>
			
		<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_email; ?>" name="email" type="text" required="required" value="<?php echo isset($post_email) && !empty($post_email)?$post_email:$email; ?>"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_email</span>"; ?>
		</p>
		
		<p><label class="labelTyp_1" for="password">Password&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_psw; ?>" name="password" type="password" value="<?php echo isset($post_password) && !empty($post_password)?$post_password:""; ?>"/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_psw</span>"; ?>
		</p>
	
	</div><!--END.bloc_form_1-->
	
	<div class="bloc_form_2">
		<p>
			<label class="labelTyp_1" for="avatar">Avatar&nbsp;:&nbsp; </label>
			<img src="<?php echo WWW_UP."avatar/resized_".$avatar; ?>" alt="<?php echo $avatar;?>" />
			<br />
			<input type="file" name="src_fichier" /><span style="font-size: smaller">(JPG - GIF or PNG only )</span><br />
			
			<input type="hidden" name="old_avat" value="<?php echo (isset($avatar) && !empty($avatar))? $avatar : $post_src_fichier ;?>"/>
			<?php echo "<span class=\"dispErr\">$display_error_avatar</span>"; ?>
		</p>
	
		<p><label class="labelTyp_1" for="city">Ville&nbsp;:&nbsp;</label>
			<input class="inputTyp_1" type="text" name="city" value="<?php echo isset($post_city) && !empty($post_city)?$post_city:$post_city; ?>"/><br />
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
			<input type="radio" name="nl_regist" value="1" <?php echo (isset($post_nl_regist) && ($post_nl_regist == '1'))? " checked='checked'":"";?>/>OUI
			<input type="radio" name="nl_regist" value="0" <?php echo (isset($post_nl_regist) && ($post_nl_regist == '0'))? " checked='checked'":"";?>/>NON
		</p>
		<p><input type="submit" name="submit" value="ENVOYER" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
	</div><!--END .bloc_form_2-->
	<div class="clearFloat"></div>
</form>
		
		
<!--		
		<div class="bloc_form_2">
			<h2><?php echo $get_lang == "fr"?"Envoyer un article":"Send an article";?></h2>
			
			<form action="" method="POST">
				<input type="file" name="src_doc" />
				<input class="inputTyp_1" type="submit" name="submit" value="ENVOYER" />
			</form>
		</div>
-->
		
<div class="clearFloat"></div>
	</div>
</div>

