<?php
//récup des vars
include_once PATH_CONTROLER.'login_pub.php';

switch($get_lang){
	case "en":
?>
<div id="header_deco" class="bloc_deco">
    <div id="header" class="mainBloc">
                    
        <div id="header_bloc1" class="setFloat_l">
            <a href="?p=home&lang=en">
                <img id="logo" src="img/logo_phoneAndCo_2.png" width="235px" height="155px" alt="logo Phone&Co" />
            </a>
            <label for="search">Are you searching something ?</label>
            
            <div id='cse' style='width: 100%;'>Loading</div>
				<script src='//www.google.com/jsapi' type='text/javascript'></script>
				<script type='text/javascript'>
					google.load('search', '1', {language: 'en', style: ""});//style: google.loader.themes.V2_DEFAULT
					google.setOnLoadCallback(function() {
					  var customSearchOptions = {};
					  var orderByOptions = {};
					  orderByOptions['keys'] = [{label: 'Relevance', key: ''} , {label: 'Date', key: 'date'}];
					  customSearchOptions['enableOrderBy'] = true;
					  customSearchOptions['orderByOptions'] = orderByOptions;
					  customSearchOptions['overlayResults'] = true;
					  var customSearchControl =   new google.search.CustomSearchControl('016869155366384459495:i7gppq3ec_s', customSearchOptions);
					  customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
					  var options = new google.search.DrawOptions();
					  options.setAutoComplete(true);
					  customSearchControl.draw('cse', options);
					}, true);
				</script>

            <!--
            <input id="search" type="text" name="search" value="Search" />
            <input type="submit" name="searchOk" value="OK" />
            -->
        </div><!--END #header_bloc1-->                                    
        
        <div id="header_bloc2" class="setFloat_r">
	    	<a class="setFloat_l mainMenu" title="Multimedia device accessories" href="?lang=en&p=appareil">
	    		Multimedia <br />Devices
	    	</a>
	
	    	<a class="setFloat_l mainMenu" title="New technologies actualities" href="?lang=en&p=articles">
	    		News On New <br />Technologies
	    	</a>
	    	<a href=?lang=fr&p=home title="fr" class="setFloat_l">FR</a>
	    	<a href=?lang=en&p=home title="en" class="setFloat_l">EN</a>
       </div><!--END #header_bloc2-->
       
<?php include_once PATH_VIEW.'login_pub.php';?>

        <div id="advert" class="setFloat_l">
            <a href="#"><img src="<?php echo WWW_IMG."banner_pub_draft.jpg"; ?>" alt="pub" /></a>
        </div>
    <div class="clearFloat"></div>
    </div><!--END #header-->                       
</div><!--END #header_deco .bloc_deco -->
<?php
		break;
		
	default:
?>
<div id="header_deco" class="bloc_deco">
    <div id="header" class="mainBloc">
                    
        <div id="header_bloc1" class="setFloat_l">
            <a href="?p=home">
                <img id="logo" src="img/logo_phoneAndCo_2.png" width="235px" height="155px" alt="logo Phone&Co" />
            </a>
            <label for="search">Vous cherchez quelque chose ?</label>
            <div id='cse' style='width: 100%;'>Loading</div>
				<script src='//www.google.com/jsapi' type='text/javascript'></script>
				<script type='text/javascript'>
					google.load('search', '1', {language: 'en', style: ""});//style: google.loader.themes.V2_DEFAULT
					google.setOnLoadCallback(function() {
					  var customSearchOptions = {};
					  var orderByOptions = {};
					  orderByOptions['keys'] = [{label: 'Relevance', key: ''} , {label: 'Date', key: 'date'}];
					  customSearchOptions['enableOrderBy'] = true;
					  customSearchOptions['orderByOptions'] = orderByOptions;
					  customSearchOptions['overlayResults'] = true;
					  var customSearchControl =   new google.search.CustomSearchControl('016869155366384459495:i7gppq3ec_s', customSearchOptions);
					  customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
					  var options = new google.search.DrawOptions();
					  options.setAutoComplete(true);
					  customSearchControl.draw('cse', options);
					}, true);
				</script>

            
            
            <!--
            <input id="search" type="text" name="search" value="Rechercher" />
            <input type="submit" name="searchOk" value="OK" />
            -->
        </div><!--END #header_bloc1-->                                    
        
        <div id="header_bloc2" class="setFloat_r">
	    	<a class="setFloat_l mainMenu" title="Accessoires Appareils Multimédia" href="?p=appareil">
	    		Appareils <br />Multimédia
	    	</a>
	
	    	<a class="setFloat_l mainMenu" href="?lang=fr&p=articles&action=view" title="Actualités Nouvelles Technologies">
	    		Actualités Nouvelles <br />Technologies
	    	</a>
	
	    	<a href=?lang=fr&p=home title="fr" class="setFloat_l">FR</a>
	    	<a href=?lang=en&p=home title="en" class="setFloat_l">EN</a>
       </div><!--END #header_bloc2-->
       
<?php include_once PATH_VIEW.'login_pub.php';?>

        <div id="advert" class="setFloat_l">
            <a href="#"><img src="<?php echo WWW_IMG."banner_pub_draft.jpg"; ?>" alt="pub" /></a>
        </div>
    <div class="clearFloat"> </div>
    </div><!--END #header-->                       
</div><!--END #header_deco .bloc_deco -->
<?php
		break;
}
?>


