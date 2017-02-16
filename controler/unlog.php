<?php
include_once(PATH_BASE."protect_membre_pub.php");
include_once(PATH_LIBS."lib_login.php");
$disconnect = unlog();
header("location:index.php?p=home");
?>
