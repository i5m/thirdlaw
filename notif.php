<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { header("location: login.php"); exit; }
else { $u = $_SESSION["username"]; }
require_once('header.php');
?>
</head>
<body>
    <?php require_once('nav.php'); ?>
    <script>
        $(document).ready(function() {
            $("#navNotif").addClass("activehai");
            $("#navNotif i").removeClass("material-icons-outlined");
            $("#navNotif i").addClass("material-icons");
        });
    </script>

    <?php require_once('footer.php'); ?>