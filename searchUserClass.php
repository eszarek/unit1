<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/18/2023
  * Time:  9:39 AM
*/
$currentFile = basename($_SERVER['SCRIPT_FILENAME']);

require_once "header.php";
require_once "connect.php";
checkLogin();

echo "<a href='addUserClass.php?q=$q'>Add Classes</a></li>";

// ---------------------------Class Search ------------------------------//
?>
<h3> Search Classes:</h3>

<form name="classSearch" id="classSearch" method="post" action="<?php echo $currentFile;?>"
    <label for="courseNumber">Course Number:</label><br>
    <input type="search" id="courseNumber" name="courseNumber"><br>
    <label for="cName">Class Name:</label><br>
    <input type="search" id="cName" name="cName"><br><br>
    <input type="submit" id="search" name="search" value="Search">
</form>
<?php
//------------------- if search is posted -----------------//
if (isset($_POST['courseNumber']) or isset($_POST['cName'])) {

    // Get the search terms from the form
    $courseNumber = trim(htmlspecialchars($_POST['courseNumber']));
    $cName = trim(htmlspecialchars($_POST['cName']));

    // Check if the courseNumber or cName are empty
    if (empty($courseNumber) or empty($cName)) {
        // Display an error message if either are empty
        echo "<p class='error'> Please enter either a Course Number and Name to search for.</p>";
    } else {

        //select from database

        $sql = "SELECT * FROM userclass WHERE courseNumber LIKE '%$courseNumber%' AND cName LIKE '%$cName%' order by courseNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':courseNumber', $courseNumber);
        $stmt->bindValue(':cName', $cName);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if(empty($result)){
            echo "<p class='error'>Nothing found for '" . trim(htmlspecialchars($_POST['courseNumber'])) .  trim(htmlspecialchars($_POST['cName'])) . "', please try again</p>";
        }else {
            echo "<p class='success'>Search was successful.</p>";

            foreach ($result as $row) {
                ?>
                <tr>
                    <td>

                        <?php echo $row['courseNumber'];?><br>

                    </td>
                </tr>
                <br><br>
                <?php
            }//close for each
        }//close else
    }//close not empty else
}//close if isset
//----------------------- else all classes ------------------------------//
else{
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
}
else {
 echo '<div id=\"allclasses\">
  <table>';

  foreach ($result as $row){
    ?>
    <?php if (!empty($row['ccName'])) { ?>
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
          <?php echo $row['ccName'];?>
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
}
require_once "footer.php";
?>
