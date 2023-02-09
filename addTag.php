<?php

$pageName = "Register";
require_once "header.php";
checkLogin();
//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;
$tagError = "";
$uID=$_SESSION['ID'];

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
    $sql= "INSERT INTO userTags (uID, tagSubject)
                    VALUES (:uID, :tagSubject)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('uID', $uID);
    $stmt->bindValue('tagSubject', $tagSubject);
    $stmt->execute();

    //let user know about the status
    echo  "<p class= 'success'> Tag $tagSubject added. Thank you.</p>";

    //form status
    $showform = 1;
   }


}
?>

<?php
if($showform==1){

  ?>

  <h5> <strong>Add a new subject tag</strong></h5><br>

  <form  name="addTag" method="post" action="<?php echo ($currentFile);?>">
    <label for="tagSubject"><strong>Tag</strong></label><br>
      <br>
    <input id="tagSubject" name="tagSubject" type="text" value="">
    <?php if (!empty($tagError)) {echo "<span class = 'error'>$tagError</span>";}?>
    <br><br>

    <label for="submit">Submit:&nbsp;</label><input id="submit" name="submit" type="submit" value="Add Tag"">
  </form>
  <br><br>

  <?php
}//closing if showform

require_once "AllTags.php";
require_once "footer.php";
?>
