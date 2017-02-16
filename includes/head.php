<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css"  rel="stylesheet" href="css/reset.css" media="all"/>
        <link type="text/css"  rel="stylesheet" href="css/main.css" media="all"/>
        <!--module google search-->
        <link type="text/css"  rel="stylesheet" href="css/g_search_engine.css" media="all"/>
        <!--slides-->
        <link rel="stylesheet" href="css/global.css">
        <link rel="shortcut icon" href="favicon.ico">
        
        <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script src="js/slides.min.jquery.js"></script>
		<script>
			$(function() {
				$('#slides').slides({
					preload : true,
					preloadImage : 'img/loading.gif',
					play : 7500,/*7500*/
					pause : 2500,/*2500*/
					hoverPause : true,
					animationStart : function(current) {
						$('.caption').animate({
							bottom : -35
						}, 100);
						if (window.console && console.log) {
							// example return of current slide number
							console.log('animationStart on slide: ', current);
						};
					},
					animationComplete : function(current) {
						$('.caption').animate({
							bottom : 0
						}, 200);
						if (window.console && console.log) {
							// example return of current slide number
							console.log('animationComplete on slide: ', current);
						};
					},
					slidesLoaded : function() {
						$('.caption').animate({
							bottom : 0
						}, 200);
					}
				});
			});
		</script>

		<script type="text/javascript">
		tinymce.init({
		    selector: "textarea.editme"
		 });
		</script>
        
	        <title>Phone&amp;Co Accueil </title><!--title variable via js ?-->

    </head>

    <body>