<?php




//----Duplication check--------
function check_duplicates($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field', $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function check_duplicates_per_user($pdo, $sql, $field, $uID) {
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':field', $field);
  $stmt->bindValue(':uID', $uID);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row;
}





//This function checks to see if someone is logged in
function checkLogin()
{
    if (!isset($_SESSION['ID'])) {
        $rightNow = new DateTime();
        echo "<p class='error'>This page requires authentication.  Please log in to view details.</p>";
        require_once "footer.php";
        exit();
    }
    else {return True;}
}

//This function checks to see if a logged-in user is an Admin
function checkAdmin($page='something')
{
    if (!isset($_SESSION['ID']) || ($_SESSION['status']==0)) {
        $rightNow = new DateTime();

        if ($page=='view'){
            echo "<p class='error'>You are not the owner of this file. Please contact your admin.</p>";
        }
        else{echo "<p class='error'>This page requires administrative privileges.</p>";}
        require_once "footer.php";
        exit();
    }
    else {return True;}
}

function checkUserFlag($page='something'){
   if (!isset($_SESSION['ID'])) {
    return False;}
    return true;
}
function checkAdminFlag($page='something'){
    if (!isset($_SESSION['ID']) || ($_SESSION['status']==0)) {

        return False;
    }
    return True;
}


