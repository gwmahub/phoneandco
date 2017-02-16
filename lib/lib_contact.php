<?php

function sendMailContact($email, $lang) {
    $destinataire = "info@phoneandco.be";
    $sujet 	= $lang == 'fr'?"Phone&amp;Co - contact": "Phone&amp;Co - contact";
    $entete = "From:Phone&amp;Co <info@phoneandco.be>";
    $entete .='MIME-Version: 1.0' . "\r\n";
    $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    $message = $lang == 'fr'?"<p>Bonjour,</p>
    <p>J'ai bien reçu votre message et y répond au plus vite.</p>
    <p>---------------</br>Ceci est un mail automatique. Merci de ne pas y repondre.</p>":
	"<p>Hello,</p>
    <p>I received you message and reply as soon as possible.</p>
    <p>---------------</br>This is an automatic email. Thank you not to answer.</p>";
    
	if (mail($destinataire, $sujet, $message, $entete)) {
		$show_txt_page .= $lang == 'fr'?"<h3>Votre message a bien été envoyé.</h3>": "<h3>Your message has been sent.</h3>";
	    return true;
	} else {
		$show_txt_page .= $lang == 'fr'?"<h3>Une erreur est survenue, veuillez réessayer ultérieurement.</h3>": "<h3>An error occured, please try again later..</h3>";
	    return false;
	}
   
}
?>