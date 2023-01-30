<?php

session_start();
$pageName = "logout";
unset($_SESSION['ID']);
unset($_SESSION['fname']);
unset($_SESSION['status']);

session_destroy();
header("Location: confirmout.php");
?>


