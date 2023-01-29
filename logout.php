<?php

/* 
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  11/18/2022
  * Time:  4:32 PM
*/
session_start();
$pageName = "logout";
unset($_SESSION['ID']);
unset($_SESSION['fname']);
unset($_SESSION['status']);

session_destroy();
header("Location: confirmout.php");
?>


