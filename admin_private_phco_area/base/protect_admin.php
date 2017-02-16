<?php
if((!isset($_SESSION["m_login"])) || (empty($_SESSION["m_login"])) || (!isset($_SESSION["m_statut"])) || (empty($_SESSION["m_statut"]))){
        
    header("Location: index.php?p=login_admin");
}

?>
