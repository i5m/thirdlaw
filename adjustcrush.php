<?php
if (!isset($_COOKIE["loggedin"])) {
    header("location: login.php");
    exit;
}
else {
    $u = $_COOKIE["username"];
    require_once('config.php');
    
    $myCrush = $_POST["myCrush"];

    if(isset($_POST["addCrushBtn"])) {
        $sqlAddDelete = "INSERT INTO crushes (user, crush) VALUES ('$u', '$myCrush')";
    }
    if(isset($_POST["deleteCrushBtn"])) {
        $sqlAddDelete = "DELETE FROM crushes WHERE user='$u' AND crush='$myCrush'";
    }
    
    if ($link->query($sqlAddDelete) === TRUE) {
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Error updating record: " . $link->error;
    }
    
    $link->close();
}
?>