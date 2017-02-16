<?php
if($get_lang){
	switch($get_lang){
		case "en":
			if(isset($_SESSION["m_pseudo"]) && isset($_SESSION["m_actif"])){//
?>

<div id="blocPerso" class="setFloat_r">
	<h3 class="setFloat_l">Welcome <?php echo $_SESSION["m_pseudo"] ; ?> 
		<img src="<?php echo WWW_UP."avatar/resized_".$_SESSION['m_avatar']; ?>" alt="Avatar"/>
	</h3>
	<a title="userAccount" class="setFloat_l" href="?&lang=en&p=account_user">My account</a>
	<a title="logOut" href="?p=unlog">Exit</a>
	<div class="clearFloat"></div>
</div>

<?php
			}else{
?>
<div id="loginForm" class="setFloat_r">
	<form action=?lang=<?php echo $get_lang; ?>&p=<?php echo $var_page; ?>&typ_form=login method="POST">
        <span>Phone&amp;Co member ?&nbsp;</span>
        
        <label for="pseudo">Pseudo:&nbsp;</label>
        <?php echo "<span class='dispErr'>".$display_error_pseudo."</span>" ;?>
        <input id="pseudo" class="inputTyp_1" type="text" name="pseudo" required="required" />
        
        <label for="password">Password:&nbsp;</label>
        <input id="password" class="inputTyp_1" type="password" name="password" required="required"/>
        <?php echo "<span class='dispErr'>".$display_error_psw."</span>" ;?>
        <input type="submit" name="submit" value="OK"/>
        <?php echo "<span class='dispErr'>".$msg."</span>" ;?>
        <br />
	</form>
</div><!--END #loginForm-->
	<p id="homeLinksUser" class="setFloat_l">
		<a title="inscription" href=?lang=en&p=index_forms&typ_form=new_register> &rarr;&nbsp;I want to register</a>
		<!--<a title="forgottenPswd" href=?lang=en&p=index_forms&typ_form=pass_forgot> &rarr;&nbsp;I forgot my password</a>
		<a title="newsletter" href=?lang=en&p=index_forms&typ_form=news_letter> &rarr;&nbsp;Subscribe to the newsletter</a>-->
	</p>
<?php
			}

			break;
			
		default:
			
			if(isset($_SESSION["m_pseudo"]) && isset($_SESSION["m_actif"])){
?>

<div id="blocPerso" class="setFloat_r">
	<h3 class="setFloat_l">Bonjour <?php echo $_SESSION["m_pseudo"] ; ?> 
		<img src="<?php echo WWW_UP."avatar/resized_".$_SESSION['m_avatar']; ?>" alt="Avatar"/>
	</h3>
	<a title="userAccount" class="setFloat_l" href="?&lang=fr&p=account_user">Mon compte</a>
	<a title="logOut" href="?p=unlog">Exit</a>
	<div class="clearFloat"></div>
</div>

<?php
			}else{
?>
<div id="loginForm" class="setFloat_r">
	<form action=?lang=<?php echo $get_lang; ?>&p=<?php echo $var_page; ?>&typ_form=login method="POST">
        <span>Phone&amp;Co member ?&nbsp;</span>
        
        <label for="pseudo">Pseudo:&nbsp;</label>
        <?php echo "<span class='dispErr'>".$display_error_pseudo."</span>" ;?>
        <input id="pseudo" class="inputTyp_1" type="text" name="pseudo" required="required" />
        
        <label for="password">Password:&nbsp;</label>
        <input id="password" class="inputTyp_1" type="password" name="password" required="required"/>
        <?php echo "<span class='dispErr'>".$display_error_pseudo."</span>" ;?>
        <input type="submit" name="submit" value="OK"/>
        <?php echo "<span class='dispErr'>".$msg."</span>" ;?>
        <br />
	</form>
</div><!--END #loginForm-->

	<p id="homeLinksUser" class="setFloat_l">
		<a title="inscription"  href=?lang=fr&p=index_forms&typ_form=new_register>&rarr;&nbsp;Je souhaite m'inscrire</a>
		<!--<a title="forgottenPswd" href=?lang=fr&p=index_forms&typ_form=pass_forgot> &rarr;&nbsp;Oubli mon mot de passe</a>
		<a title="newsletter" href=?lang=fr&p=index_forms&typ_form=news_letter> &rarr;&nbsp;Recevoir la newsletter</a>-->
	</p>
<?php
			break;
		
		}
	
	}
}

?>