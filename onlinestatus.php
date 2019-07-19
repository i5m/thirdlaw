<?php
    session_start();
    if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
        $onlineUser = $_SESSION["username"];
        require_once('config.php');
        if($_REQUEST['action'] == "stayOnline") {
            date_default_timezone_set('Asia/Kolkata');
            $onlineTime = Date("d-m-Y, H:i");
            $sqlUpdateOnlineStatus = "UPDATE users SET last_active='$onlineTime' WHERE username='$onlineUser'";
            if ($link->query($sqlUpdateOnlineStatus) === TRUE) { }
            else { echo "Error updating record: " . $link->error; }
        }
    }
?>