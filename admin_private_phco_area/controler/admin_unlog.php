<?php
include_once(PATH_BASE."protect_admin.php");
include_once(PATH_LIBS."lib_admin_login.php");
$disconnect = unlog();
header("location:index.php?p=login_admin");
?>
