<?php
if((!isset($_SESSION["m_pseudo"])) || (empty($_SESSION["m_pseudo"])) || (!isset($_SESSION["m_actif"])) || (empty($_SESSION["m_actif"]))){
    header("Location: index.php?p=home");
}

?>
