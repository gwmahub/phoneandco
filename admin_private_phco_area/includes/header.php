<?php 
/*
 * if($_SESSION ok){
 * header
 * }
 * */
?>
<div id="header_deco" class="bloc_deco">
    <div id="header" class="mainBloc">
                    
        <div id="header_bloc1" class="setFloat_l">
            <a href="?p=home">
                <img id="logo" src="img/logo_phoneAndCo_2.png" width="117px" height="73px" alt="logo Phone&Co" />
            </a>
        </div><!--END #header_bloc1-->                                    
        
        <div id="header_bloc2" class="setFloat_l">
        	<?php 
        		if(isset($_SESSION['m_login']) && isset($_SESSION['m_statut'])){
        			include_once('admin_menu.php');
        		}
        	?>
     <div class="clearFloat"> </div>
       </div><!--END #header_bloc2-->
       
       <a id="linkExit" href="?p=admin_unlog" title="EXIT">
       	<img title="EXIT" src="img/disco.jpg" alt="EXIT" />
       </a>
        
     
    <div class="clearFloat"> </div>
    </div><!--END #header-->                       
</div><!--END #header_deco .bloc_deco -->


