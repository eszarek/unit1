<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/18/2023
  * Time:  9:39 AM
*/
require_once "header.php";
require_once "connect.php";

$sql = 'SELECT * FROM class';

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
 echo '<div id=\"allClasses\">
  <table>';

  foreach ($result as $row){
    ?>
    <?php if (!empty($row['CDescription'])) { ?>

    <tr class="collapsible-section-header">
      <td>
      <a class="card-header" data-bs-toggle="collapse" href="#collapse<?php echo$row['CourseNumber'];?>"
         role="button" aria-expanded="false" aria-controls="collapseExample">
        <?php echo $row['CourseNumber'];?>
        </a>
    </td>
      <td class="collapse-down">
        <a class="card-header collapse-down" data-bs-toggle="collapse" href="#collapse<?php echo$row['CourseNumber'];?>"
           role="button" aria-expanded="false" aria-controls="collapseExample">
          <?php echo $row['CName'];?>
        </a>
      </td>
    </tr>

      <tr class="collapse" id="collapse<?php echo$row['CourseNumber'];?>">
        <td class="card card-body" colspan="2" style="table-row">
          <?php echo $row['CDescription'];?>
        </td>
      </tr>
    <?php }


  else{ ?>
    <tr class="collapsible-section-header">
      <td>

        <?php echo $row['CourseNumber'];?>

    </td>
      <td>
          <?php echo $row['CName'];?>
      </td>
    </tr>



    <?php
  }//else no desc

  }//close for each
  echo "</table> </div>";
} //close empty else
require_once "footer.php";
?>
