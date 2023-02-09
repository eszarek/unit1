<?php

$pageName = "Delete";
require_once "header.php";
//form control

checkLogin();

//processing url passed information: l: classID, q: uID (owner id for the class)
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['l'])) {
    $tagID = trim(htmlspecialchars($_GET['l']));
    $uID = trim(htmlspecialchars($_GET['q']));
    $showform = 1;}
  else {
    $showform = 0;

  }


//if form processed delete the data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "DELETE FROM userTags WHERE tagID= :tagID AND uID = :uID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':tagID', $_POST['tagID']);
    $stmt->bindValue(':uID', $_POST['uID']);
    $stmt->execute();
    $deleted = $stmt->rowCount();
    //hide form
    $showform = 0;
    if(empty($deleted)){
        echo "<p class='error'>Nothing found, please try again. <a href='AllTags.php'>Return to tags.</a></p>";
    }else

    //confirm deletion
    echo "<p class='success'>Tag deleted. <a href='AllTags.php'>Return to tags.</a></p>";

}
if ($showform == 1) {
    ?>
<p>Please confirm that you want to delete this tag. </p>
    <i>You will not be able to undo this action</i>
    <form id="delete" name="delete" method="post" action="<?php echo $currentFile; ?>">
        <input type="hidden" name="tagID" id="tagID" value="<?php echo $_GET['l']; ?>">
        <input type="hidden" name="uID" id="uID" value="<?php echo $_GET['q']; ?>">
        <input type="submit" name="confirm_deletion" id="confirm_deletion" value="DELETE">
    </form>

    <?php
}//end show form
    require_once "footer.php";
