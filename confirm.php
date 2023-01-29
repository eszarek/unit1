<?php

/* 
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  11/18/2022
  * Time:  4:46 PM
*/

$pageName = 'Confirm';
require_once 'header.php';

$status=$_SESSION['status'];

$name=$_SESSION['fname'];

?>
<div id="welcome">
<h3> Welcome <?php echo $name;?></h3>
<p> <?php if ($status==1){
    echo 'You have administrative privileges. <br>';
} ?>Please enjoy the site. When you are finished please log out.</p>


</div>
<?php require_once 'footer.php' ?>