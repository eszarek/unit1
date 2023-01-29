<?php

$pageName = "Delete";
require_once "header.php";
//form control

checkLogin();

//processing url passed information: l: classID, q: uID (owner id for the class)
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['l'])) {
    $courseNumber = trim(htmlspecialchars($_GET['l']));
    $uID = trim(htmlspecialchars($_GET['q']));
    $showform = 1;}
  else {
    $showform = 0;

  }


//if form processed delete the data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "DELETE FROM userclass WHERE courseNumber= :courseNumber AND uID = :uID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':courseNumber', $_POST['courseNumber']);
    $stmt->bindValue(':uID', $_POST['uID']);
    $stmt->execute();
    $deleted = $stmt->rowCount();
    //hide form
    $showform = 0;
    if(empty($deleted)){
        echo "<p class='error'>Nothing found, please try again. <a href='allUserClass.php'>Return to classes.</a></p>";
    }else

    //confirm deletion
    echo "<p class='success'>Class deleted.</p>";

}
if ($showform == 1) {
    ?>
<p>Please confirm that you want to delete this class: <strong><?php echo $courseNumber;?></strong></p>
    <i>You will not be able to undo this action</i>
    <form id="delete" name="delete" method="post" action="<?php echo $currentFile; ?>">
        <input type="hidden" name="courseNumber" id="courseNumber" value="<?php echo $_GET['l']; ?>">
        <input type="hidden" name="uID" id="uID" value="<?php echo $_GET['q']; ?>">
        <input type="submit" name="confirm_deletion" id="confirm_deletion" value="DELETE">
    </form>

    <?php
}//end show form
    require_once "footer.php";
