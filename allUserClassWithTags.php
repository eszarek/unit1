<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/18/2023
  * Time:  9:39 AM
*/
require_once "header.php";
require_once "connect.php";
//-----------------first query all classes
$uID = 1;




$sql =
    'SELECT `userclass`.`courseNumber`, `userclass`.`cName`, `userTags`.`tagSubject` 
    FROM `userclass`
        LEFT JOIN `class_tags` ON `class_tags`.`CourseNumber` = `userclass`.`courseNumber`
        LEFT JOIN `userTags` ON `class_tags`.`tagID` = `userTags`.`tagID`
    where userclass.uid = :uID';
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
$stmt->bindValue('uID', $uID);


//execute the query
$stmt->execute();

//fetched the next row and returns array
//default: array indexed by column name and o-indexed column header
$result=$stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
echo "<p>";
foreach ($result as $key => $value){
    echo $key . "\n";
    foreach ($value as $sub_key => $sub_val){
        if (is_array($sub_val)) {

            foreach ($sub_val as $k => $v) {
                echo "&nbsp" . " = " . $v . "<br>";
            }
        } else {
            echo $sub_key . " = " . $sub_val . "<br>";
        }
    }
}

echo "</p>";





echo "<pre>";
var_dump($result);
echo "</pre>";/*
$sql =
'SELECT `userclass`.`courseNumber`, `userclass`.`cName`, `userTags`.`tagSubject` 
    FROM `userclass`
        LEFT JOIN `class_tags` ON `class_tags`.`CourseNumber` = `userclass`.`courseNumber`
        LEFT JOIN `userTags` ON `class_tags`.`tagID` = `userTags`.`tagID`
    where userclass.uid = :uID';
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
$stmt->bindValue('uID', $uID);


//execute the query
$stmt->execute();

//fetched the next row and returns array
//default: array indexed by column name and o-indexed column header
$result=$stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

echo "<pre>";
var_dump($result);
echo "</pre>";

if(empty($result)){
  echo "<p class='error'>Nothing found, please try again. <a href='index.php'>Return to Home</a></p>";
}else { ?>
<div id="classTags">
  <table>
<tr><th>Course Number</th><th>Course Name</th><th>Tags</th></tr>'

  <?php foreach ($result as $resultClassNumber => $rClassNames) : ?>
                <tr>
                    <td>
                        <?php echo $resultClassNumber; ?>

                    </td>

                    <?php foreach ($rClassNames as $rClass) : ?>
                    <td>

                        <?php echo $rClass['cName'];?>

                    </td>
                    <?php foreach ($rClass as $rclasstags=> $tagged) : ?>
                    <td>
                        <?php
                         echo $tagged['tagSubject'] ?>

                        <?php endforeach; ?>
                    </td>

                    <?php endforeach; ?>

                </tr>
  <?php endforeach; ?>
    <?php }

  echo "</table> </div>";
 //close empty else
require_once "footer.php";
?>
