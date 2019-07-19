<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { header("location: /"); exit; }
else { $u = $_SESSION["username"]; }
require_once('../header.php');
$navLeft = '<b style="font-size: 24px; vertical-align: middle;">Custom</b>';
?>
<?php
$sqlWhom = "SELECT id, fullname, username, ploc, last_active FROM users WHERE username='$u'";
$resultWhom = $link->query($sqlWhom);
$rowWhom = mysqli_fetch_array($resultWhom);
?>
<style>
    
</style>
</head>

<body>

    <?php require_once('nav.php'); ?>

    <div class="container"><br/>
        
    </div>

    <?php require_once('../footer.php'); ?>