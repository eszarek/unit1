<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/18/2023
  * Time:  9:39 AM
*/
require_once "header.php";
require_once "connect.php";
$sql = 'SELECT * FROM Tags';

//prepares a statement for execution

$stmt = $pdo->prepare($sql);

//execute the query
$stmt->execute();

//fetched the next row and returns array
//default: array indexed by column name and o-indexed column header
$result=$stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($result)){
  echo "<p class='error'>Nothing found, please try again. <a href='index.php'>Return to Home</a></p>";
}else {

  ?>

  <h2>Tags</h2>
  <div class="row-cols-md-3" role="group">

  <?php
  foreach ($result as $row){

    ?>
  <div class="btn-group btn-group-md tagButton" role="group" aria-label="Medium button group">
  <button type="button" class="btn btn-danger">X</button>
  <button type="button" class="btn btn-dark "><?php echo $row['Subject'];?></button>
  <button type="button" class="btn btn-success " href="update.php?q=<?php echo $row['emp_no'];?>">Update</button>
  </div>
    <?php
  }//close for each
  echo "</div>";
} //close else
require_once "footer.php";
?>
