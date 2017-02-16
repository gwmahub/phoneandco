
<div id="login_admin" class="mainBloc">
	<h1>Bienvenue sur le site Phone&amp;Co&nbsp;</h1>
	
	<h4>Veuillez vous identifier</h4>
    <?php
	    if($get_state == "error"){
	        echo "<p><b><span class='rouge'>Login et/ou de mot-de-passe incorrect.</span></b></p>";
	    }
	    if(!empty($msg)){
	        echo $msg;
	    }
    ?>
	
	<form action=index.php?p=<?php echo $var_page; ?> method="POST">
		
	<p><label class="labelTyp_1" for="pseudo">Pseudo&nbsp;:&nbsp;</label>	
		<input class="inputTyp_1<?php echo $is_empty_pseudo; ?>" name="pseudo" type="text" required="required" value="<?php echo isset($post_pseudo) && !empty($post_pseudo)?$post_pseudo:""; ?>" />
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_pseudo</span>"; ?>
	</p>
	
    <p><label class="labelTyp_1" for="password">Password&nbsp;:&nbsp;</label>
		<input class="inputTyp_1<?php echo $is_empty_psw; ?>" name="password" type="password" required="required" value="<?php echo isset($post_password) && !empty($post_password)?$post_password:""; ?>"/>
		<span class="reqField">*</span><br />
		<?php echo "<span class=\"dispErr\">$display_error_psw</span>"; ?>
	</p>
	<p><input type="submit" name="submit" value="OK" /></p>
		
	</form>
    
    
    
</div><!--END #loginForm-->

