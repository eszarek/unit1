<?php
$pageName = "login";
require_once "header.php";


//SET INITIAL VARIABLES

//error flags
$showform = 1; //flag for showform, TRUE
$throwError = 0;

$emailError = "";
$passwordError = "";




if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $email = trim (strtolower ($_POST['email']));
    $password = $_POST['password'];

//sanitize data

    if (empty($email)) {
        $throwError = 1;
        $emailError = "Missing Email.";
    } else {
        //validate emails and urls
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $throwError = 1;
            $emailError = "Email is not valid.";
        }
    }

    if (empty($password)) {
        $throwError = 1;
        $passwordError = "Missing Password.";
        $hashpwd ="";

    }

    if ($throwError == 1) {
        echo "<p class='error'> You have an error on the form, please try again.</p>";
    }
    else {

        //SELECT * FROM users WHERE email = :term

        $sql =  "SELECT * FROM p1users WHERE email LIKE :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            if (password_verify($password, $row['hashpwd'])) {
                // SET SESSION VARIABLES
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['status'] = $row['isAdmin'];

                // REDIRECT TO CONFIRMATION PAGE
                header("Location: confirm.php");
            } else {

                echo '<p class="error">Password is wrong!</p>';}
            }
        else {
            echo '<p class="error">Email is wrong!</p>';

            }
        }



    }
?>


<?php
if($showform==1){

    ?>

    <h1>Login Form</h1>
    <h2>Please fill out each field, all are required.</h2>
    <form method="post" action="<?php echo ($currentFile);?>" name="signin-form">
        <div class="form-element">
            <label for="email"><strong>Email:</strong></label><br>
            <input id="email" name="email" type="email"
                   value="<?php if (isset($email)) {echo $email;}?>">
            <?php if (!empty($emailError)) {echo "<span class = 'error'>$emailError</span>";}?>
            <br>
        </div>
        <div class="form-element">
            <label for="password"><strong>Password:</strong></label><br>
            <input id="password" name="password" type="password">
            <?php if (!empty($passwordError)) {echo "<span class = 'error'>$passwordError</span>";}?>
        </div>
        <button type="submit" name="login" value="login">Log In</button>
    </form>


    <?php
}//closing if showform


require_once "footer.php";
?>

