<?php

/* 
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  12/4/2022
  * Time:  12:41 PM
*/
session_start();
$pageName = "logout";
unset($_SESSION['ID']);
unset($_SESSION['fname']);
unset($_SESSION['status']);

session_destroy();
header("Location: passlogout.php");
?>