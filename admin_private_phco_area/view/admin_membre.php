<div id="main_bloc_page" class="bloc_deco">
	<div class="mainBloc">
		<h1>Gestion des membres inscrits sur Phone&amp;Co&nbsp; :</h1>
		<p>&nbsp;</p>
		<p><?php echo $show_txt_page; ?></p>
<?php

switch ($get_typ_form) {
	case 'view':
		
?>

<!--// link add new member -->

	<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=add title='add'>
			        <img src="img/add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=add title='add'>
			    	<h4>Ajouter un membre Phone&amp;Co</h4>
			    </a>
			</td>
		</tr>
	</table>
	<hr class='hrSepar'/>
<!--// END link add new member -->

<!--// sorting management -->
<form action=?p=<?php echo $var_page;?>&typ_form=<?php echo $get_typ_form; ?> method="POST">
	<p style="text-align: center;">
		<!--//filter_1-->
		<label for="visib">Est visible sur le site : </label>
		<input type="radio" name="filter_1" value="1" <?php echo isset($post_filter_1) && ($post_filter_1 == "1") ? " checked=\"checked\"" : ""; ?> />Oui
		<input type="radio" name="filter_1" value="0" <?php echo isset($post_filter_1) && ($post_filter_1 == "0") ? " checked=\"checked\"" : ""; ?> />Non
		<input type="radio" name="filter_1" value="" <?php echo isset($post_filter_1) && ($post_filter_1 == "") ? " checked=\"checked\"" : ""; ?> />Tous
		
		<!--//filter_2-->
		<label>&nbsp;|&nbsp;Trier par&nbsp;:&nbsp;</label>
		<select id="" class="" name="filter_2">
	
		<?php 
		$sort_typ = array(
		'' => '',
		'langue' => 'Langue',
		'prenom' => 'Pr&eacute;nom',
		'nom' => 'Nom',
		'pseudo'=>'Pseudo',
		'email' => 'E-mail',
		'ville'=>'Localit&eacute;',
		'date_naiss'=>'Date de naissance',
		'newsletter_inscript' => 'Inscription à la newsletter', 
		'date_add' => 'Date d\'inscription');	
		
			foreach($sort_typ AS $sort =>$val){
				if($sort != "is_visible"){

		?>	
			<option value="<?php echo $sort; ?>" <?php echo (isset($post_filter_2) && $post_filter_2 == $sort)? " selected='selected'": ""; ?>>
				<?php echo $val; ?>
			</option>
		<?php
				}
			}
		//}
		?>
		
		</select>
		
		<input type="radio" name="order" value="ASC"<?php echo isset($post_order) && ($post_order == "ASC")? " checked=\"checked\"" : ""; ?> />Croissant
		<input type="radio" name="order" value="DESC"<?php echo isset($post_order) && ($post_order == "DESC")? " checked=\"checked\"" : ""; ?>/>D&eacute;croissant&nbsp;&nbsp;
		</p>
		<p style="text-align: center;">
		<!--// A compléter avec les variables définitives -->
		<select class="" name="filter_3">
			<option value="<?php echo (isset($post_filter_3) && !empty($post_filter_3)) ? "contient": "contient"; ?>">Contient</option>
			<option value="<?php echo (isset($post_filter_3) && !empty($post_filter_3)) ? "commence": "commence"; ?>">Commence par</option>
			<option value="<?php echo (isset($post_filter_3) && !empty($post_filter_3)) ? "egal": "egal"; ?>">Est &eacute;gal à</option>
		</select>
		<input class="inputTyp_1" type="search" name="user_data" value="<?php echo (isset($post_user_data) && !empty($post_user_data)) ? trim($post_user_data): ""; ?>" />&nbsp;
		<!--// A compléter avec les variables définitives -->
		
		<!--// SUBMIT-->
		<input type="submit" name="submit" value="OK"/>
	</p>
</form>
<!--// fin du moteur de recherche-->
<!--// Affichage de la liste-->
	<table id='tab_list'>
		<th>action</th><th>lg</th><th>avatar</th><th>name</th><th>pseudo</th><th>e-mail</th><th>date <br />inscription</th><th></th><th></th>
		
	<?php
			
	if(isset($display_user_list) && is_array($display_user_list)){
    	
	    foreach($display_user_list as $dml){
	    	$membre_id    	= convertFromDB($dml["membre_id"]);
			$membre_lg    	= convertFromDB($dml["langue"]);
			$avatar			= convertFromDB($dml["avatar"]);
	    	$prenom         = convertFromDB($dml["prenom"]);
	        $nom            = convertFromDB($dml["nom"]);
			$pseudo         = convertFromDB($dml["pseudo"]);
			$email          = convertFromDB($dml["email"]);
			$is_visible		= convertFromDB($dml["is_visible"]);
			$date_add		= convertFromDB($dml["date_add"]);
	        //$actif          = convertFromDB($r["actif"]);
	        
	        if($avatar != "no_avatar.jpg"){
	        	$display_avatar = WWW_UP."avatar/resized_".$avatar;
	        }else{
	        	$display_avatar = WWW_UP."avatar/".$no_avatar;
	        }
	    ?>
	    <tr>
	    <?php  
	        if($is_visible == "1"){
		?>
		
		    <td class='td_action'>
		        <!--// DELETE -->
		        <a href='index.php?p=<?php echo $var_page; ?>&typ_form=delete&id=<?php echo $membre_id; ?>' title='delete'>
		            <img src='img/del.jpg' alt='delete' class='' />
		        </a>
		        <!--// UPDATE -->
		        <a href='index.php?p=<?php echo $var_page; ?>&typ_form=update&id=<?php echo $membre_id; ?>' title='update'>
		            <img src='img/edit.jpg' alt='edit' class='' />
		        </a>
		     </td>
		    
		<?php
		}else{
		?>
			
		<!--// REACTIVE-->
			<td class='td_action'>
		    	<a href='index.php?p=<?php echo $var_page; ?>&typ_form=reactive&id=<?php echo $membre_id; ?>' title='reactive'>
		            <img src='img/reactivate.jpg' alt='supprimer' class='ico_action' />
		        </a>
		    </td>
		<?php
		}
		?>
		     <!--// LANGUAGE -->
		     <td class='td_lg'>
		     	<span class=''><?php echo $membre_lg; ?></span>
		     </td>
		     <!--// AVATAR -->
		     <td class='td_avat'>
		     	<img src="<?php echo $display_avatar; ?>" alt="avatar_<?php echo $nom; ?>"/>
		     </td>
		     <!--// NAME -->
		     <td class='td_name'>
		     	<span><?php echo $prenom." ".$nom; ?></span>
		     </td>
		     <!--// PSEUDO -->
		     <td class='td_pseudo'>
		     	<span class=''><?php echo $pseudo; ?></span>
		     </td>
		     <!--// EMAIL-->
		     <td>
		     	<span class=''><?php echo $email; ?></span>
		     </td>
		     <!--// REGISTRATION DATE-->
		     <td>
		     	<span class=''><?php echo dateUs2Fr($date_add); ?></span>
		     </td>
		</tr>
	
		<?php
			}//END foreach
		}else{
		echo "<h2>Désolé. Aucun résultat ne correspond à votre recherche.</h2>";
		}
?>
	</table>
<?php

break;
//END case:"view"
/*+++++++++++++++++++++++++++++++++++++++++++++++ add +++++++++++++++++++++++++++++++++++++++++++++++++++*/
case "add":
	if($display_form){
?>

<h2>Ajouter un nouveau membre Phone&amp;Co :</h2>
<form action=?p=<?php echo $var_page;?>&typ_form=<?php echo $get_typ_form; ?> method="POST" lang="en" enctype="multipart/form-data">
	<div class="bloc_form_1">	
		<!--<p><input type="hidden" name="lang" value="<?php echo $get_lang; ?>"/></p>-->
		
		<p><label class="labelTyp_1" for="lang">Langue&nbsp;:&nbsp;</label>
			<?php 
			echo isset($post_lg) && ($post_lg = "en")? "<input type='radio' name='lang' value='en' checked='checked' />" 
			: "<input type='radio' name='lang' value='en' />"; ?> EN
			
			<?php 
			echo isset($post_lg) && ($post_lg = "fr")? "<input type='radio' name='lang' value='fr' checked='checked' />" 
			: "<input type='radio' name='lang' value='fr' />" ?> FR
		</p>
					
		<p><label class="labelTyp_1" for="first_name">Prénom&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_fname; ?>" name="first_name" type="text" required="required" value="<?php echo isset($post_first_name) && !empty($post_first_name)?$post_first_name:""; ?> "/>
			<span class="reqField">*</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_fname</span>"; ?>
		</p>
		
		<p><label class="labelTyp_1" for="last_name">Nom&nbsp;:&nbsp;</label>
			<input class="inputTyp_1<?php echo $is_empty_lname; ?>" name="last_name" type="text" required="required" value="<?php echo isset($post_last_name) && !empty($post_last_name)? $post_last_name:""; ?>"/>
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
		
		<p><label class="labelTyp_1" for="avatar">Avatar&nbsp;:&nbsp;</label>
			<input type="file" name="src_fichier" /><span style="font-size: smaller">(JPG - GIF or PNG only )</span><br />
			<?php echo "<span class=\"dispErr\">$display_error_avatar</span>"; ?>
			<input type="hidden" name="src_fichier" value="<?php echo (isset($_FILES["src_fichier"]) && !empty($_FILES["src_fichier"]))? $_FILES["src_fichier"]: $_FILES["src_fichier"] ;?>" />
			<?php var_dump($_FILES["src_fichier"]);?>
		</p>
	
		<p><label class="labelTyp_1" for="city">Ville&nbsp;:&nbsp;</label>
			<input class="inputTyp_1" type="text" name="city" value="<?php echo isset($post_city) && !empty($post_city)?$post_city:""; ?>"/><br />
			<?php echo "<span class=\"dispErr\">$display_error_city</span>"; ?>
		</p>
		<p><label class="labelTyp_1" for="birth">Date de <br />naissance&nbsp;:&nbsp;</label>
			<select class="<?php echo $is_empty_day; ?>" name="b_day" required="required">

				<option></option>
				<?php
					for($i=1; $i<31; $i++){
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
		<p><label for="nl_regist">Inscription &agrave; la la newsletter&nbsp;:&nbsp;</label>
			<input type="radio" value="1" name="nl_regist" checked="checked" <?php echo (isset($post_nl_regist) && !empty($post_nl_regist))? " checked='checked'" : "" ; ?>/>OUI
			<input type="radio" value="0" name="nl_regist" <?php echo (isset($post_nl_regist) && !empty($post_nl_regist))? " checked='checked'" : "" ; ?>/>NON
		</p>
		
		<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
	</div><!--END .bloc_form_2-->
	<div class="clearFloat"></div>
</form>

<?php
}else{
?>
	<table id="tab_add">
		<tr>
			<td>&nbsp;</td>
			<!--// ADD-->
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=add title='add'>
			        <img src="img/add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=add title='add'>
			    	<h4>Ajouter un membre Phone&amp;Co</h4>
			    </a>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<!--// RETURN TO THE LIST -->
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=view title='return'>
			        <img src="img/add.jpg" alt='add' class=''/>
			    </a>
			</td>
			<td>
			    <a href=index.php?p=<?php echo $var_page; ?>&typ_form=view title='return'>
			    	<h4>Retourner à la liste&nbsp;:&nbsp;</h4>
			    </a>
			</td>
		</tr>
		
	</table>
<?php
}
break;
//END case "add":

case "update":
	echo $show_txt_page;
	
	if($display_form){
		
		//requete
			$result = getUser($get_user_id, 0, 0);			
			
			// SI REQUETE OK
			if(isset($result) && is_array($result)){
				//affectation des vars
				foreach($result AS $r){
					$post_lg		= convertFromDB($r['langue']);
					$first_name 	= convertFromDB($r['prenom']);//test avec f_name -> ok
					$last_name 		= convertFromDB($r['nom']);
					$pseudo 		= convertFromDB($r['pseudo']);
					$email			= convertFromDB($r['email']);
					$password  		= "";
					$avatar			= convertFromDB($r['avatar']);
					$city			= convertFromDB($r['ville']);
					
					if($birthday_db		= convertFromDB($r['date_naiss'])){//evite le message d'erreur si slmt email
						$birthday_db 	= explode("-", convertFromDB($r['date_naiss']));
						$day 		= $birthday_db[2];
						$month 		= $birthday_db[1];
						$year 		= $birthday_db[0];
					$birthday_comp	= $birthday_db[0]."-".$birthday_db[1]."-".$birthday_db[2];
					}
					
					$nl_regist		= convertFromDB($r['newsletter_inscript']);
					$is_visible		= convertFromDB($r['is_visible']);
					$date_add		= dateUs2Fr((convertFromDB($r['date_add'])));
					
				}//END foreach data
					
				}else{// END isset($result)
					echo "<p>Pas de résultats obtenus.</p>";
				}

?>
<form action=?p=<?php echo $var_page;?>&typ_form=<?php echo $get_typ_form; ?>&id=<?php echo $get_user_id ;?> method="POST" enctype="multipart/form-data">
	<div class="bloc_form_1">	
		<!--<p><input type="hidden" name="lang" value="<?php echo $get_lang; ?>"/></p>-->
		<p>
			Membre ajouté le : 
			<input style="text-align: right; padding: 2px; border: none;" type="text" name="date_add" value="<?php echo isset($post_date_add) && !empty($post_date_add) ? $post_date_add:$date_add; ?>" disabled="disabled" />
		</p>

		<p><label class="labelTyp_1" for="is_visible">Visible&nbsp;:&nbsp;</label>
			<input type="radio" name="is_visible" value="1" <?php echo (isset($post_is_visible) && ($post_is_visible == '1')) ? " checked='checked'":""; ?> />Oui&nbsp;
			<input type="radio" name="is_visible" value="0" <?php echo (isset($post_is_visible) && ($post_is_visible == '0')) ? " checked='checked'":""; ?> />Non
		</p>
		
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
			
			<input type="text" name="old_avat" value="<?php echo (isset($avatar) && !empty($avatar))? $avatar : $post_src_fichier ;?>"/>
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
		<p><input type="submit" name="submit" value="OK" />&nbsp;<input type="reset" name="reset" value="Reset"/></p>
	</div><!--END .bloc_form_2-->
	<div class="clearFloat"></div>
</form>

<?php

}//END if(display_form) case update

break;
// END case "update":

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
?>
<h1>Inscription à la newsletter</h1>
<form action="./" method="POST" lang="en" enctype="multipart/form-data">
<div class="bloc_form_1">
	<p><label class="labelTyp_1" for="email">E-mail&nbsp;:&nbsp;</label>
		<input class="inputTyp_1" name="email" type="text" required="required" />
	</p>
</div>
	<p><input type="submit" value="OK" />&nbsp;<input type="reset" value="Reset"/></p>
</form>
	
<?php
				break;
		}// END switch $get_typ_form

?>


</div><!--END .mainBloc-->
</div><!--END #main_bloc_page-->
    </table>