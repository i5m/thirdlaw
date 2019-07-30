<?php
require_once('header.php');
if (isset($_COOKIE["loggedin"])) {
    $u = $_COOKIE["username"];
    require_once('welcome.php');
}
else { require_once('index_pen.php'); }
require_once('footer.php');
?>