<?php


$pageName = "Update Password";
require_once "header.php";
//checkAdmin();



//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;
$passwordError = "";



//receive Get id from header
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {$ID = $_GET['q'];
} elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])) {$ID = $_POST['ID'];
} else {
  echo "<p class='error'>Unable to process, please contact Erinn Szarek</p>";
  $throwError = 1;
  require_once "footer.php";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $password = $_POST['password'];
  $pwd2 = $_POST['pwd2'];
  $passlogout=0;
  $email = trim (strtolower ($_POST['email']));
  $fname = trim($_POST['fname']);
  //var_dump($_POST);


//sanitize data

  if (empty($password)) {
    $throwError = 1;
    $passwordError = "Missing Password.";
    $hashpwd ="";

  }
  elseif ((strlen($password)<8) or (strlen($password)>72)){
    $throwError = 1;
    $passwordError = "Password needs to be more than 8 characters and less than 72.";
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


  //control for form
  if ($throwError == 1) {
    echo "<p class='error'> You have an error on the form, please try again.</p>";
  }

  else {

    //post to insert into database
    $sql = "UPDATE p1users SET hashpwd = :hashpwd, updated = :updated where ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('hashpwd', $hashpwd);
    $stmt->bindValue(':ID', $ID);
    $stmt->bindValue(':updated', $dateTime);
    $stmt->execute();


      // REDIRECT TO CONFIRMATION PAGE
      header("Location: passwordPost.php");
    }

}

if($showform==1){
  $sql = "SELECT * from p1users WHERE ID = :ID";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':ID', $ID);  //$ID comes from my tracking ID
  $stmt->execute();
  $row = $stmt->fetch();
  if (!isset($email)) {$email =htmlspecialchars($row['email']);}
  if (!isset($fname)) {$fname=htmlspecialchars($row['fname']);}
  ?>
  <h4> <strong>Change your password </strong></h4>
  <h5>Once changed, you will be automatically logged out</h5>
  <form  name="changepass" id="changepass" method="post" action="<?php echo ($currentFile);?>">
    <label for="password"><strong>New Password:</strong></label><br>
    <input id="password" name="password" type="password" placeholder="Minimum 8 characters">
    <?php if (!empty($passwordError)) {echo "<span class = 'error'>$passwordError</span>";}?>
    <br>
    <label for="pwd2"><strong>Confirm Password:</strong></label><br>
    <input type="password" name="pwd2" id="pwd2" >
    <?php if (!empty($confirmPasswordError)) {echo "<span class = 'error'>$confirmPasswordError</span>";}?>
    <br>

    <input type="hidden" name="ID"
           value="<?php echo $row['ID'];?>">

    <input type="hidden" name="email" value="<?php echo $row['email'];?>">
    <input type="hidden" name="fname" value="<?php echo $row['fname'];?>">

    <br>
    <label for="submit">Submit:</label>
    <input id="submit" name="submit" type="submit" value="submit">
  </form>
  <?php
}//closing if showform


require_once "footer.php";
?>

