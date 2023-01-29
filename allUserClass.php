<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/18/2023
  * Time:  9:39 AM
*/
require_once "header.php";
require_once "connect.php";
checkLogin();
echo "<a href='addUserClass.php?q=$q'>Add Classes</a></li>";

$uID = $_GET['q'];
$sql = 'SELECT * FROM userclass where uid = :uID';

//prepares a statement for execution
$stmt = $pdo->prepare($sql);
$stmt->bindValue('uID', $uID);


//execute the query
$stmt->execute();

//fetched the next row and returns array
//default: array indexed by column name and o-indexed column header
$result=$stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($result)){
  echo "<p class='error'>Nothing found, please try again. <a href='index.php'>Return to Home</a></p>";
}else {
 echo '<div id=\"allclasses\">
  <table>';

  foreach ($result as $row){
    ?>
    <?php if (!empty($row['cDescription'])) { ?>
    <tr class="collapsible-section-header">

      <td>
      <a class="card-header" data-bs-toggle="collapse" href="#collapse<?php echo$row['courseNumber'];?>"
         role="button" aria-expanded="false" aria-controls="collapseExample">
        <?php echo $row['courseNumber'];?>
        </a>
    </td>
      <td class="collapse-down">
        <a class="card-header collapse-down" data-bs-toggle="collapse" href="#collapse<?php echo$row['courseNumber'];?>"
           role="button" aria-expanded="false" aria-controls="collapseExample">
          <?php echo $row['cName'];?>
        </a>
      </td>
      <td><a style="color: red;" href="delete.php?q=<?php echo $uID;?>&l=<?php echo$row['courseNumber'];?>">X</a> </td>
    </tr>

      <tr class="collapse" id="collapse<?php echo$row['courseNumber'];?>">
        <td class="card card-body" colspan="2" style="table-row">
          <?php echo $row['cDescription'];?>
        </td>
      </tr>
    <?php }


  else{ ?>
    <tr class="collapsible-section-header">
      <td>

        <?php echo $row['courseNumber'];?>

    </td>
      <td>
          <?php echo $row['cName'];?>
      </td>
      <td>
        <a style="color: red;" href="delete.php?q=<?php echo $uID;?>&l=<?php echo$row['courseNumber'];?>">X</a>
      </td>
    </tr>



    <?php
  }//else no desc

  }//close for each
  echo "</table> </div>";
} //close empty else
require_once "footer.php";
?>
