<?php

$pageName = "Register";
require_once "header.php";

//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;
$fnameError = "";
$emailError = "";
$passwordError = "";
$confirmPasswordError = "";

$aboutError = "";

$EmailFail = "An error has happened. Please try again.";





if ($_SERVER['REQUEST_METHOD'] == "POST"){



//sanitize data
  $email = trim (strtolower ($_POST['email']));
  $fname = trim($_POST['fname']);
  //local variables unmodified
  $password = $_POST['password'];

  $about=trim($_POST['about']);
  $pwd2 = $_POST['pwd2'];



  //check empty fields
  if (empty($fname)) {
    $throwError = 1;
    $fnameError = "Please put in name.";
  }
  elseif (strlen($fname)>35){
    $throwError = 1;
    $fnameError = "Names need to be less than 35 characters.";
  }

  if (empty($email)) {
    $throwError = 1;
    $emailError = "Missing Email.";
  } else {
    //validate emails and urls
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $throwError = 1;
      $emailError = "Email is not valid.";
    } else {
      $sql = "SELECT email FROM p1users WHERE email = :field";
      $dupemail = check_duplicates($pdo, $sql, $email);
      if ($dupemail){
        $throwError = 1;
        $emailError = "This email has already been registered with an account.";
      }}
  }

  if (empty($password)) {
    $throwError = 1;
    $passwordError = "Missing Password.";
    $hashpwd ="";

  }
  elseif ((strlen($password)<8) or (strlen($password)>72)){
    $throwError = 1;
    $passwordError = "Password needs to be more than 10 characters and less than 72.";
    $hashpwd="";
  }
  else{
    $hashpwd= password_hash($password, PASSWORD_DEFAULT);
  }
  if (empty($pwd2)) {
    $throwError = 1;
    $confirmPasswordError = "Missing confirmation password.";
  }

  if ($pwd2 !== $password) {
    $throwError = 1;
    $confirmPasswordError = "Confirmation password and original password did not match.";
  }


  if (empty($about)){
    $throwError = 1;
    $aboutError= "Required";
  }

  //control for form
  if ($throwError == 1) {
    echo "<p class='error'> You have an error on the form, please try again.</p>";
  }
  else{
    //post to insert into database
    $sql= "INSERT INTO p1users (email, fname, hashpwd, about, created, updated)
                    VALUES (:email, :fname, :hashpwd, :about, :created, :created)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('email', $email);
    $stmt->bindValue('fname', $fname);
    $stmt->bindValue('hashpwd', $hashpwd);
    $stmt->bindValue('about', $about);
    $stmt->bindValue('created',$dateTime);
    $stmt->bindValue('updated',$dateTime);
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

  <h3> <strong>Registration Form</strong></h3>
  <h4>Please fill out each field, all are required.</h4>
  <form  name="registrationForm" method="post" action="<?php echo ($currentFile);?>">
    <label for="fname"><strong>Name</strong></label><br>
    <input id="fname" name="fname" type="text" value="<?php if (isset($fname)) {echo $fname;}?>">
    <?php if (!empty($fnameError)) {echo "<span class = 'error'>$fnameError</span>";}?>
    <br>

    <label for="email"><strong>Email</strong></label><br>
    <input id="email" name="email" type="email"
           value="<?php if (isset($email)) {echo $email;}?>">
    <?php if (!empty($emailError)) {echo "<span class = 'error'>$emailError</span>";}?>
    <br>

    <label for="password"><strong>Make a password</strong></label><br>
    <input id="password" name="password" type="password">
    <?php if (!empty($passwordError)) {echo "<span class = 'error'>$passwordError</span>";}?>
    <br>
    <label for="pwd2"><strong>Confirm Password:</strong></label><br>
    <input type="password" name="pwd2" id="pwd2" placeholder="Enter password again">
    <?php if (!empty($confirmPasswordError)) {echo "<span class = 'error'>$confirmPasswordError</span>";}?>
    <br>

    <label for="about"><strong>What are you studying?</strong></label> <?php if (isset($aboutError)){
      echo "<span class = 'error'>$aboutError</span>";
    } ?><br>

    <textarea id="about" name="about"><?php if (isset($about)){echo $about;}?></textarea>

    <br>
    <label for="submit">Submit:</label><input id="submit" name="submit" type="submit" value="submit">
  </form>
  <br><br>

  <?php
}//closing if showform


require_once "footer.php";
?>
