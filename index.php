<?php
require_once('header.php');
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $u = $_SESSION["username"];
    require_once('welcome.php');
}
else { require_once('index_pen.php'); }
require_once('footer.php');
?>