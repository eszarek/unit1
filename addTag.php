<?php

$pageName = "Register";
require_once "header.php";
checkLogin();
//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;
$tagError = "";
$userID=$_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] == "POST"){


  $tagSubject = trim (htmlspecialchars ($_POST['tagSubject']));

  //check empty fields
  if (empty($tagSubject)) {
    $throwError = 1;
    $tagError = "Please put in a tag.";
  } else {
    $sql = "SELECT tagSubject FROM userTags WHERE tagSubject = :field";
    $dupeTag = check_duplicates($pdo, $sql, $tagSubject);
    if ($dupeTag){
      $throwError = 1;
      $tagError = "This tag already exists.";
    }}
  //control for form
  if ($throwError == 1) {
    echo "<p class='error'> You have an error on the form, please try again.</p>";
  }
  else{
    //post to insert into database
    $sql= "INSERT INTO userTags (userID, tagSubject)
                    VALUES (:userID, :tagSubject)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('userID', $userID);
    $stmt->bindValue('tagSubject', $tagSubject);
    $stmt->execute();

    //let user know about the status
    echo  "<p class= 'success'> Information received. Thank you.</p>";

    //form status
    $showform = 0;
   }


}
?>

<?php
if($showform==1){

  ?>

  <h3> <strong>Add a new subject tag</strong></h3>

  <form  name="addTag" method="post" action="<?php echo ($currentFile);?>">
    <label for="tagSubject"><strong>Tag</strong></label><br>
    <input id="tagSubject" name="tagSubject" type="text" value="<?php if (isset($tagSubject)) {echo $tagSubject;}?>">
    <?php if (!empty($tagError)) {echo "<span class = 'error'>$tagError</span>";}?>
    <br>

    <label for="submit">Submit:</label><input id="submit" name="submit" type="submit" value="submit">
  </form>
  <br><br>

  <?php
}//closing if showform


require_once "footer.php";
?>
