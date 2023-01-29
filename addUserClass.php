<?php

/*
  * Class: csci330fa22
  * User:  eeszarek
  * Date:  1/29/2023
  * Time:  8:57 AM
*/
$pageName = "Register";
require_once "header.php";
checkLogin();
//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;
$cNumberError = "";
$cNameError = "";
$cDescriptionError = "";

$uID=$_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] == "POST"){


  $courseNumber = trim (htmlspecialchars ($_POST['courseNumber']));
  $cName = trim (htmlspecialchars ($_POST['cName']));
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cDescription'])) {

  $cDescription = trim (htmlspecialchars ($_POST['cDescription']));}

  //check empty fields
  if (empty($courseNumber)) {
    $throwError = 1;
    $cNumberError = "Please put in a number for the course.";
  } else {
    $sql = "SELECT courseNumber FROM userclass WHERE courseNumber = :field AND uID = :uID";
    $dupeTag = check_duplicates_per_user($pdo, $sql, $courseNumber, $uID);
    if ($dupeTag){
      $throwError = 1;
      $cNumberError = "This course Number already exists.";
    }}



  //check empty fields
  if (empty($cName)) {
    $throwError = 1;
    $cNameError = "Please put in a name for the course.";
  } else {
    $sql = "SELECT cName FROM userclass WHERE cName = :field AND uID = :uID";
    $dupeTag = check_duplicates_per_user($pdo, $sql, $cName, $uID);
    if ($dupeTag){
      $throwError = 1;
      $cNameError = "This course name already exists.";
    }}


  //control for form
  if ($throwError == 1) {
    echo "<p class='error'> You have an error on the form, please try again.</p>";
  }
  else if (isset($cDescription)) {
    //post to insert into database
    $sql= "INSERT INTO userclass (uID, courseNumber, cName, cDescription)
                    VALUES (:uID, :courseNumber, :cName, :cDescription)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('uID', $uID);
    $stmt->bindValue('courseNumber', $courseNumber);
    $stmt->bindValue('cName', $cName);
    $stmt->bindValue('cDescription', $cDescription);
    $stmt->execute();

    //let user know about the status
    echo  "<p class= 'success'> Information received. Thank you.</p><br>
            <a href=\"addUserClass.php\">Add another</a></div>";

    //form status
    $showform = 0;
   }
   else {
       //post to insert into database
       $sql= "INSERT INTO userclass (uID, courseNumber, cName)
                    VALUES (:uID, :courseNumber, :cName)";
       $stmt = $pdo->prepare($sql);
       $stmt->bindValue('uID', $uID);
       $stmt->bindValue('courseNumber', $courseNumber);
       $stmt->bindValue('cName', $cName);
       $stmt->execute();

       //let user know about the status
       echo  "<p class= 'success'> Information received. Thank you.</p><br>
                <a href=\"addUserClass.php\">Add another</a></div>";

       //form status
       $showform = 0;
     }
}
?>

<?php
if($showform==1){

  ?>

  <h3> <strong>Add a new class to your list</strong></h3>

  <form  name="addClass" method="post" action="<?php echo ($currentFile);?>">
    <label for="courseNumber"><strong>Course Number *</strong></label><br>
    <p> Example: CLASS*101*01</p>
    <input id="courseNumber" name="courseNumber" type="text" value="<?php if (isset($courseNumber)) {echo $courseNumber;}?>">
    <?php if (!empty($cNumberError)) {echo "<span class = 'error'>$cNumberError</span>";}?>
    <br><br>

    <label for="cName"><strong>Course Name *</strong></label><br>
    <input id="cName" name="cName" type="text" value="<?php if (isset($cName)) {echo $cName;}?>">
    <?php if (!empty($cNameError)) {echo "<span class = 'error'>$cNameError</span>";}?>
    <br><br>

    <label for="cDescription"><strong>Course Description</strong></label><br>
    <input id="cDescription" name="cDescription" type="text" value="<?php if (isset($cDescription)) {echo $cDescription;}?>">
    <?php if (!empty($cDescriptionError)) {echo "<span class = 'error'>$cDescriptionError</span>";}?>
    <br><br>

    <label for="submit">Submit:</label><input id="submit" name="submit" type="submit" value="submit">
  </form>
  <br><br>

  <?php
}//closing if showform


require_once "footer.php";
?>

